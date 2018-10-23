<?php

namespace EliPett\ApiQueryLanguage\Mutations;

use EliPett\ApiQueryLanguage\Contracts\Mutation;
use EliPett\ApiQueryLanguage\Services\Mutate;
use Illuminate\Database\Eloquent\Builder;

class WhereHasMutation implements Mutation
{
    private $relation;
    private $mutations;

    public function __construct(array $args)
    {
        $this->relation = array_get($args, 'relation');
        $this->mutations = array_get($args, 'mutations', []);
    }

    public function mutate(Builder $query): Builder
    {
        return $query->whereHas($this->relation, function(Builder $query) {
            foreach ($this->mutations as $mutation) {
                Mutate::query($query, $mutation);
            }
        });
    }
}
