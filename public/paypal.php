<?php

require_once('../backend/php/global.php');

if (!isLoggedIn()) {
    header('Location: ./login.php');
    exit();
}

/** @var BDD $pdo */
$pdo = $_SESSION['pdo'];
$id_client = $_SESSION['id_client'];

$client_informations = $pdo->getClientById($id_client)->fetch();

if ($pdo->getCarts($id_client)->rowCount() <= 0) {
    header('Location: ../index.php');
    exit();
}


if (empty($client_informations['prenom_client']) || empty($client_informations['nom_client']) ||
    empty($client_informations['email_client']) || empty($client_informations['telephone_client']) ||
    empty($client_informations['adresse_client']) || empty($client_informations['code_postal_client']) ||
    empty($client_informations['ville_client']) || empty($client_informations['pays_client'])) {

    header('Location: ./checkout.php?error=' . urlencode('Please fill all the fields with valid values'));
    exit();
}

$totalCart = json_decode($pdo->getTotalCart($id_client), true);

// calculer le prix total ht
$total_ht = $pdo->getTotalPrice($id_client)->fetch()['somme'];

// calculer le prix total ttc
$tva = $total_ht * 0.2;

$total_ttc = $total_ht + $tva;

// round ttc to 2 decimals
$total_ttc = round($total_ttc, 2);

$order = json_encode([
    'purchase_units' => [[
        'description' => 'Facture Mr/Mme ' . $client_informations['nom_client'] . ' ' . $client_informations['prenom_client'],
        'items' => array_map(function ($facture) use ($pdo) {
            return [
                'name' => $pdo->getProductByReference($facture['reference_produit'])->fetch()['titre_produit'],
                'reference' => $facture['reference_produit'],
                'unit_amount' => [
                    'currency_code' => 'EUR',
                    'value' => number_format($facture['prix'], 2, '.', ''),
                ],
                'quantity' => $facture['quantite'],
            ];
        }, $totalCart),
        'amount' => [
            'currency_code' => 'EUR',
            'value' => number_format($total_ttc, 2, '.', ''),
            'breakdown' => [
                'item_total' => [
                    'currency_code' => 'EUR',
                    'value' => number_format($total_ht, 2, '.', ''),
                ],
                'tax_total' => [
                    'currency_code' => 'EUR',
                    'value' => number_format($tva, 2, '.', ''),
                ],
            ],
        ],
    ],
    ],
]);


//put in allreferences all the references of the products in the cart, and do not put the same reference twice
$allreferences = [];
foreach ($totalCart as $product) {
    if (!in_array($product['reference_produit'], $allreferences)) {
        $allreferences[] = $product['reference_produit'];
    }
}

// check if the stock is available for each reference
foreach ($allreferences as $reference) {
    $stock = $pdo->getProductByReference($reference)->fetch()['quantite_produit'];
    $quantity = 0;
    foreach ($totalCart as $product) {
        if ($product['reference_produit'] === $reference) {
            $quantity += $product['quantite'];
        }
    }

    if ($quantity > $stock) {
        header('Location: ./checkout.php?error=' . urlencode('The stock is not available for the product ' . $reference));
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Baptiste Lacroix">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="../css/paypal.css">
    <title>Painting Oil Beautify</title>
</head>

<body>

<?php require_once('../backend/php/navbar.php'); ?>

<section>
    <div id="top">
    </div>
</section>

<!-- Replace "test" with your own sandbox Business account app client ID -->
<script src="https://www.paypal.com/sdk/js?client-id=<?= PAYPAL_ID ?>&currency=EUR"></script>
<!-- Set up a container element for the button -->
<section class="container">
    <div id="paypal-button-container"></div>
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    paypal.Buttons({
        // Sets up the transaction when a payment button is clicked
        createOrder: (data, actions) => {
            return actions.order.create(<?= $order ?>);
        },
        // Finalize the transaction after payer approval
        onApprove: (data, actions) => {
            return actions.order.capture().then(function (orderData) {
                // Successful capture! For dev/demo purposes:
                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                // const transaction = orderData.purchase_units[0].payments.captures[0];
                // alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
                // When ready to go live, remove the alert and show a success message within this page. For example:

                // Extract the desired information from the JSON message
                let description = orderData.purchase_units[0].description;
                let full_name = orderData.purchase_units[0].shipping.name.full_name;
                let email_address = orderData.purchase_units[0].payee.email_address;
                let items = orderData.purchase_units[0].items;
                let address = orderData.purchase_units[0].shipping.address;
                let amount_paid = orderData.purchase_units[0].amount.value;
                let date = orderData.create_time;

                const element = document.getElementById('paypal-button-container');
                // delete the node under element
                while (element.firstChild) {
                    element.removeChild(element.firstChild);
                }
                let title = document.createElement('h3');
                title.innerHTML = 'Thank you for your payment!';

                let text = document.createElement('p');
                text.innerHTML = 'Your order has been successfully processed. And you will receive an email confirmation shortly.';

                element.append(title);
                element.append(text);

                let button = document.createElement('button');
                button.innerHTML = 'Back to home';
                button.addEventListener('click', () => {
                    window.location.href = '../index.php';
                });
                element.append(button);
                // Update the stocks
                updateStocks(description, full_name, email_address, items, address, amount_paid, date);
            });
        }
    }).render('#paypal-button-container');

    function updateStocks(description, full_name, email_address, items, address, amount_paid, date) {
        $.ajax({
            url: '../backend/php/PaypalPayment.php', // the script where you handle the database update
            type: 'POST', // use POST method
            data: {
                function_name: 'transaction_success',
                arguments: [description, full_name, email_address, items, address, amount_paid, date]
            },
            success: function (response) { // on success
                console.log(response);
            }
        });
    }
</script>

<script src="../backend/javascript/footer.js"></script>
</body>
</html>
