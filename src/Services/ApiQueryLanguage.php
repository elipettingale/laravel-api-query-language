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

    public function register(EntityDefinition $entityDefinition): void
    {
        $this->entities->push($entityDefinition);
    }

    public function find(string $entityPath): ?EntityDefinition
    {
        return $this->entities->where('entityPath', $entityPath)
            ->first();
    }
}
