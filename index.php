<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
require 'src/config/config.php';
require 'src/controller/AuthController.php';
require 'src/controller/ProfileController.php';

// Configuracion segura de sesión
$sessionOptions = [
    'cookie_httponly' => true,
    'cookie_secure' => (ENVIRONMENT === 'production'),
    'cookie_samesite' => 'Strict',
    'use_strict_mode' => true
];
session_start($sessionOptions);
// Manejo de conexión
try {
    $conn = connection();
    if (!$conn) {
        throw new Exception('No se pudo establecer conexión con la base de datos');
    }
} catch (Exception $e) {
    registerLog('error', 'Error de conexión: ' . $e->getMessage());
    if (ENVIRONMENT === 'development') {
        die('Error de base de datos: ' . $e->getMessage());
    } else {
        // En producción, mostrar mensaje amigable
        set_session_message('Error temporal del sistema. Por favor, intente más tarde.', 'error', 'red');
        // Podrías redirigir a una página de error específica
        header('Location: ' . BASE_URL . 'login');
        exit();
    }
}
// Obtener y sanitizar ruta
$ruta = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$ruta = filter_var($ruta, FILTER_SANITIZE_URL);
// Remover BASE_URL de la ruta para las comparaciones
$rutaRelativa = str_replace(BASE_URL, '/', $ruta);
$rutaRelativa = $rutaRelativa === '' ? '/' : $rutaRelativa;
$authController = new AuthController($conn);
$profileControler = new ProfileController($conn);
// Sistema de enrutamiento
switch ($rutaRelativa) {
    case '/':
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'home');
        } else {
            header('Location: ' . BASE_URL . 'login');
        }
        exit();

    case '/login':
        $authController->login();
        break;

    case '/register':
        $authController->register();
        break;

    case '/profile':
        $profileControler->index();
        break;

    case '/logout':
        // Limpieza segura de sesión
        session_regenerate_id(true);
        session_destroy();
        header('Location: ' . BASE_URL . 'login');
        exit();

    case '/home':
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }
        require 'src/views/home.php';
        break;

    default:
        http_response_code(404);
        require 'src/views/404.php';
        break;
}
mysqli_close($conn);
