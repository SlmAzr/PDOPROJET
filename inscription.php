<?php

require_once __DIR__ . "/setup/db_connect.php";
require_once __DIR__ . "/class/SignUp.php";

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
        $user = new SignUp($conn, $pseudo, $email, $hashedPassword, $role);
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
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>

        <?php if (!empty($successMsg)) : ?>
            <p style="color: green;"><?= $successMsg ?></p>
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
