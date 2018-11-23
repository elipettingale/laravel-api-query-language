<?php

return [

    'api_url' => 'api/query',

    'mutations' => [
        'WhereHas' => \EliPett\ApiQueryLanguage\Mutations\WhereHasMutation::class,
        'Where' => \EliPett\ApiQueryLanguage\Mutations\WhereMutation::class,
        'WithCount' => \EliPett\ApiQueryLanguage\Mutations\WithCountMutation::class,
        'With' => \EliPett\ApiQueryLanguage\Mutations\WithMutation::class
    ]

];
