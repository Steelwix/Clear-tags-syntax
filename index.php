<?php

session_start();


$routes = [
    '/' => 'homeController', '/profile' => 'profileController', '/login' => 'loginController', '/quiz' => 'quizController',
    '/result' => 'resultController', '/register' => 'registerController', '/logout' => 'logoutController', '/admin' => 'homeAdminController',
    '/admin/users' => 'userManageController', '/admin/questions' => 'questionManageController', '/admin/results' => 'resultController'
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
$controllers = glob('src/controllers/*.php');
foreach ($controllers as $controller) {
    include $controller;
}
$entities = glob('src/entity/*.php');
foreach ($entities as $entity) {
    include $entity;
}


call_user_func($handler);
