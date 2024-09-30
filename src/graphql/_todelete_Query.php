<?php

require_once __DIR__ . '/../../vendor/autoload.php';

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Error\Debug;

try {
    //$schema = require __DIR__ . '/schema.php';

    // Define the Attribute type
$attributeType = new ObjectType([
    'name' => 'Attribute',
    'fields' => [
        'display_value' => Type::nonNull(Type::string()),
        'value' => Type::nonNull(Type::string()),
        'id' => Type::nonNull(Type::string()),
    ],
]);

// Define the AttributeSet type
$attributeSetType = new ObjectType([
    'name' => 'AttributeSet',
    'fields' => [
        'id' => Type::nonNull(Type::string()),
        'name' => Type::nonNull(Type::string()),
        'type' => Type::nonNull(Type::string()),
        'items' => Type::listOf($attributeType),
    ],
]);

// Define the Product type
$productType = new ObjectType([
    'name' => 'Product',
    'fields' => [
        'id' => Type::nonNull(Type::string()),
        'name' => Type::nonNull(Type::string()),
        'instock' => Type::nonNull(Type::boolean()),
        'gallery' => Type::listOf(Type::nonNull(Type::string())),
        'description' => Type::nonNull(Type::string()),
        'category' => Type::string(),
        'attributes' => Type::listOf($attributeSetType),
        'price_amount' => Type::nonNull(Type::float()),
        'price_currency_label' => Type::nonNull(Type::string()),
        'price_currency_symbol' => Type::nonNull(Type::string()),
        'brand' => Type::nonNull(Type::string()),
    ],
]);

// Define the Category type
$categoryType = new ObjectType([
    'name' => 'Category',
    'fields' => [
        'id' => Type::nonNull(Type::int()),
        'name' => Type::nonNull(Type::string()),
    ],
]);


// Define the Query type
$queryType = new ObjectType([
    'name' => 'Query',
    'fields' => [
        'categories' => [
            'type' => Type::listOf($categoryType),
            'args' => [
                'id' => Type::int(),
            ],
            'resolve' => function($root, $args) {
                $categoryModel = new \App\Classes\Models\Category();
                $categoryId = $args['id'] ?? null;
                if ($categoryId !== null) {
                    return [$categoryModel->getCategoryNameByCategoryIdAndLanguageId($categoryId, "english")];
                } else {
                    return $categoryModel->getAllCategoryNamesByLanguageId("english");
                }
            },
        ],
        'products' => [
            'type' => Type::listOf($productType),
            'args' => [
                'categoryId' => Type::int(),
            ],
        'resolve' => function($root, $args) {
            $productModel = new \App\Classes\Models\Product();
            $categoryId = $args['categoryId'] ?? null;
            if ($categoryId !== null) {
                if ($categoryId == 0) {
                    $products = $productModel->getAll();
                } else {
                    $products = $productModel->fetchProductsByCategory($categoryId);
                }
            } else {
                $products = $productModel->getAll();
            }

            $productNameDescriptionModel = new \App\Classes\Models\ProductNameDescription();
            $productGalleryModel = new \App\Classes\Models\ProductGallery();
            $attributeItemModel = new \App\Classes\Models\AttributeItem();
            $categoryModel = new \App\Classes\Models\Category();

            foreach ($products as &$product) {
                $productNameDescription = $productNameDescriptionModel->getByProductIdAndLanguageId($product['id'], 'english');
                if ($productNameDescription) {
                    $product['name'] = $productNameDescription['name'];
                    $product['description'] = $productNameDescription['description'];
                }
                $product['gallery'] = array_map(function($gallery) {
                    return $gallery['link'];
                }, $productGalleryModel->getByProductId($product['id']));
                $category = $categoryModel->getCategoryNameByProductIdAndLanguageId($product['id'], 'english');
                $product['category'] = $category['name'] ?? null;
            }

            return $products;
        },
        ],
        'product' => [
            'type' => $productType,
            'args' => [
                'id' => Type::nonNull(Type::string()),
            ],
            'resolve' => function($root, $args) {
                $productModel = new \App\Classes\Models\Product();
                return $productModel->getProductById($args['id']);
            },
        ],
    ],
]);

//$mutationType = require 'Mutation.php';

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
    
















    $schema = new Schema([
        'query' => $queryType,
        'mutation' => $mutationType,
    ]);

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