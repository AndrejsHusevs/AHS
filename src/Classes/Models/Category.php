<?php

namespace App\Classes\Models;

use App\Classes\Model;
use PDO;
use App\Classes\Database;

class Category extends Model {

    protected $db;
    protected $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    //  TODO delete this mehtod - debug only
    public function getAllDemoCategories() {
        return [
            ['id' => 1, 'name' => 'Category 1'],
            ['id' => 2, 'name' => 'Category 2']
        ];    
    }


    public function getAllCategoryNamesByLanguageId($language_id)
    {

        $sql = 'SELECT c.id, n.name 
                FROM ahs_categories c
                JOIN ahs_category_names n ON c.id = n.category_id
                WHERE n.language_id = :language_id';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':language_id', $language_id, PDO::PARAM_STR);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categoryArray[] = [
                'id' => $row['id'],
                'name' => $row['name']
            ];
        }
        return $categoryArray;
    }


}