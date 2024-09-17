<?php

namespace App\Classes\Models;

use App\Classes\Model;
use PDO;
use App\Classes\Database;


class Service extends Model {

    public function getAttributeTypeAndNameById($attributeId) {
        error_log("SERVICE: getAttributeTypeAndNameById for ID: " . $attributeId);
        $sql = "SELECT type, name FROM ahs_attributes WHERE attribute_id = :attributeId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':attributeId', $attributeId, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        error_log("Query result: " . print_r($result, true));

        return $result;    
    }

    public function getAll() { return null;}
    public function getById($id) { return null;}

}