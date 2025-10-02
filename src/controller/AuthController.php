<?php
require 'src/models/UserModel.php';
class AuthController
{
    private $userModel;
    public function __construct($conn)
    {
        $this->userModel = new UserModel($conn);
    }
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleLogin();
            return;
        }
        require 'src/views/login.php';
    }
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleRegister();
            return;
        }
        require 'src/views/register.php';
    }
    private function handlelogin()
    {
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;
        if (!$email || !$password) {
            display_modal_message('Complete todos los campos', 'error', 'red');
        }
        try {
            $user = $this->userModel->getUserByEmail($email);
        } catch (Exception $e) {
            display_modal_message('Error de DB: ' . $e->getMessage(), 'error', 'red');
            return;
        }
        if (!$user || !password_verify($password, $user['password'])) {
            display_modal_message('Credenciales incorrectas', 'error', 'red');
            return;
        }
        // Exito
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        header('Location: /home');
        exit();
    }
    private function handleRegister()
    {
        $username = $_POST['username'] ?? null;
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;
        $confirmPassword = $_POST['confirm_password'] ?? null;
        if (!$username || !$email || !$password || !$confirmPassword) {
            display_modal_message('Complete todos los campos', 'error', 'red');
        }
        if ($password !== $confirmPassword) {
            display_modal_message('Las contraseñas no coinciden', 'error', 'red');
        }
        try {
            if ($this->userModel->getUserByEmail($email)) {
                display_modal_message('El email ya esta en uso', 'error', 'red');
                return;
            }
        } catch (Exception $e) {
            display_modal_message('Error de DB al verificar email: ' . $e->getMessage(), 'error', 'red');
            return;
        }
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        try {
            $this->userModel->registerUser($username, $email, $password_hash);
            display_modal_message('Usuario registrado con exito', 'success', 'green');
            header('Location: /login');
        } catch (Exception $e) {
            display_modal_message('Error de DB al registrar usuario: ' . $e->getMessage(), 'error', 'red');
            return;
        }
    }
}
