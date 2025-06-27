<?php
class SignUp
{
    public $pseudo;
    public $email;
    public $password;
    public $role;
    private $conn;

    public function __construct($conn, $pseudo, $email, $password, $role)
    {
        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->conn = $conn;
    }

    public function save() {
        $sql = "INSERT INTO users (pseudo, email, password, role) VALUES (:pseudo, :email, :password, :role)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Erreur de préparation.");
        }
        $stmt->bindValue(':pseudo', $this->pseudo, PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $this->password, PDO::PARAM_STR);
        $stmt->bindValue(':role', $this->role, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
