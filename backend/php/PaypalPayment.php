<?php


require_once __DIR__ . '/global.php';

$pdo = $_SESSION['pdo'];
$id_client = $_SESSION['id_client'];

print_r($_POST);

if (!isLoggedIn()) {
    header('Location: ../../public/login.php');
    exit();
} else if (isset($_POST['transaction_success'])) {
    $function_name = $_POST['transaction_success'];
    // Add more cases for other functions here
    if ($function_name == 'transaction_success') {
        updateQuantity($pdo, $id_client);
        createNewFacture($pdo);
        deleteCartClient($pdo, $id_client);
        sendmail($_POST['arguments'][0],
            $_POST['arguments'][1],
            $_POST['arguments'][2],
            $_POST['arguments'][3],
            $_POST['arguments'][4],
            $_POST['arguments'][5],
            $_POST['arguments'][6]);
    }
}

function sendmail($description, $full_name, $email_address, $items, $address, $amount_paid, $date): void
{
    $to = 'baptiste.lacroix@etu.unice.fr';
    $subject = $description;
    $message = $email_address .
        "\r\npackage send at " . $full_name .
        "\r\nadresse : " . $address .
        "\r\nList of all oil paintings buy : " . $items .
        "\r\nTotal amount : " . $amount_paid .
        "\r\nDate : " . $date;
    $headers = 'From:Oil Painting company';
    echo "<hr>";
    echo 'mail send';
    mail($to, $subject, $message, $headers);
}

function createNewFacture($pdo)
{
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
