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