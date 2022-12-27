<?php

require_once('../backend/php/global.php');

/** @var BDD $pdo */
$pdo = $_SESSION['pdo'];

require_once 'globalAdmin.php';

testConnection($pdo);

$_client = $pdo->getClient($_SESSION['email_client'])->fetch();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Baptiste Lacroix">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="../css/dashboard/dashboard.css">
    <title>Painting Oil Beautify</title>
</head>

<body>

<section class="nav-container">
    <div class="nav-bar-left">
        <ul>
            <li>
                <input id="home" type="radio" name="href" checked>
                <label for="home"> Home</label>
            </li>
            <li>
                <input id="people" type="radio" name="href">
                <label for="people"> People </label>
            </li>
            <li>
                <input id="account" type="radio" name="href">
                <label for="account"> Account </label>
            </li>
            <li>
                <input id="stock" type="radio" name="href">
                <label for="stock"> Stock </label>
            </li>
            <li>
                <input id="supplier" type="radio" name="href">
                <label for="supplier"> Suppliers </label>
            </li>
        </ul>
    </div>
</section>

<section class="dashboard-container">
    <iframe id="iframe" src="./adminPanel.php"></iframe>
</section>


<!--script src="../backend/javascript/footer.js"></script>-->
<script src="../backend/javascript/admin-dashboard/dashboard.js"></script>
</body>
</html>


