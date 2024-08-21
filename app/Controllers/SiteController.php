<?php

namespace app\Controllers;

use app\Core\Controller;
use app\Models\SiteModel;
use app\Controllers\GraphQL;

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