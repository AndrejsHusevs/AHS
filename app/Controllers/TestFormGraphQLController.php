<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Controllers\GraphQL;

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