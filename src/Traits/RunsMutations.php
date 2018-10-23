<?php

namespace EliPett\ApiQueryLanguage\Traits;

use EliPett\ApiQueryLanguage\Contracts\Mutation;
use Illuminate\Database\Eloquent\Builder;

trait RunsMutations
{
    protected function runMutations(array $mutations, Builder $query): Builder
    {
        foreach ($mutations as $mutation) {
            $query = $this->runMutation($mutation['key'], $mutation['args'], $query);
        }

        return $query;
    }

    protected function runMutation(string $key, array $args, Builder $query): Builder
    {
        if (!$class = config('apiquerylanguage.mutations.' . upper_camel_case($key))) {
            throw new \InvalidArgumentException("Mutation path for key ($key) was not found.");
        }

        $mutation = $this->getMutationInstance($class, $args);

        return $mutation->mutate($query);
    }

    protected function getMutationInstance(string $class, array $args): Mutation
    {
        if (!class_exists($class)) {
            throw new \InvalidArgumentException("Class ($class) does not exist.");
        }

        if (!\in_array(Mutation::class, class_implements($class), true)) {
            throw new \InvalidArgumentException("Class ($class) is not a valid mutation.");
        }

        return new $class($args);
    }
}
