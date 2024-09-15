<?php

namespace App\Classes\Models;

use App\Classes\Model;
use PDO;
use App\Classes\Database;


class Category extends Model {

    public function getAll() {
        $sql = 'SELECT * FROM ahs_categories';
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = 'SELECT * FROM ahs_categories WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllCategoryNamesByLanguageId($language_id) {
        $sql = 'SELECT c.id, n.name 
                FROM ahs_categories c
                JOIN ahs_category_names n ON c.id = n.category_id
                WHERE n.language_id = :language_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':language_id', $language_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryNameByProductIdAndLanguageId($product_id, $language_id) {
        $sql = 'SELECT c.id, n.name 
                FROM ahs_categories c
                JOIN ahs_category_names n ON c.id = n.category_id
                JOIN ahs_products_category pc ON c.id = pc.category_id
                WHERE pc.product_id = :product_id AND n.language_id = :language_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_STR);
        $stmt->bindParam(':language_id', $language_id, PDO::PARAM_STR);       
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);;
    }


}