<?php


require_once __DIR__ . '/global.php';

if (!isLoggedIn()) {
    header('Location: ../../public/login.php');
    exit;
}

$pdo = $_SESSION['pdo'];
$id_client = $_SESSION['id_client'];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment'])) {
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $mobilePhone = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $postalCode = filter_input(INPUT_POST, 'postalCode', FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);

    // If there are some input non-filled
    if (empty($firstName) && !preg_match('/^[A-Za-z\s\-]+$/', $firstName) ||
        empty($lastName) && !preg_match('/^[A-Za-z\s\-]+$/', $lastName) ||
        empty($email) && !preg_match('/[\w\-]{2,}@[\w\-]{2,}\.[\w\-]+/', $email) ||
        empty($mobilePhone) && !preg_match('/^[0-9]{10}$/', $mobilePhone) || empty($address) || empty($postalCode) || empty($city) || empty($country)) {
        $errorMsg = 'Please fill all the fields with valid values';
        header('Location: ../../public/checkout.php?error=' . urlencode($errorMsg));
        // if the both passwords are not the same.
    } else {
        if ($pdo->updateClient($id_client, $lastName, $firstName, $email, $mobilePhone, $address, $postalCode, $city, $country)) {
            header('Location: ../../public/paypal.php?success=' . urlencode('Your informations have been updated'));
        } else {
            $errorMsg = 'Something went wrong, please try again';
            header('Location: ../../public/checkout.php?error=' . urlencode($errorMsg));
        }
    }
    exit();
}
