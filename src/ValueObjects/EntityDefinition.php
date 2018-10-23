<?php

namespace EliPett\ApiQueryLanguage\ValueObjects;

class EntityDefinition
{
    public $entityPath;

    private $transformerPath;
    private $permissionCallback;

    public function __construct(array $data)
    {
        $this->entityPath = array_get($data, 'entity_path');
        $this->transformerPath = array_get($data, 'transformer_path');
        $this->permissionCallback = array_get($data, 'permission_callback');
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
