<?php

require_once __DIR__ . '/backend/php/global.php';

$pdo = $_SESSION['pdo'];

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$id_client = $_SESSION['id_client'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Baptiste Lacroix">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="./css/checkout.css">
    <title>Painting Oil Beautify</title>
</head>

<body>

<?php require_once(__DIR__ . '/backend/php/navbar.php'); ?>

<container>
    <div id="top">

    </div>
</container>

<script src="./backend/javascript/footer.js"></script>
</body>

</html>
