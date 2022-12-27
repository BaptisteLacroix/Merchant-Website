<?php
function testConnection(BDD $pdo): void
{
    if (!isLoggedIn()) {
        header('Location: ../public/login.php');
        exit();
    } else if ($pdo->getAdminByClientId($_SESSION['id_client'])->rowCount() <= 0) {
        header('Location: ../index.php');
        exit();
    }
}

function testConnectionIframes(BDD $pdo): void
{
    if (!isLoggedIn()) {
        header('Location: ../../public/login.php');
        exit();
    } else if ($pdo->getAdminByClientId($_SESSION['id_client'])->rowCount() <= 0) {
        header('Location: ../../index.php');
        exit();
    }
}
