<?php
require_once 'src/models/UserModel.php';
class ProfileController
{
    private $conn;
    private $userModel;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->userModel = new UserModel($conn);
    }

    public function index()
    {
        // Solo usuarios logueados
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }
        $user_id = $_SESSION['user_id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $first_name = trim($_POST['first_name']);
            $last_name  = trim($_POST['last_name']);
            $phone     = trim($_POST['phone']);
            $address   = trim($_POST['address']);
            // Validaciones
            $errors = [];
            if (empty($first_name)) {
                $errors[] = "El nombre no puede estar vacío.";
            }
            if (empty($last_name)) {
                $errors[] = "El apellido no puede estar vacío.";
            }
            if (!empty($phone) && !preg_match('/^[0-9+\-\s]+$/', $phone)) {
                $errors[] = "El teléfono solo puede contener números, espacios o + -";
            }
            if (strlen($address) > 255) {
                $errors[] = "La dirección es demasiado larga.";
            }
            // Si hay errores → los mostramos y no seguimos
            if (!empty($errors)) {
                set_session_message(implode("<br>", $errors), 'error', 'red');
                header('Location: ' . BASE_URL . 'profile');
                exit();
            }
            if ($this->userModel->getProfileById($user_id)) {
                $ok = $this->userModel->updateProfile($user_id, $first_name, $last_name, $phone, $address);
            } else {
                $ok = $this->userModel->insertProfile($user_id, $first_name, $last_name, $phone, $address);
            }
            if (!$ok) {
                set_session_message('Error al actualizar el perfil', 'error', 'red');
                header('Location: ' . BASE_URL . 'profile');
                exit();
            }
            set_session_message('Perfil actualizado con exito', 'success', 'green');
            header('Location: ' . BASE_URL . 'profile');
            exit();
        }

        $user = $this->userModel->getProfileById($user_id);
        // Asegurar variables para el view
        $first_name = $user['first_name'] ?? '';
        $last_name  = $user['last_name'] ?? '';
        $phone     = $user['phone'] ?? '';
        $address   = $user['address'] ?? '';

        require 'src/views/profile.php';
    }
}
