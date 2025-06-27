<?php
class Auth {
    private $conn;

   public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function login($email, $password) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            die("Erreur de préparation.");
        }

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user"] = [
                "id_users" => $user["id_users"],
                "pseudo" => $user["pseudo"],
                "email" => $user["email"],
                "role" => $user["role"]
            ];
            return true;
        }

        return false;
    }
}