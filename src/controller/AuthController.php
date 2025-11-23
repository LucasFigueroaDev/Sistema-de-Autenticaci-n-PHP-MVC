<?php

use phpDocumentor\Reflection\Location;

class AuthController
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
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
                set_session_message('Por favor, ingresa tu correo y contraseña', 'error', 'red');
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                set_session_message('Email no válido', 'error', 'red');
            } else {
                try {
                    $sql = 'SELECT id, password FROM users WHERE email = ?';
                    $result = query($this->conn, $sql, 's', [$email]);
                    if (!$result) {
                        throw new Exception('Error en la consulta de base de datos');
                    }
                    if ($result->num_rows === 0) {
                        set_session_message('Usuario no encontrado', 'error', 'red');
                        registerLog('warning', "Intento de login con email no registrado: $email");
                    } else {
                        $user = $result->fetch_assoc();
                        if (!password_verify($password, $user['password'])) {
                            set_session_message('Contraseña incorrecta', 'error', 'red');
                            registerLog('warning', "Intento de login con contraseña incorrecta para: $email");
                        } else {
                            // LOGIN EXITOSO
                            $_SESSION['user_id'] = $user['id'];
                            $_SESSION['user_email'] = $email;
                            registerLog('info', "Login exitoso para usuario: $email");
                            // Redirigir a home
                            header('Location: ' . BASE_URL . 'home');
                            exit();
                        }
                    }
                } catch (Exception $e) {
                    registerLog('error', "Error en login para $email: " . $e->getMessage());
                    set_session_message('Error del sistema al iniciar sesión', 'error', 'red');
                }
            }
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

            if ($password !== $confirm_password) {
                set_session_message('Las contraseñas no coinciden', 'error', 'red');
                header('Location: ' . BASE_URL . 'register');
                exit();
            }

            try {
                $sql = 'INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)';
                $passhash = password_hash($password, PASSWORD_DEFAULT);
                $result = query($this->conn, $sql, 'sssi', [$username, $email, $passhash, $role]);
                if (!$result) {
                    throw new Exception("No se pudo registrar el usuario");
                }
                set_session_message('Usuario registrado correctamente', 'success', 'green');
                header('Location: ' . BASE_URL . 'login');
                exit();
            } catch (Exception $e) {
                registerLog('error', $e->getMessage());
                set_session_message('Error al registrar el usuario', 'error', 'red');
            }
        }
        require 'src/views/auth/register.php';
    }
}
