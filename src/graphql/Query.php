<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Error\Debug;

try {
    $schema = require __DIR__ . '/schema.php';

    $rawInput = file_get_contents('php://input');
    $input = json_decode($rawInput, true);
    $query = $input['query'];
    $variableValues = isset($input['variables']) ? $input['variables'] : null;

    $rootValue = [];
    $result = GraphQL::executeQuery($schema, $query, $rootValue, null, $variableValues);
    $output = $result->toArray(Debug::INCLUDE_DEBUG_MESSAGE);
} catch (\Exception $e) {
    $output = [
        'errors' => [
            [
                'message' => $e->getMessage(),
            ],
        ],
    ];
}

header('Content-Type: application/json');
echo json_encode($output);