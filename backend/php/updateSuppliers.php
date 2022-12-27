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
    if ($function_name == 'deleteFromSuppliers') {
        $var = deleteSupplierById($_POST['arguments'][0], $pdo);
        echo json_encode(
            [
                'success' => $var,
            ]);
    }
} else if (isset($_POST)){
    addNewSupplier($pdo);
    header('Location: ../../admin-dashboard/iframes/fournisseur.php');
}
exit();

function addNewSupplier(BDD $pdo): void
{
    $name = $_POST['name'];
    $address = $_POST['address'];
    $postalCode = $_POST['postalCode'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $pdo->addNewSupplier($name, $address, $postalCode, $city, $country, $phone, $email);
}

function deleteSupplierById($id_supplier, BDD $pdo): bool|PDOStatement
{
    return $pdo->deleteSupplierById($id_supplier);
}
