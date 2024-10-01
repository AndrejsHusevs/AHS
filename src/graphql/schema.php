<?php

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Schema;
use GraphQL\GraphQL;
use GraphQL\Error\Debug;
use App\Classes\Models\Order;
use App\Classes\Models\SwatchAttribute;
use App\Classes\Models\TextAttribute;
use App\Classes\Models\AttributeItem;

// Define the Attribute type
$attributeItemType = new ObjectType([
    'name' => 'AttributeItem',
    'fields' => [
        'display_value' => Type::nonNull(Type::string()),
        'value' => Type::nonNull(Type::string()),
        'id' => Type::nonNull(Type::string()),
    ],
]);

// Define the AttributeSet type
$attributeType = new ObjectType([
    'name' => 'Attribute',
    'fields' => [
        'id' => Type::nonNull(Type::string()),
        'attribute_id' => Type::nonNull(Type::string()),
        'name' => Type::nonNull(Type::string()),
        'type' => Type::nonNull(Type::string()),
        'items' => Type::listOf($attributeItemType),
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
        'attributes' => Type::listOf($attributeType),
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
        'attribute' => [
            'type' => $attributeType,
            'args' => [
                'attribute_id' => Type::nonNull(Type::string()),
            ],
            'resolve' => function($root, $args) {
                error_log('attribute resolve 1'); 
                $attributeModel = new TextAttribute();
                error_log('attribute resolve 2');
                $attribute = $attributeModel->getById($args['attribute_id']);
                if ($attribute === null) {
                    error_log('attribute resolve 3 - null');
                    $attributeModel = new SwatchAttribute();
                    $attribute = $attributeModel->getById($args['attribute_id']);
                }
                if ($attribute === null) {
                    return null;
                }
                $attributeItemModel = new AttributeItem();
                $items = $attributeItemModel->getItemsByAttributeId($args['attribute_id']);
                //error_log('Items 2: ' . print_r($items, true));
                if ($items === null) {
                    $items = [];
                }
                error_log('Items 3: ' . print_r($items, true));
                $attribute['items'] = $items;
                error_log('returning attribue: ' . print_r($attribute, true));

                if (!is_array($attribute) || !isset($attribute['items'])) {
                    error_log('attribute resolve 5 - invalid format');
                    return null;
                }

                return $attribute;
            },
        ],
        'getItemsByAttributeIdAndProductId' => [
            'type' => Type::listOf($attributeItemType),
            'args' => [
                'product_id' => Type::nonNull(Type::string()),
                'attribute_id' => Type::nonNull(Type::string()),
            ],
            'resolve' => function ($root, $args) {
                $attributeItemModel = new AttributeItem();
                return $attributeItemModel->getItemsByAttributeIdAndProductId($args['attribute_id'], $args['product_id']);
            },
        ],
        'products' => [
            'type' => Type::listOf($productType),
            'args' => [
                'categoryId' => Type::int(),
            ],
            'resolve' => function($root, $args) {

                error_log('products resolving schema.php: ');

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
                $result = $productModel->getProductById($args['id']);                
                return $result;
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

return new Schema([
    'query' => $queryType,
    'mutation' => $mutationType,
]);