<?php

require_once(__DIR__ . '/global.php');


if (!isLoggedIn()) {
    header('Location: ../../public/login.php');
    exit();
}

$pdo = $_SESSION['pdo'];

if (isset($_POST)) {
    $img = $_POST['image'];
    $fournisseur = $_POST['fournisseur'];
    $reference = $_POST['reference'];
    $status = $_POST['status'];
    $marque = $_POST['marque'];
    $type = $_POST['type'];
    $aspect = $_POST['aspect'];
    $taille = $_POST['taille'];
    $couleur = $_POST['couleur'];
    $publicPrice = $_POST['public-price'];
    $boughtPrice = $_POST['bought-price'];
    $titre = $_POST['titre'];
    $descriptif = $_POST['descriptif'];
    $stocks = $_POST['quantite'];

    $pdo->addNewProduct($img, $fournisseur, $reference, $status, $marque, $type, $aspect, $taille, $couleur, $publicPrice, $boughtPrice, $titre, $descriptif, $stocks);
}