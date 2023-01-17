<?php

require_once __DIR__ . '/global.php';

$delete = false;

if (!isLoggedIn()) {
    header('Location: ../../public/login.php');
    exit();
} else if (isset($_POST['function_name'])) {
    $function_name = $_POST['function_name'];
    // Add more cases for other functions here
    if ($function_name == 'addToCart' && $_POST['arguments'][3] > 0) {
        addToCart($_POST['arguments']);
        echo json_encode(
            [
                'success' => true,
                'message' => $_SESSION['pdo']->getCarts($_SESSION['id_client'])->rowCount(),
                'totalPrice' => $_SESSION['pdo']->getTotalPrice($_SESSION['id_client'])->fetch()['somme']
            ]);
    } else if ($function_name == 'deleteFromCart') {
        deleteFromCart($_POST['arguments']);
        echo json_encode(
            [
                'success' => true,
                'message' => $_POST['arguments'][0],
                'counter' => $_SESSION['pdo']->getCarts($_SESSION['id_client'])->rowCount(),
                'totalPrice' => $_SESSION['pdo']->getTotalPrice($_SESSION['id_client'])->fetch()['somme']
            ]);
    } else if ($function_name == 'updateQuantity') {
        if (updateQuantity($_POST['arguments'])) {
            echo json_encode(
                [
                    'success' => true,
                    'message' => $_POST['arguments'][0],
                    'counter' => $_SESSION['pdo']->getCarts($_SESSION['id_client'])->rowCount(),
                    'totalPrice' => $_SESSION['pdo']->getTotalPrice($_SESSION['id_client'])->fetch()['somme']
                ]);
        } else {
            echo json_encode(
                [
                    'success' => true,
                    'counter' => $_SESSION['pdo']->getCart($_POST['arguments'][0])->fetch()['quantite'],
                    'totalPrice' => $_SESSION['pdo']->getTotalPrice($_SESSION['id_client'])->fetch()['somme']
                ]);
        }
    } else if ($_POST['arguments'][3] == 0) {
        echo json_encode(
            [
                'success' => false,
                'message' => 'error quantity'
            ]
        );
    }
}

function addToCart($arguments): void
{
    $pdo = $_SESSION['pdo'];
    $id_client = $_SESSION['id_client'];
    $reference_produit = $arguments[0];
    $prix = $arguments[1];
    $quantite = $arguments[2];
    $pdo->addToCart($id_client, $reference_produit, $quantite, $quantite * $prix);
}


function deleteFromCart($arguments): void
{
    $pdo = $_SESSION['pdo'];
    $id_panier = $arguments[0];
    $pdo->deleteFromCart($id_panier);
}

function updateQuantity($arguments): bool
{
    $pdo = $_SESSION['pdo'];
    $id_panier = $arguments[0];
    $quantite = $arguments[1];
    $pdo->updateQuantityCart($id_panier, $quantite);
    if ($pdo->getCart($id_panier)->fetch()['quantite'] === 0) {
        deleteFromCart($id_panier);
        return true;
    }
    return false;
}




