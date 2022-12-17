<?php

require_once __DIR__ . '/global.php';

if (isLoggedIn() === false) {
    header('Location: ../../login.php');
    exit;
}

session_destroy();
setcookie('remember', '', time() - 3600);
unset($_COOKIE['remember']);

// @remarque On redirige sur la page principale
header('Location: ../../index.php');
