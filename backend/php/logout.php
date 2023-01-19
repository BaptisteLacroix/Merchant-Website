<?php

require_once __DIR__ . '/global.php';

if (!isLoggedIn()) {
    header('Location: ../../index.php');
    exit;
}

session_destroy();
setcookie('remember', '', time() - 3600, "/");
setcookie('id_client', '', time() - 3600, "/");
unset($_COOKIE['remember']);
unset($_COOKIE['id_client']);
unset($_COOKIE['email_client']);


echo "<script>window.location.href='../../index.php';</script>";

header('Location: ../../index.php');
exit();
