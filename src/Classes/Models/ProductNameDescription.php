<?php

namespace App\Classes\Models;

use App\Classes\Model;
use PDO;
use App\Classes\Database;

class ProductNameDescription extends Model {

    public function getAll() {
        $sql = 'SELECT * FROM ahs_products_name_descriptions';
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByProductIdAndLanguageId($product_id, $language_id) {
        $sql = 'SELECT * FROM ahs_products_name_descriptions WHERE product_id = :product_id AND language_id = :language_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_STR);
        $stmt->bindParam(':language_id', $language_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        return null;
    }
}