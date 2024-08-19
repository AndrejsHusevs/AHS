<?php

namespace App\graphql\schema;

use App\graphql\types\QueryType;
use App\graphql\types\MutationType;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;

class SchemaBuilder {
    public static function build(): Schema {
        return new Schema(
            (new SchemaConfig())
                ->setQuery(QueryType::instance())
                ->setMutation(MutationType::instance())
        );
    }
}
