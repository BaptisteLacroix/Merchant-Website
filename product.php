<?php

require __DIR__ . '/backend/php/global.php';

$pdo = $_SESSION['pdo'];
$product = $pdo->getProductByReference($_GET['reference']);

// get the first product
$product = $product->fetch();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Baptiste Lacroix">
    <link rel="stylesheet" href="css/product.css">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Painting Oil Beautify</title>
</head>

<body>
<?php require_once(__DIR__ . '/backend/php/navbar.php'); ?>
<section>
    <!-- Centrer les deux box -->
    <div class="product-container">
        <div class="cover">
            <!-- Conteneur gauche centré par rapport au conteneur droit -->
            <div class="container-left">
                <div class="magnify">
                    <div class="magnifier"></div>
                    <div class="magnified">
                        <img id="myimage" src="img/<?php echo $product['reference_produit'] ?>.png" alt="image">
                    </div>
                </div>
            </div>
            <div class="desc">
                <h1><?= $product['titre_produit'] ?></h1>
                <p>
                    <?= $product['descriptif_produit'] ?>
                </p>
                <h1 class="price">
                    <?= $product['prix_public_produit'] ?> €
                </h1>
                <?php $stock = $product['quantite_produit'] ?>
                <h3 id="stock"><?= $stock ?> en stocks</h3>
                <button class="cart-button"
                    <?php if ($stock > 0) {
                        echo 'onclick="addToCart()"';
                    } else {
                        echo 'style="opacity: 0.5"';
                        echo 'disabled="true"';
                    } ?>>
                    <span>Add to cart</span>
                    <div class="cart">
                        <svg viewBox="0 0 36 26">
                            <polyline points="1 2.5 6 2.5 10 18.5 25.5 18.5 28.5 7.5 7.5 7.5"></polyline>
                            <polyline points="15 13.5 17 15.5 22 10.5"></polyline>
                        </svg>
                </button>
            </div>
        </div>
</section>
<section id="commentary">

</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="backend/javascript/magnifyingEffect.js"></script>
<script src="backend/javascript/commentary.js"></script>
<script src="./backend/javascript/footer.js"></script>
<script>
    function addToCart() {
        $.ajax({
            url: './backend/php/shoppingCart.php',
            type: 'POST',
            data: {
                function_name: 'addToCart',
                arguments: ['<?php echo $product['reference_produit'] ?>', "<?php echo $product['prix_public_produit'] ?>", "1", "<?php echo $product['quantite_produit'] ?>"]
            },
            success: function (response) {
                // Handle the response
                let data = JSON.parse(response);
                if (data.success) {
                    $("#cart-quantity").text(data.message);
                } else if (data.message === 'error quantity') {
                    alert("Ce produit n'est plus en stock");
                } else {
                    // redirect to login.php
                    window.location.href = data.message;
                }
            }
        });
    }

    document.querySelectorAll('.cart-button').forEach(button => button.addEventListener('click', e => {
        if(!button.classList.contains('loading')) {
            button.classList.add('loading');
            setTimeout(() => button.classList.remove('loading'), 3700);
        }
        e.preventDefault();
    }));
</script>
</body>

</html>