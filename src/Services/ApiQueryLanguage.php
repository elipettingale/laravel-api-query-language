<?php

namespace EliPett\ApiQueryLanguage\Services;

use EliPett\ApiQueryLanguage\ValueObjects\EntityDefinition;

class ApiQueryLanguage
{
    private $entities;

    public function __construct()
    {
        $this->entities = collect();
    }

    public function register(array $data): void
    {
        $this->entities->push(new EntityDefinition($data));
    }

    public function find(string $entityPath): ?EntityDefinition
    {
        return $this->entities->where('entityPath', $entityPath)
            ->first();
    }
}
