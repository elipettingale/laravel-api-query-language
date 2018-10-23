<?php

namespace EliPett\ApiQueryLanguage\Controllers;

use EliPett\ApiQueryLanguage\Services\ApiQueryLanguage;
use EliPett\ApiQueryLanguage\Traits\RunsMutations;
use EliPett\EntityTransformer\Services\Transform;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class QueryController extends Controller
{
    use RunsMutations;

    private $apiQueryLanguage;

    private $entityPath;
    private $mutations;
    private $cache;

    public function __construct(Request $request, ApiQueryLanguage $apiQueryLanguage)
    {
        $this->apiQueryLanguage = $apiQueryLanguage;

        $this->entityPath = $request->get('entity');
        $this->mutations = $request->get('mutations', []);

        $cache = $request->get('cache');

        $this->cache = [
            'key' => $this->generateCacheKey($request->all()),
            'duration' => array_get($cache, 'duration'),
            'tags' => array_get($cache, 'tags', [])
        ];
    }

    public function handle(): JsonResponse
    {
        try {

            if ($results = $this->getCachedResults()) {
                return new JsonResponse([
                    'success' => true,
                    'results' => $results
                ]);
            }

            $results = $this->query();
            $this->cacheResults($results);

            return new JsonResponse([
                'success' => true,
                'results' => $results
            ]);

        } catch (\Exception $exception) {
            return new JsonResponse([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException | \InvalidArgumentException
     */
    public function query(): array
    {
        if (!class_exists($this->entityPath)) {
            throw new \InvalidArgumentException("Entity class ({$this->entityPath}) does not exist.");
        }

        if (!$entityDefinition = $this->apiQueryLanguage->find($this->entityPath)) {
            throw new \InvalidArgumentException("Entity ({$this->entityPath}) is not registered.");
        }

        if (!$entityDefinition->authorize()) {
            throw new AuthorizationException("You do not have permission to query this entity");
        }

        $query = $this->entityPath::query();
        $query = $this->runMutations($this->mutations, $query);

        return Transform::entities($query->get(), $entityDefinition->getTransformerPath());
    }

    /** @throws \Exception */
    public function getCachedResults(): ?array
    {
        if (cache()->tags($this->cache['tags'])->has($this->cache['key'])) {
            return cache()->tags($this->cache['tags'])->get($this->cache['key']);
        }

        return null;
    }

    /**
     * @param array $results
     * @throws \Exception
     */
    public function cacheResults(array $results): void
    {
        if ($this->cache['duration'] === null) {
            cache()->tags($this->cache['tags'])
                ->rememberForever($this->cache['key'], function() use ($results) {
                    return $results;
                });

            return;
        }

        if ($this->cache['duration'] === 0) {
            return;
        }

        cache()->tags($this->cache['tags'])
            ->put($this->cache['key'], $results, $this->cache['duration']);
    }

    private function generateCacheKey(array $data): string
    {
        return md5(json_encode($data));
    }
}
