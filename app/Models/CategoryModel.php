<?php

namespace app\Models;

use app\Core\Model;
use app\Services\Database;

class CategoryModel extends Model {

    protected $db;

    public function __construct()
    {
        $this->db = (new Database())->getPdo();
    }

    public function getAllCategories()
    {
        $stmt = $this->db->query('SELECT * FROM ahs_categories'); // Adjust your table name and query
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*public function getAllCategories() {
        // Assuming you have a method to get all categories
        //$stmt = $this->db->query("SELECT * FROM categories"); // Replace with your actual query
        //return $stmt->fetchAll(\PDO::FETCH_ASSOC); // Fetch as an associative array
        return [
            ['id' => 1, 'name' => 'Category 1'],
            ['id' => 2, 'name' => 'Category 2']
        ];
    }*/
}
