<?php
require_once 'src/models/UserModel.php';
class AuthController
{
    private $conn;
    private $userModel;
    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->userModel = new UserModel($conn);
    }
    // ----- LOGIN -----
    public function login()
    {
        // Si ya está logueado, redirigir a home
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'home');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            // Validaciones
            if (empty($email) || empty($password)) {
                set_session_message('Por favor, completa todos los campos', 'error', 'red');
                header('Location: ' . BASE_URL . 'login');
                exit();
            }
            $user = $this->userModel->getUserByEmail($email);
            if (!$user) {
                set_session_message('Email no registrado', 'error', 'red');
                registerLog('warning', "Intento de login con email no registrado: $email");
                header('Location: ' . BASE_URL . 'login');
                exit();
            }
            if (!password_verify($password, $user['password'])) {
                set_session_message('Contraseña incorrecta', 'error', 'red');
                registerLog('warning', "Intento de login con contraseña incorrecta para: $email");
                header('Location: ' . BASE_URL . 'login');
                exit();
            }
            // LOGIN EXITOSO
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $email;
            registerLog('info', "Login exitoso para usuario: $email");
            // Redirigir a home
            header('Location: ' . BASE_URL . 'home');
            exit();
        }
        // Mostrar formulario de login (con mensajes de error si existen)
        require 'src/views/auth/login.php';
    }

    // ----- REGISTER ----- 

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $confirm_password = trim($_POST['confirm_password'] ?? '');
            $role = 2;
            if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
                set_session_message('Por favor, completa todos los campos', 'error', 'red');
                header('Location: ' . BASE_URL . 'register');
                exit();
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                set_session_message("Email inválido", "error", "red");
                header("Location: " . BASE_URL . "register");
                exit;
            }
            if ($password !== $confirm_password) {
                set_session_message('Las contraseñas no coinciden', 'error', 'red');
                header('Location: ' . BASE_URL . 'register');
                exit();
            }
            if ($this->userModel->getUserByEmail($email) !== false) {
                set_session_message("El email ya está registrado", "error", "red");
                header("Location: " . BASE_URL . "register");
                exit;
            }
            if ($this->userModel->registerUser($username, $email, $password, $role)) {
                set_session_message("Registro exitoso. Inicia sesión.", "success", "green");
                header("Location: " . BASE_URL . "login");
                exit;
            }
            set_session_message("Error al registrar el usuario", "error", "red");
        }
        require 'src/views/auth/register.php';
    }
}
