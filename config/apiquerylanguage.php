<?php

return [

    'api_prefix' => 'api',

    'mutations' => [
        'WhereHas' => \EliPett\ApiQueryLanguage\Mutations\WhereHasMutation::class,
        'Where' => \EliPett\ApiQueryLanguage\Mutations\WhereMutation::class,
        'WithCount' => \EliPett\ApiQueryLanguage\Mutations\WithCountMutation::class,
        'With' => \EliPett\ApiQueryLanguage\Mutations\WithMutation::class
    ]

];
