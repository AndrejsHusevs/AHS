<?php

namespace App\Classes;

use PDO;
use App\Classes\Database;

abstract class Model {
    protected $db;
    protected $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    abstract public function getAll();
    abstract public function getById($id);
}