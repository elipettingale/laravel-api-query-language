<?php

namespace EliPett\ApiQueryLanguage\Mutations;

use Illuminate\Database\Eloquent\Builder;
use EliPett\ApiQueryLanguage\Contracts\Mutation;

class WhereMutation implements Mutation
{
    private $attribute;
    private $comparison;
    private $value;

    public function __construct(array $args)
    {
        $this->attribute = array_get($args, 'attribute');
        $this->comparison = array_get($args, 'comparison', '=');
        $this->value = array_get($args, 'value');
    }

    public function mutate(Builder $query): Builder
    {
        return $query->where($this->attribute, $this->comparison, $this->value);
    }
}
