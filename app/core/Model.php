<?php

namespace App\Core;

use PDO;

class Model
{
    protected $db;

    public function __construct()
    {
        //$this->db = new PDO('mysql:host=localhost;dbname=testdb', 'username', 'password');
    }
}

?>