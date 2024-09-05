<?php

use GraphQL\Type\Definition\Type;

$mutationFields = [
    'sum' => [
        'type' => Type::int(),
        'args' => [
            'x' => ['type' => Type::int()],
            'y' => ['type' => Type::int()],
        ],
        'resolve' => static fn ($calc, array $args): int => $args['x'] + $args['y'],
    ],
];