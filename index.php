<?php
require 'src/config/config.php';
require 'src/controller/AuthController.php';
session_start();

$coon = connection();
if (!$coon) {
    registerLog('error', 'No se pudo conectar a la base de datos');
    set_session_message('Error al conectar a la base de datos', 'error', 'red');
    exit();
}

$route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base_path = '/My-app';
// 2. Quitamos el prefijo solo si existe (para limpiar la ruta)
if (str_starts_with($route, $base_path)) {
    $route = substr($route, strlen($base_path));
}
// 3. Si la ruta queda vacía (solo /My-app/), la forzamos a '/'
if ($route === '') {
    $route = '/';
}
$authController = new AuthController($coon);

switch ($route) {
    case '/login':
        $authController->login();
        break;
    case '/register':
        $authController->register();
        break;
    case '/home':
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        require 'src/views/home.php';
        break;
    case '/logout':
        session_destroy();
        header('Location: /login');
        exit();
    default:
        echo 'Ruta no encontrada';
        break;
}
mysqli_close($coon);
