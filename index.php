<?php
// Include the application core files
require 'src/Controller/SiteController.php';
require 'src/Model/SiteModel.php';

// Initialize the controller
$controller = new \Controller\SiteController();
$controller->handleRequest();

?>