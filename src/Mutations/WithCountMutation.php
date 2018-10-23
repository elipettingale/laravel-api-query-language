<?php

namespace EliPett\ApiQueryLanguage\Mutations;

use EliPett\ApiQueryLanguage\Contracts\Mutation;
use Illuminate\Database\Eloquent\Builder;

class WithCountMutation implements Mutation
{
    private $relations;

    public function __construct(array $args)
    {
        $this->relations = array_get($args, 'relations');
    }

    public function mutate(Builder $query): Builder
    {
        return $query->withCount($this->relations);
    }
}
