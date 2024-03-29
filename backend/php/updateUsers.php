<?php

require_once(__DIR__ . '/global.php');


/** @var BDD $pdo */
$pdo = $_SESSION['pdo'];

if (!isLoggedIn() && !isset($_POST['emailForget'])) {
    header('Location: ../../public/login.php');
    exit();
} else if (!empty($_SESSION['id_client']) && $pdo->getAdminByClientId($_SESSION['id_client'])->rowCount() <= 0) {
    header('Location: ../../index.php');
    exit();
}

if (isset($_POST['function_name'])) {
    $function_name = $_POST['function_name'];
    if ($function_name == 'deleteFromUsers') {
        $var = deleteUserById($_POST['arguments'][0], $pdo);
        echo json_encode(
            [
                'success' => $var,
            ]);
    }
} else if (isset($_POST)) {
    if (isset($_POST['emailForget'])) {
        resetPassword($_POST['emailForget'], $pdo);
        header('Location: ../../public/login.php');
    } else {
        addNewUser($pdo);
        header('Location: ../../admin-dashboard/iframes/people.php');
    }
}
exit();


function resetPassword(string $email, BDD $pdo): void
{
    if (empty($email) && !preg_match('/[\w\-]{2,}@[\w\-]{2,}\.[\w\-]+/', $email)) {
        header('Location: ../../public/login.php?error=' . urlencode('Please enter a valid email'));
        exit();
    }
    $password = generateRandomPassword();
    if ($pdo->resetPassword($email, $password)) {
        sendNewPassword($email, $password);
    } else {
        header('Location: ../../public/login.php?error=' . urlencode('Error try again later'));
        exit();
    }
}

function sendNewPassword(string $email, string $password): void
{
    $to = $email;
    $subject = 'New password';
    $message = "Here there is your new password is : " . $password . "\r\nSee you soon on Painting Oil Beautify";
    $headers = 'From: baptiste.lacroix03@gmail.com';
    mail($to, $subject, $message, $headers);
}

function generateRandomPassword(int $length = 10): string
{
    $characters = '0123456789&é"\'(/-è_çà)abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= mb_convert_encoding($characters[rand(0, $charactersLength - 1)], 'UTF-8');
    }
    return $randomString;
}

function addNewUser(BDD $pdo): void
{
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address = $_POST['address'];
    $postalCode = $_POST['postalCode'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];
    /* It's checking if the firstname, lastname, email, and password are empty. */
    if (empty($firstname) && !preg_match('/^[A-Za-z\s\-]+$/', $firstname) ||
        empty($lastname) && !preg_match('/^[A-Za-z\s\-]+$/', $lastname) ||
        empty($email) && !preg_match('/[\w\-]{2,}@[\w\-]{2,}\.[\w\-]+/', $email) ||
        empty($password)) {
        header('Location: ../../admin-dashboard/iframes/people.php?error=' . urlencode('Please fill all the fields with valid values'));
        exit();
        /* It's checking if the address, postalCode, city, country, and phone are empty. */
    } else if (!empty($address) && !empty($postalCode) && !empty($city) && !empty($country) && !empty($phone)) {
        $pdo->addNewClientAllValues($firstname, $lastname, $email, $password, $address, $postalCode, $city, $country, $phone);
    } else if (empty($address) && empty($postalCode) && empty($city) && empty($country) && empty($phone)) {
        $pdo->addNewClient($lastname, $firstname, $email, $password);
    } else {
        header('Location: ../../admin-dashboard/iframes/people.php?error=' . urlencode('Please fill all the fields with valid values'));
        exit();
    }
}

function deleteUserById($id_client, BDD $pdo): bool|PDOStatement
{
    return $pdo->deleteClientById($id_client);
}
