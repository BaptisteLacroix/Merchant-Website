<?php


require_once __DIR__ . '/global.php';

$delete = false;
$pdo = $_SESSION['pdo'];
$id_client = $_SESSION['id_client'];

if (!isLoggedIn()) {
    echo json_encode(
        [
            'success' => false,
            'message' => 'login.php'
        ]
    );
} else if (isset($_POST['transaction_success'])) {
    $function_name = $_POST['transaction_success'];
    // Add more cases for other functions here
    if ($function_name == 'transaction_success') {
        updateQuantity($pdo, $id_client);
        createNewFacture($pdo);
        deleteCartClient($pdo, $id_client);
    }
}

function createNewFacture($pdo) {
    $pdo->insertNewFacture($_SESSION['email_client']);
}

function updateQuantity($pdo, $id_client): void
{
    $totalCart = json_decode($pdo->getTotalCart($id_client), true);
    $allreferences = [];
    foreach ($totalCart as $product) {
        if (!in_array($product['reference_produit'], $allreferences)) {
            $allreferences[] = $product['reference_produit'];
        }
    }
    // Update the stock for each reference
    foreach ($allreferences as $reference) {
        $stock = $pdo->getProductByReference($reference)->fetch()['quantite_produit'];
        $quantity = 0;
        foreach ($totalCart as $product) {
            if ($product['reference_produit'] === $reference) {
                $quantity += $product['quantite'];
            }
        }
        $pdo->updateProductStocksByReference($reference, $stock - $quantity);
    }
}

function deleteCartClient($pdo, $id_client): void
{
    $pdo->deleteCartClient($id_client);
}