<?php

require_once 'connectionBDD.php';

session_start();

const PAYPAL_ID = 'AT8ri4QbD63g5sAxH3XoQgBko1XXjCxuJwlbsZS0EAIUDPoLqP3uUEvt-WxUs44JoGX9oKswiF84gbXJ';

/**
 * Verify if user is logged in
 *
 * @return boolean
 */
function isLoggedIn(): bool
{
    return !empty($_SESSION['email_client']);
}

if (!empty($_COOKIE['remember'])) {
    $_SESSION['email_client'] = $_COOKIE['remember'];
}

// if pdo does not exist or is not defined, create it and make it accessible to all script that require this file
if (!isset($pdo)) {
    $pdo = new bdd('localhost', 'root', '', 'projet-web');
    $_SESSION['pdo'] = $pdo;
}
