<?php


require_once __DIR__ . '/global.php';
/** @var BDD $pdo */
$pdo = $_SESSION['pdo'];
$id_client = $_SESSION['id_client'];

if (!isLoggedIn()) {
    header('Location: ../../public/login.php');
    exit();
} else if (isset($_POST['function_name'])) {
    $function_name = $_POST['function_name'];
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
    $to = "baptiste.lacroix@etu.unice.fr";
    $address_line_1 = $address['address_line_1'];
    $admin_area_2 = $address['admin_area_2'];
    $admin_area_1 = $address['admin_area_1'];
    $postal_code = $address['postal_code'];
    $country_code = $address['country_code'];

    $subject = $description;
    $message = "Thank you for your purchase!\r\n\r\nYour package will be sent to:\r\n\r\nName: " . $full_name . "\r\nEmail: " . $email_address . "\r\nAddress: " . $address_line_1 . "\r\nCity: " . $admin_area_2 . "\r\nState/Province: " . $admin_area_1 . "\r\nPostal Code: " . $postal_code . "\r\nCountry: " . $country_code . "\r\n\r\nOrder Details:\r\n\r\nItem                           Quantity    Unit Amount (EUR)    Tax (EUR)\r\n";
    // loop through the items array
    foreach($items as $item) {
        $message .= $item['name'] . "                           " . $item['quantity'] . "           " . $item['unit_amount']['value'] . "              " . $item['tax']['value'] . "\r\n";
    }
    $message .= "\r\nTotal Amount: " . $amount_paid . "\r\n\r\nDate of purchase: " . $date . "\r\n\r\nThank you for choosing our store and we hope you enjoy your new oil paintings!";

    $headers = 'From: baptiste.lacroix03@gmail.com' . "\r\n" .
        'CC: baptiste.lacroix03@gmail.com';
    mail($to, $subject, $message, $headers);
}

function createNewFacture($pdo): void
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
