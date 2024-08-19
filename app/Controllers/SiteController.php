<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\SiteModel;
use App\Controllers\GraphQL;

class SiteController extends Controller
{
    public function index()
    {        
      
        $model = new SiteModel();
        $dataFromModel = $model->getAllData();
        $data = [
            'title' => 'SiteController',
            'dataSiteView' => $dataFromModel
        ];
        $this->view('siteView', $data);
    }


}