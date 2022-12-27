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
    if ($function_name == 'deleteFromProducts') {
        $var = deleteProductById($_POST['arguments'][0], $pdo);
        echo json_encode(
            [
                'success' => $var,
            ]);
    }
} else if (isset($_POST)){
    addNewProduct($pdo);
    header('Location: ../../admin-dashboard/iframes/stock.php');
}
exit();

function addNewProduct(BDD $pdo): void
{

    print_r($_POST);
    // get the image to insert into the database
    $image = $_FILES['file']['tmp_name'];
    $imgContent = addslashes(file_get_contents($image));
    $fournisseur = $_POST['fournisseur'];
    $reference = $_POST['reference'];
    $status = $_POST['status'];
    $marque = $_POST['marque'];
    $type = $_POST['type'];
    $aspect = $_POST['aspect'];
    $taille = $_POST['taille'];
    $couleur = $_POST['couleur'];
    $publicPrice = $_POST['public_price'];
    $boughtPrice = $_POST['private_price'];
    $titre = $_POST['titre'];
    $descriptif = $_POST['descriptif'];
    $stocks = $_POST['quantite'];

    $pdo->addNewProduct($imgContent, $fournisseur, $reference, $status, $marque, $type, $aspect, $taille, $couleur, $publicPrice, $boughtPrice, $titre, $descriptif, $stocks);
    $pdo->addNewCommandeProduit($reference, $stocks, $boughtPrice);
}

function deleteProductById($id_produit, BDD $pdo): bool|PDOStatement
{
    return $pdo->deleteProductById($id_produit);
}
