<?php

namespace App\Models;

use App\Core\Model;

class SiteModel extends Model
{
    public function getAllData()
    {
        $data = [
            ['id' => 1, 'name' => 'Name 1'],
            ['id' => 2, 'name' => 'Name 2']
        ];
        return $data;


        //$stmt = $this->db->query("SELECT * FROM users");
        //return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}