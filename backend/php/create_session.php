<?php

require_once 'global.php';

if (isLoggedIn() === true) {
    header('Location: index.php');
    exit;
}

$pdo = $_SESSION['pdo'];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $hash = password_hash($password, PASSWORD_DEFAULT);

    if (empty($email) && !preg_match('/[\w\-]{2,}@[\w\-]{2,}\.[\w\-]+/', $email) || empty($password)) {
        $errorMsg = 'Please fill all the fields with valid values';
        header('Location: ../../login.php?error=' . urlencode($errorMsg));
        // if the both passwords are not the same.
    } else {
        $client = $pdo->getClient($email);
        if ($client->rowCount() > 0) {
            $client = $client->fetch();
            if (password_verify($password, $client['password_client'])) {
                session_start();
                if (isset($_POST['remember']) && $_POST['remember'] === 'yes') {
                    setcookie('remember', $email, time() + 3600);
                }
                $_SESSION['id_client'] = $client['id_client'];
                header('Location: ../../index.php');
            } else {
                $errorMsg = 'Wrong email or password';
                header('Location: ../../login.php?error=' . urlencode($errorMsg));
            }
        } else {
            $errorMsg = 'Wrong email or password';
            header('Location: ../../login.php?error=' . urlencode($errorMsg));
        }
    }
    exit();

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $prenom = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $nom = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $cpassword = filter_input(INPUT_POST, 'cpassword', FILTER_SANITIZE_STRING);

    // If there are some input non-filled
    if (empty($prenom) && !preg_match('/^[A-Za-z\s\-]+$/', $prenom) ||
        empty($nom) && !preg_match('/^[A-Za-z\s\-]+$/', $nom) ||
        empty($email) && !preg_match('/[\w\-]{2,}@[\w\-]{2,}\.[\w\-]+/', $email) ||
        empty($password) || empty($cpassword)) {
        $errorMsg = 'Please fill all the fields with valid values';
        header('Location: ../../login.php?error=' . urlencode($errorMsg));
        exit();
        // if the both passwords are not the same.
    } else if ($password != $cpassword) {
        $errorMsg = 'Passwords do not match';
        header('Location: ../../login.php?error=' . urlencode($errorMsg));
        exit();
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $client = $pdo->getClient($email);
        // If email is already used
        if ($client->rowCount() > 0) {
            $errorMsg = 'Email already used';
            header('Location: ../../../../login.php?error=' . urlencode($errorMsg));
        } else {
            $pdo->addNewClient($prenom, $nom, $email, $hash);
            $client = $pdo->getClient($email);
            $client = $client->fetch();
            session_start();
            $_SESSION['id_client'] = $client['id_client'];
            header('Location: ../../index.php');
        }
        exit();
    }
}