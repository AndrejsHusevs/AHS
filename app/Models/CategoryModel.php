<?php

namespace App\Models;

use App\Core\Model;

class CategoryModel extends Model {
    public function getAllCategories() {
        // Assuming you have a method to get all categories
        //$stmt = $this->db->query("SELECT * FROM categories"); // Replace with your actual query
        //return $stmt->fetchAll(\PDO::FETCH_ASSOC); // Fetch as an associative array
        return [
            ['id' => 1, 'name' => 'Category 1'],
            ['id' => 2, 'name' => 'Category 2']
        ];
    }
}
