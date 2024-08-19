<?php

namespace App\graphql\types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CategoryType extends ObjectType {
    public function __construct() {
        parent::__construct([
            'name' => 'Category',
            'fields' => [
                'id' => ['type' => Type::nonNull(Type::int())],
                'name' => ['type' => Type::string()],
            ],
        ]);
    }
}
