<?php

namespace App\Classes\Models;

use App\Classes\Model;
use PDO;
use App\Classes\Database;

abstract class Attribute extends Model {
    abstract public function getType();

    public function getAllAttributes() {
        $sql = 'SELECT attribute_id, name, type FROM ahs_attributes';
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
