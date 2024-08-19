<?php

namespace App\Controllers;

use App\graphql\schema\SchemaBuilder;
use GraphQL\GraphQL as GraphQLBase;
use RuntimeException;
use Throwable;

class GraphQL {
    static public function handle() {

// MYDEBUG
//echo '<span style="background-color: lightgreen; margin-right: 20px;">GraphQL.php handle()'.''.'</span>';

        try {
            // Build the schema
            $schema = SchemaBuilder::build();

            // Retrieve the raw input from the request
            $rawInput = file_get_contents('php://input');

            if ($rawInput === false || empty($rawInput)) {
                throw new RuntimeException('Failed to get php://input');
            }

            // Decode JSON input
            $input = json_decode($rawInput, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new RuntimeException('Invalid JSON input.');
            }

            $query = $input['query'] ?? null;
            $variableValues = $input['variables'] ?? null;

            // Handle case where the query is null
            if ($query === null) {
                throw new RuntimeException('No query provided.');
            }

            $rootValue = ['prefix' => 'You said: '];
            $result = GraphQLBase::executeQuery($schema, $query, $rootValue, null, $variableValues);
            $output = $result->toArray();
        } catch (Throwable $e) {
            $output = [
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ];
        }

        header('Content-Type: application/json; charset=UTF-8');
        return json_encode($output);
    }
}
