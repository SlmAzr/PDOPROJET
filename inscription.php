<?php

require_once __DIR__ . "/setup/db_connect.php";

class User
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
        $stmt->bindParam(':pseudo', $this->pseudo, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
        $stmt->bindParam(':role', $this->role, PDO::PARAM_STR);

        return $stmt->execute();
    }
}

$error = "";
$successMsg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["pseudo"], $_POST["email"], $_POST["password"], $_POST["role"])) {
    $pseudo = trim($_POST["pseudo"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $role = $_POST["role"];

    if (empty($pseudo) || empty($email) || empty($password) || empty($role)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user = new User($conn, $pseudo, $email, $hashedPassword, $role);
        $success = $user->save();

        if ($success) {
            $successMsg = "Utilisateur enregistré avec succès !";
            header("Location: home.php");
            exit;
        } else {
            $error = "Erreur lors de l'enregistrement.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
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
        justify-content: center;
        gap: 10px;
    }
</style>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Inscription</title>
</head>

<body>
    <section>
        <?php if (!empty($error)) : ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if (!empty($successMsg)) : ?>
            <p style="color: green;"><?= htmlspecialchars($successMsg) ?></p>
        <?php endif; ?>

        <form action="" method="post">
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" id="pseudo" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>

            <label for="role">Rôle</label>
            <select name="role" id="role" required>
                <option value="admin">admin</option>
                <option value="user">user</option>
            </select>

            <input type="submit" value="Inscription">
        </form>
    </section>
</body>
</html>
