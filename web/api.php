<?php
require(__DIR__ . '/../vendor/autoload.php');
$swagger = \Swagger\scan(__DIR__ . '/../controllers/');
header('Content-Type: application/json');
echo $swagger;