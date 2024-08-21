<?php

namespace app\Core;

class Controller
{
    public function view($view, $data = [])
    {
        extract($data);
        require_once __DIR__ . '/../Views/' . $view . '.php';
    }
}

?>