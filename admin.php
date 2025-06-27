<?php
require_once __DIR__ . "/setup/db_connect.php";
require_once __DIR__ . "/class/Action.php";
session_start();
if (!isset($_SESSION["user"]["role"]) || $_SESSION["user"]["role"] === 'user') {
    header("Location: home.php");
    exit;
}

$userAction = new Action($conn);
$users = $userAction->getUsers();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = (int)$_POST['delete_id'];
    $userAction->deleteUser($deleteId);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Document</title>
    <style>
        section {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        table {
            border-collapse: collapse;
            width: 80%;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
        button {
            border: none;
            background-color: transparent;
            cursor: pointer;
            color: red;
        }
        button:disabled {
            color: gray;
            cursor: not-allowed
        }
        .home{
            font-size: 20px;
        }
        .home a{
            color: black;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div><span class="home"><a href="home.php">Home</a></span></div>
    <section>
        <table>
            <tr>
                <th>id</th>
                <th>pseudo</th>
                <th>email</th>
                <th>role</th>
                <th>supprimer</th>
                <th>modifier</th>
            </tr>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= $user["id_users"] ?></td>
                    <td><?= $user["pseudo"] ?></td>
                    <td><?= $user["email"] ?></td>
                    <td><?= $user["role"] ?></td>
                    <td>
                        <form method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                            <input type="hidden" name="delete_id" value="<?= (int)$user['id_users'] ?>">

                            <?php if ($user["role"] !== "admin"): ?>
                                <button type="submit">Supprimer</button>
                            <?php else: ?>
                                <button type="submit" disabled>Supprimer</button>
                            <?php endif; ?>
                        </form>
                    </td>
                    <td>modifier</td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>
</body>

</html>