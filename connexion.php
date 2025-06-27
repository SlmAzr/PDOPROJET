<?php
session_start();
require_once __DIR__ . "/setup/db_connect.php";
require_once __DIR__ . "/class/auth.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email) || empty($password)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        $user = new Auth($conn);
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
            <p class="error"><?= $error ?></p>
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