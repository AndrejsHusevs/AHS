<?php

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Schema;

$categoryType = new ObjectType([
    'name' => 'Category',
    'fields' => [
        'id' => Type::nonNull(Type::int()),
        'name' => Type::nonNull(Type::string()),
    ],
]);

$queryType = new ObjectType([
    'name' => 'Query',
    'fields' => [
        'categories' => [
            'type' => Type::listOf($categoryType),
            'resolve' => function() {                
                $categoryModel = new \App\Classes\Models\Category();                
                return $categoryModel->getAllCategoryNamesByLanguageId("english");
            },
        ],
    ],
]);

return new Schema([
    'query' => $queryType,
]);