<?php

namespace App\Classes\Models;

use App\Classes\Model;
use PDO;
use App\Classes\Database;

class SwatchAttribute extends Attribute {
    public function getType() {
        return 'swatch';
    }

    public function getAll() {
        $sql = 'SELECT * FROM ahs_attributes WHERE type = "swatch"';
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = 'SELECT * FROM ahs_attributes WHERE attribute_id = :id AND type = "swatch"';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}