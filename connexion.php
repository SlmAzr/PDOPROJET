<?php
session_start();
require_once __DIR__ . "/setup/db_connect.php";
   
class User {
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

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email) || empty($password)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        $user = new User($conn);
        if ($user->login($email, $password)) {
            header("Location: home.php");
            exit;
        } else {
            $error = "Email ou mot de passe incorrect.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 300px;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <section>
        <h2>Connexion</h2>

        <?php if (!empty($error)) : ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="" method="post">
            <label for="">Email</label>
            <input type="email" name="email" required>

            <label for="">Mot de passe</label>
            <input type="password" name="password" required>
            <input type="submit" value="Connexion">
        </form>
    </section>
</body>
</html>