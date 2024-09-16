<?php

namespace App\Classes\Models;

use App\Classes\Model;
use PDO;
use App\Classes\Database;


class Product extends Model {

    public function getAll() {
        $sql = 'SELECT * FROM ahs_products';
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = 'SELECT * FROM ahs_products WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProductById($id) {
        $sql = 'SELECT * FROM ahs_products WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            // Fetch additional product details like gallery, attributes, etc.
            $productGalleryModel = new ProductGallery();
            $product['gallery'] = array_map(function($gallery) {
                return $gallery['link'];
            }, $productGalleryModel->getByProductId($product['id']));

            $productNameDescriptionModel = new ProductNameDescription();
            $productNameDescription = $productNameDescriptionModel->getByProductIdAndLanguageId($product['id'], 'english');
            if ($productNameDescription) {
                $product['name'] = $productNameDescription['name'];
                $product['description'] = $productNameDescription['description'];
            }

            $categoryModel = new Category();
            $category = $categoryModel->getCategoryNameByProductIdAndLanguageId($product['id'], 'english');
            $product['category'] = $category['name'] ?? null;

            $attributeItemModel = new AttributeItem();
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
        return $product;
    }
    
    public function fetchProductsByCategory($categoryId) {
        $sql = 'SELECT p.* FROM ahs_products p
                JOIN ahs_products_category pc ON p.id = pc.product_id
                WHERE pc.category_id = :category_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}