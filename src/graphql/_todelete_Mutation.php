<?php

namespace App\graphql;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use App\Classes\Models\Order;

$mutationType = new ObjectType([
    'name' => 'Mutation',
    'fields' => [
        'createOrder' => [
            'type' => Type::boolean(),
            'args' => [
                'content' => Type::nonNull(Type::string()),
            ],
            'resolve' => function($root, $args) {
                $orderModel = new Order();
                return $orderModel->createOrder($args['content']);
            },
        ],
    ],
]);

return $mutationType;