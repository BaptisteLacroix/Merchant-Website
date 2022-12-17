<?php

require_once 'connectionBDD.php';

session_start();

/**
 * Verify if user is logged in
 *
 * @return boolean
 */
function isLoggedIn(): bool
{
    return !empty($_SESSION['id_client']);
}

if (!empty($_COOKIE['remember'])) {
    $_SESSION['email'] = $_COOKIE['remember'];
}

// if pdo does not exist or is not defined, create it and make it accessible to all script that require this file
if (!isset($pdo)) {
    $pdo = new bdd('localhost', 'root', '', 'projet-web');
    $_SESSION['pdo'] = $pdo;
}
