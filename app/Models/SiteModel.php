<?php

namespace App\Models;

use App\Core\Model;

class SiteModel extends Model
{
    public function getAllData()
    {

        $model = new CategoryModel();
        $categories = $model->getAllCategories();
        
        // Display categories (example)
        echo '<h1>Categories</h1>';
        foreach ($categories as $category) {
            echo '<p>' . htmlspecialchars($category['name']) . '</p>'; // Adjust field names accordingly
        }

        $data = [
            ['id' => 1, 'name' => 'Name 1'],
            ['id' => 2, 'name' => 'Name 2']
        ];
        return $data;

    }
}