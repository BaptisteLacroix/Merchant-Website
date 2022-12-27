<?php

require_once(__DIR__ . '/global.php');


/** @var BDD $pdo */
$pdo = $_SESSION['pdo'];

if (!isLoggedIn()) {
    header('Location: ../../public/login.php');
    exit();
} else if ($pdo->getAdminByClientId($_SESSION['id_client'])->rowCount() <= 0) {
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
    addNewUser($pdo);
    header('Location: ../../admin-dashboard/iframes/people.php');
}
exit();

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
    $admin = $_POST['admin'];
    /* It's checking if the firstname, lastname, email, and password are empty. */
    if (empty($firstname) && !preg_match('/^[A-Za-z\s\-]+$/', $firstname) ||
        empty($lastname) && !preg_match('/^[A-Za-z\s\-]+$/', $lastname) ||
        empty($email) && !preg_match('/[\w\-]{2,}@[\w\-]{2,}\.[\w\-]+/', $email) ||
        empty($password)) {
        header('Location: ../../admin-dashboard/iframes/people.php?error=invalid');
        exit();
        /* It's checking if the address, postalCode, city, country, and phone are empty. */
    } else if (!empty($address) && !empty($postalCode) && !empty($city) && !empty($country) && !empty($phone)) {
        $pdo->addNewClientAllValues($firstname, $lastname, $email, $password, $address, $postalCode, $city, $country, $phone);
    } else if (empty($address) && empty($postalCode) && empty($city) && empty($country) && empty($phone)) {
        $pdo->addNewClient($lastname, $firstname, $email, $password);
    } else {
        header('Location: ../../admin-dashboard/iframes/people.php?error=invalid');
        exit();
    }
    if ($admin == 'on') {
        $pdo->addAdmin($pdo->getClient($email)->fetch()['id_client']);
    }
}

function deleteUserById($id_client, BDD $pdo): bool|PDOStatement
{
    return $pdo->deleteClientById($id_client);
}
