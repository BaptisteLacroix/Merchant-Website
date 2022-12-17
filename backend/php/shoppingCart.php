<?php

require_once __DIR__ . '/global.php';

if (!isLoggedIn()) {
    echo json_encode(
        [
            'success' => false,
            'message' => 'login.php',
        ]
    );
} else if (isset($_POST['function_name'])) {
    $function_name = $_POST['function_name'];
    // Add more cases for other functions here
    if ($function_name == 'addToCart') {
        addToCart($_POST['arguments']);
        echo json_encode(
            [
                'success' => true,
                'message' => $_SESSION['pdo']->getCart($_SESSION['id_client'])->rowCount()
            ]);
    }
}

function addToCart($arguments)
{
    $pdo = $_SESSION['pdo'];
    $id_client = $_SESSION['id_client'];
    $reference_produit = $arguments[0];
    $prix = $arguments[1];
    $quantite = $arguments[2];
    $pdo->addToCart($id_client, $reference_produit, $quantite, $quantite * $prix);
}




