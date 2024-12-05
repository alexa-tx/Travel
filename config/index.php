<?php
$request = $_SERVER['REQUEST_URI'];

$routes = [
    '../views/index.php' => 'index.php',
    '../views/profile.php' => 'profile.php',
    '../views/tours.php' => 'tours.php',
    '../views/about.php' => 'about.php',
    '../views/register-tour.php' => 'register-tour.php',
    '../views/singin.php' => 'singin.php',
    '../views/singup.php' => 'singup.php'
];

// проверка на то, существует ли файл или нет
if (array_key_exists($request, $routes)) {
    include $routes[$request];
} else {
    http_response_code(404);   // ошибка
    include '404.php';
}
?>
