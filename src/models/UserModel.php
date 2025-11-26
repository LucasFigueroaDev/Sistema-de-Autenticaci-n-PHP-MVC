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
        $sql = 'SELECT * FROM users WHERE email = ? LIMIT 1';
        $result = query($this->conn, $sql, 's', [$email]);

        if (!$result || $result->num_rows === 0) {
            return false;
        }
        return $result->fetch_assoc();
    }

    public function registerUser($username, $email, $password, $role)
    {
        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return query($this->conn, $sql, 'sssi', [$username, $email, $hash, $role]);
    }

    public function getUserById($id)
    {
        $sql = 'SELECT * FROM users WHERE id = ?';
        $result = query($this->conn, $sql, 's', [$id]);
        if (!$result) {
            return false;
        }
        return $result->fetch_assoc();
    }

    public function getProfileById($id)
    {
        $sql = 'SELECT * FROM profile WHERE user_id = ?';
        $result = query($this->conn, $sql, 'i', [$id]);
        if (!$result) {
            return false;
        }
        return $result->fetch_assoc();
    }
    public function insertProfile($id, $firstname, $lastname, $phone, $address)
    {
        $sql = "INSERT INTO profile (user_id, first_name, last_name, phone, address)VALUES (?, ?, ?, ?, ?)";
        return query($this->conn, $sql, 'issss', [$id, $firstname, $lastname, $phone, $address]);
    }
    public function updateProfile($user_id, $firstname, $lastname, $phone, $address)
    {
        $sql = "UPDATE profile SET first_name = ?, last_name = ?, phone = ?, address = ? WHERE user_id = $user_id";
        return query($this->conn, $sql, 'ssss', [$firstname, $lastname, $phone, $address]);
    }
}
