<?php
// src/Classes/Models/Order.php
namespace App\Classes\Models;

use App\Classes\Model;
use PDO;

class Order extends Model {
    public function createOrder($content) {
        $sql = 'INSERT INTO ahs_orders (content) VALUES (:content)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        return $stmt->execute();
    }

    
    public function getAll() { return null;}
    public function getById($id) { return null;}
}