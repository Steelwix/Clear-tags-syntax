<?php

session_start();


$routes = [
    '/' => 'homeController', '/profile' => 'profileController', '/login' => 'loginController', '/quiz' => 'quizController'
];

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (array_key_exists($url, $routes)) {
    $handler = $routes[$url];
} else {
    http_response_code(404);
    exit('Route not found');
}
$models = glob('src/model/*.php');
foreach ($models as $model) {
    require_once $model;
}
$files = glob('src/controllers/*.php');
foreach ($files as $file) {
    include $file;
}


call_user_func($handler);
