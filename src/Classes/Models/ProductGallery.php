<?php

namespace App\Classes\Models;

use App\Classes\Model;
use PDO;
use App\Classes\Database;


class ProductGallery extends Model {

    public function getAll() {
        $sql = 'SELECT * FROM ahs_products_gallery';
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByProductId($product_id) {
        $sql = 'SELECT * FROM ahs_products_gallery WHERE product_id = :product_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        return null;
    }
}