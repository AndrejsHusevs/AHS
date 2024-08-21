<?php

namespace app\Controllers;

use app\Core\Controller;
use app\Controllers\GraphQL;

class TestFormGraphQLController extends Controller
{
    public function index()
    {     
        $data = [
            'title' => 'GraphQL Test Form'
        ];
        $this->view('testFormGraphQLView', $data);
    }
}