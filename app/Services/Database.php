<?php

namespace app\Services;

use PDO;
use PDOException;
use RuntimeException;

class Database
{
    private $pdo;

    public function __construct()
    {
        // Correct path to the configuration file
        $configFilePath = __DIR__ . '/../config/database.php';        
        if (file_exists($configFilePath)) {
            $config = require $configFilePath;
        } else {
            throw new RuntimeException('Configuration file not found.');
        }

        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";

        try {
            $this->pdo = new PDO($dsn, $config['username'], $config['password']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}
