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
        error_log("AttributeItem: getItemsByAttributeIdAndProductId for attribute_id: " . $attribute_id . " and product_id: " . $product_id);
        $sql = 'SELECT ai.id, ai.value, ai.display_value FROM ahs_attribute_items ai
                JOIN ahs_products_attribute_items pai ON ai.id = pai.item_id AND ai.attribute_id = :attribute_id
                WHERE pai.attribute_id = :attribute_id AND pai.product_id = :product_id';



/*
SELECT ai.id, ai.display_value FROM ahs_attribute_items ai 
JOIN ahs_products_attribute_items pai ON (ai.id = pai.item_id AND ai.attribute_id = 'With USB 3 ports') 
WHERE pai.attribute_id = 'With USB 3 ports' AND pai.product_id = 'apple-imac-2021'; 
*/

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':attribute_id', $attribute_id, PDO::PARAM_STR);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log("Query result: " . print_r($result, true));
        return $result;
    }


    public function getItemsByAttributeId($attribute_id) {
        error_log("AttributeItem: getItemsByAttributeId for attribute_id: " . $attribute_id);
        $sql = 'SELECT ai.id, ai.value, ai.display_value FROM ahs_attribute_items ai                
                WHERE ai.attribute_id = :attribute_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':attribute_id', $attribute_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //error_log("Query result: " . print_r($result, true));
        return $result !== false ? $result : [];
    }



}