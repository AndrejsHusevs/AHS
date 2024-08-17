<?php

namespace Controller;

use Model\SiteModel;

class SiteController
{
    public function handleRequest()
    {
        // Create a new model instance
        $model = new SiteModel();
        
        // Fetch data from the model
        $data = $model->getData();
        
        // Load the view and pass the data to it
        include 'src/View/siteView.php';
    }
}

?>