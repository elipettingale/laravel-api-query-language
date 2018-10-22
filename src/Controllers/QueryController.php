<?php

namespace EliPett\ApiQueryLanguage\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class QueryController extends Controller
{
    private $entity;
    private $mutations;

    private $cache;

    public function __construct(Request $request)
    {
        $this->entity = $request->get('entity');
        $this->mutations = $request->get('mutations', []);

        $this->cache = [
            'key' => $this->generateCacheKey($request->all()),
            'duration' => $request->get('cache.duration'),
            'tags' => $request->get('cache.tags')
        ];
    }

    public function handle(): JsonResponse
    {
        try {

            if ($results = $this->query()) {
                return new JsonResponse([
                    'success' => true,
                    'results' => $results
                ]);
            }

            return new JsonResponse([
                'success' => true,
                'message' => 'No results were found.'
            ]);

        } catch (\Exception $exception) {
            return new JsonResponse([
                'success' => true,
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function query(): bool
    {
        if (!class_exists($this->entity)) {
            throw new \InvalidArgumentException("Entity class ({$this->entity}) does not exist.");
        }

        $query = $this->entity::query();

        // todo: run mutations
        // todo: run transformers (may need to create a transformer path factory class that can be overwritten)
        // todo: cache results
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

        cache()->tags($this->cache['tags'])
            ->put($this->cache['key'], $results, $this->cache['duration']);
    }

    private function generateCacheKey(array $data): string
    {
        return md5(json_encode($data));
    }
}
