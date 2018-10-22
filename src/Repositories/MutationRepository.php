<?php

namespace EliPett\ApiQueryLanguage\Repositories;

use EliPett\ApiQueryLanguage\Contracts\Mutation;

class MutationRepository
{
    public function find(string $path): ?Mutation
    {
        // todo: load mutation paths from config
        // return instance of file if real else return null

        return null;
    }
}
