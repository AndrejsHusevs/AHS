<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Schema;

// Define the Attribute type
$attributeType = new ObjectType([
    'name' => 'Attribute',
    'fields' => [
        'displayvalue' => Type::nonNull(Type::string()),
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
            'resolve' => function() {
                $categoryModel = new \App\Classes\Models\Category();
                return $categoryModel->getAllCategoryNamesByLanguageId("english");
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
        error_log("categoryId=" . $categoryId); // Debugging statement

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

            $uniqueAttributes = $attributeItemModel->getUniqueAttributesByProductId($product['id']);
            $product['attributes'] = [];
            foreach ($uniqueAttributes as $uniqueAttribute) {
                $attributeItems = $attributeItemModel->getItemsByAttributeIdAndProductId($uniqueAttribute['attribute_id'], $product['id']);
                $product['attributes'][] = [
                    'id' => $uniqueAttribute['attribute_id'],
                    'name' => $uniqueAttribute['attribute_id'], // Assuming name is same as id
                    'type' => 'text', // Assuming type is text, modify as needed
                    'items' => $attributeItems,
                ];
            }
        }

        return $products;
    },
],
    ],
]);

return new Schema([
    'query' => $queryType,
]);