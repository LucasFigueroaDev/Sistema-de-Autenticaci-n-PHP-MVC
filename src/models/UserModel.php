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
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    public function registerUser($username, $email, $password)
    {
        $sql = 'INSERT INTO users (username, email, password) VALUES (?, ?, ?)';
        $result = query($this->conn, $sql, 'sss', [$username, $email, $password]);
        return $result;
    }

    public function getUserById($id)
    {
        $sql = 'SELECT * FROM users WHERE id = ?';
        $result = query($this->conn, $sql, 's', [$id]);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }
}
