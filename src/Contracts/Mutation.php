<?php

namespace EliPett\ApiQueryLanguage\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface Mutation
{
    public function __construct(array $args);
    public function mutate(Builder $query): Builder;
}
