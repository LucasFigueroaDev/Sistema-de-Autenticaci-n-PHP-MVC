<?php
require 'src/config/config.php';
session_start();
$conn = connection();
if (isset($_REQUEST['lg'])) {
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    if ($email && $password) {
        $sql = 'SELECT * FROM users WHERE email = ?';
        $result = query($conn, $sql, 's', [$email]);
        if ($result->num_rows == 0) {
            message('Usuario no registrado', 'error', 'red');
        } else {
            $user = $result->fetch_assoc();
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: src/pages/home.html');
                exit();
            } else {
                message('Usuario o contraseña incorrectos', 'error',  'red');
            }
        }
    }
} elseif (isset($_POST['rg'])) {
    header('Location: src/pages/register.html');
    exit;
}


include('src/pages/login.html');
