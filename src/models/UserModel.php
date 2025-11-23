<?php
class UserModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function getUserByEmail($email)
    {
        $sql = 'SELECT id, username, email, password FROM users WHERE email = ?';
        $result = query($this->conn, $sql, 's', [$email]);
        if (!$result) {
            throw new Exception("Error al ejecutar la consulta getUserByEmail()");
        }

        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }

    public function registerUser($username, $email, $password)
    {
        $sql = 'INSERT INTO users (username, email, password) VALUES (?, ?, ?)';
        $result = query($this->conn, $sql, 'sss', [$username, $email, $password]);
        if (!$result) {
            throw new Exception("No se pudo registrar el usuario");
        }
        return true;
    }

    public function getUserById($id)
    {
        $sql = 'SELECT * FROM users WHERE id = ?';
        $result = query($this->conn, $sql, 's', [$id]);
        if (!$result) {
            throw new Exception("Error al ejecutar la consulta getUserById()");
        }

        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }
}
