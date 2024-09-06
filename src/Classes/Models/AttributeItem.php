<?php

namespace App\Classes\Models;

use App\Classes\Model;
use PDO;
use App\Classes\Database;


class AttributeItem extends Model {

    public function getAll() {
        $sql = 'SELECT * FROM ahs_attribute_items';
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = 'SELECT * FROM ahs_attribute_items WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByProductId($product_id) {
        $sql = 'SELECT ai.* FROM ahs_attribute_items ai
                JOIN ahs_products_attribute_items pai ON ai.id = pai.item_id
                WHERE pai.product_id = :product_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUniqueAttributesByProductId($product_id) {
        $sql = 'SELECT DISTINCT ai.attribute_id FROM ahs_attribute_items ai
                JOIN ahs_products_attribute_items pai ON ai.id = pai.item_id
                WHERE pai.product_id = :product_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItemsByAttributeIdAndProductId($attribute_id, $product_id) {
        $sql = 'SELECT ai.* FROM ahs_attribute_items ai
                JOIN ahs_products_attribute_items pai ON ai.id = pai.item_id
                WHERE ai.attribute_id = :attribute_id AND pai.product_id = :product_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':attribute_id', $attribute_id, PDO::PARAM_STR);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}