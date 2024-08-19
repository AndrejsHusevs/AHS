<?php

namespace App\graphql\types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Models\CategoryModel;

class QueryType extends ObjectType {
    private static $instance;

    public static function instance(): self {
        return self::$instance ??= new self([
            'name' => 'Query',
            'fields' => [
                'echo' => [
                    'type' => Type::string(),
                    'args' => [
                        'message' => ['type' => Type::string()],
                    ],
                    'resolve' => static fn ($rootValue, array $args): string => $rootValue['prefix'] . $args['message'],
                ],
                'categories' => [
                    'type' => Type::listOf(new CategoryType()), // Specify the type as a list of CategoryType
                    'resolve' => static function() {
                        $model = new CategoryModel(); // Create an instance of the model
                        return $model->getAllCategories(); // Fetch all categories
                    },
                ],
            ],
        ]);
    }
}
