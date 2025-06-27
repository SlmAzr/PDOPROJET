<?php
require_once __DIR__ . "/setup/db_connect.php";
session_start();

/* 

    EXERCICE PROJET : 

        -- Mettre en place un mini site avec une page d'inscription, une page de connexion, une page admin de gestion des utilisateurs inscrits 

            Etapes : 
                    -- Création de la base de données avec une table user/utilisateur pour stocker vos utilisateurs, attention à bien spécifier un rôle
                    -- Création de la page d'inscription avec tous les contrôles nécessaires pour mener à bien l'insertion vers la BDD 
                    -- Création de la page de connexion qui permet d'identifier l'utilisateur
                    -- Création de la page admin gestion des utilisateurs avec la possibilité de modifier/supprimer des utilisateurs (restriction d'accès sur cette page pour les rôles admin)
                    -- On veut aussi un menu réactif, c'est à dire un menu inscription/connexion visible pour un utilisateur pas encore identifié, un menu deconnexion pour un utilisateur identifié et le menu admin visible uniquement aux rôles admin 

                    -- Le but ici étant de réaliser un max de choses en orienté objet ! 

*/

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<style>
    .btn-logout {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: red;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
    }
    a {
        margin: 10px;
        text-decoration: none;
        color: black;
        font-size: 20px;
        
    }
    a:hover {
        text-decoration: underline;
    }
    p{
        font-size: 20px;
        margin: 10px;
  
    }
    .adminPage{
        display: flex;
        margin: 10px ;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <br>
    <?php if (isset($_SESSION["user"])) : ?>
        <div class="adminPage">
            <p>tu es connecté</p>
        </div>
        <form method="POST" style="display:inline;">
            <button type="submit" name="logout" class="btn-logout">Déconnexion</button>
        </form>
    <?php else : ?>
        <a href="inscription.php">inscription</a>
        <a href="connexion.php">connexion</a>
    <?php endif; ?>
    <?php if(isset($_SESSION["user"]) && $_SESSION["user"]["role"] == "admin"): ?>
        <a href="admin.php">Page admin</a>
    <?php endif; ?>

</body>

</html>