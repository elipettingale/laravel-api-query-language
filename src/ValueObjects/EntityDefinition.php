<?php

namespace EliPett\ApiQueryLanguage\ValueObjects;

class EntityDefinition
{
    public $entityPath;

    private $transformerPath;
    private $permissionCallback;

    public function __construct($entityPath, $transformerPath, $permissionCallback)
    {
        $this->entityPath = $entityPath;
        $this->transformerPath = $transformerPath;
        $this->permissionCallback = $permissionCallback;
    }

    public function getTransformerPath(): string
    {
        return $this->transformerPath;
    }

    public function authorize(): bool
    {
        return \call_user_func($this->permissionCallback);
    }
}
