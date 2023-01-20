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
            <li id="home">
                <img class="img-buttons" src="../img/home.svg" alt="home">
                <span>Home</span>
            </li>
            <li id="people">
                <img class="img-buttons" src="../img/people-white.svg" alt="people">
                <span> Users </span>
            </li>
            <li id="account">
                <img class="img-buttons" src="../img/account-white.svg" alt="account">
                <span> Account </span>
            </li>
            <li id="stock">
                <img class="img-buttons" src="../img/stock-white.svg" alt="stock">
                <span> Stock </span>
            </li>
            <li id="supplier">
                <img class="img-buttons" src="../img/suppliers-white.svg" alt="suppliers">
                <span> Suppliers </span>
            </li>
        </ul>
    </div>
</section>

<section class="dashboard-container">
    <iframe id="iframe" src="./adminPanel.php"></iframe>
</section>


<!--script src="../backend/javascript/footer.js"></script>-->
<script src="../backend/javascript/admin-dashboard/dashboard.js"></script>

<?php if (!empty($_GET['info'])) : ?>
    <?php echo "
    <script>
    window.addEventListener('load', function(){
        let result = confirm('" . urldecode($_GET['info']) . "');
        if (result) window.location.href = './dashboard.php'
        else window.location.href = './dashboard.php'
    });
    </script>"?>
<?php endif ?>

</body>
</html>


