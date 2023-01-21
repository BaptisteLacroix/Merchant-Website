<?php

require_once('../backend/php/global.php');

if (isLoggedIn() === false) {
    header('Location: ./login.php');
    exit();
}

$index = 0;
/** @var BDD $pdo */
$pdo = $_SESSION['pdo'];
$cart = $pdo->getCarts($_SESSION['id_client'])->fetchAll();
foreach ($cart as $item) {
    $carts[] = array_filter($item, function ($key) {
        return !is_int($key);
    }, ARRAY_FILTER_USE_KEY);;
}
$products = $pdo->getProductsFromCart($_SESSION['id_client']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Baptiste Lacroix">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="../css/cart.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <title>Painting Oil Beautify</title>
</head>

<body>

<?php require_once('../backend/php/navbar.php'); ?>
<section>
    <div id="top">
    </div>
</section>
<div class="container">
    <section id="cart-container">
        <table>
            <thead>
            <tr>
                <td>Remove</td>
                <td>Image</td>
                <td>Product</td>
                <td>Quantity</td>
                <td>Price</td>
                <td>Total</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product) { ?>
                <tr id="<?= $carts[$index]['id_panier'] ?>">
                    <td>
                        <button onclick="deleteFromCart(<?= $carts[$index]['id_panier'] ?>)">
                            <svg class="trash-svg" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                 preserveAspectRatio="xMidYMid meet"
                                 viewBox="0 0 36 36">
                                <path fill="currentColor"
                                      d="M6 9v22a2.93 2.93 0 0 0 2.86 3h18.23A2.93 2.93 0 0 0 30 31V9Zm9 20h-2V14h2Zm8 0h-2V14h2Z"
                                      class="clr-i-solid clr-i-solid-path-1"/>
                                <path fill="currentColor"
                                      d="M30.73 5H23V4a2 2 0 0 0-2-2h-6.2A2 2 0 0 0 13 4v1H5a1 1 0 1 0 0 2h25.73a1 1 0 0 0 0-2Z"
                                      class="clr-i-solid clr-i-solid-path-2"/>
                                <path fill="none" d="M0 0h36v36H0z"/>
                            </svg>
                        </button>
                    </td>
                    <td>
                        <img src="data:image/webp;base64,<?= base64_encode($product['image']) ?>" alt="product image">
                    </td>
                    <td>
                        <h4><?= $product['titre_produit'] ?></h4>
                    </td>
                    <td>
                        <button onclick="updateQuantity(<?= $carts[$index]['id_panier'] ?>, -1)">-</button>
                        <h3 id="cart-quantity-wanted-<?= $carts[$index]['id_panier'] ?>"
                            style="display: inline-block"><?= $carts[$index]['quantite'] ?></h3>
                        <button onclick="updateQuantity(<?= $carts[$index]['id_panier'] ?>, 1)">+</button>
                    </td>
                    <td>
                        <h4 id="price-product-<?= $carts[$index]['id_panier'] ?>"><?= $product['prix'] ?> €</h4>
                    </td>
                    <td>
                        <h4 id="price-quantity-<?= $carts[$index]['id_panier'] ?>"><?= $product['prix'] * $carts[$index]['quantite'] ?>
                            €</h4>
                    </td>
                </tr>
                <?php $index++;
            } ?>
            </tbody>
        </table>
    </section>

    <section id="cart-bottom" class="coupon-container">
        <div class="bottom-left">
            <div class="coupon">
                <h5>COUPON</h5>
                <div>
                    <p>Enter your coupon code if you have one.</p>
                    <label>
                        <input type="text" placeholder="Coupon Code">
                    </label>
                    <button>Apply code</button>
                </div>
            </div>
        </div>
        <div class="bottom-right">
            <div class="total">
                <h5>CART TOTAL</h5>
                <div class="subtotal-container">
                    <p>Subtotal</p>
                    <p class="price"><?php
                        $value = $pdo->getTotalPrice($_SESSION['id_client'])->fetch()['somme'];
                        if (empty($value)) echo "0"; else echo $value; ?> €</p>
                </div>
                <div class="tva-container">
                    <p>TVA</p>
                    <p id="tva"><?php // Montant HT * (1 + taux de TVA)
                        $tva = round($pdo->getTotalPrice($_SESSION['id_client'])->fetch()['somme'] * (1 + 0.2) - $pdo->getTotalPrice($_SESSION['id_client'])->fetch()['somme'], 2);
                        echo $tva ?>
                        €</p>
                </div>
                <div class="total-container">
                    <p>Total</p>
                    <p class="price"><?php
                        $value = $pdo->getTotalPrice($_SESSION['id_client'])->fetch()['somme'];
                        if (empty($value)) echo "0"; else echo $value; ?> €</p>
                </div>
                <div>
                    <button onclick="processCheckout()">PROCEED TO CHECKOUT</button>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="../backend/javascript/footer.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    function deleteFromCart(id_panier) {
        $.ajax({
            url: '../backend/php/shoppingCart.php',
            type: 'POST',
            data: {
                function_name: 'deleteFromCart',
                arguments: [id_panier]
            },
            success: function (response) {
                // Handle the response
                let data = JSON.parse(response);
                if (data.success) {
                    removeNode(id_panier);
                    $("#cart-quantity").text(data.counter);
                    $(".price").text(data.totalPrice + "€");
                }
            }
        });
    }

    function updateQuantity(id_panier, quantity) {
        $.ajax({
            url: '../backend/php/shoppingCart.php',
            type: 'POST',
            data: {
                function_name: 'updateQuantity',
                arguments: [id_panier, quantity]
            },
            success: function (response) {
                // Handle the response
                let data = JSON.parse(response);
                // if data.message exist
                if (data.success && !data.message) {
                    $("#cart-quantity-wanted-" + id_panier).text(data.counter);
                } else if (data.success && data.message) {
                    removeNode(id_panier);
                    $("#cart-quantity").text(data.counter);
                }
                if (data.totalPrice == null) {
                    $(".price").text("0€");
                    $("#tva").text("0€");
                } else {
                    $(".price").text(data.totalPrice + "€");
                    $("#tva").text((data.totalPrice * (1 + 0.2) - data.totalPrice).toFixed(2) + "€");
                }
                $("#price-quantity-" + id_panier).text(parseFloat($("#price-product-" + id_panier).text()) * parseFloat($('#cart-quantity-wanted-' + id_panier).text()) + "€");
            }
        });
    }

    function processCheckout() {
        if ($("#cart-quantity").text() > 0) {
            window.location.href = "checkout.php";
        }
    }


    function removeNode(id_panier) {
        let node = document.getElementById(id_panier);
        let parentNode = node.parentNode;
        parentNode.removeChild(node);
    }
</script>
</body>

</html>
