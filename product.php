<?php

require __DIR__ . '/backend/php/global.php';

$pdo = $_SESSION['pdo'];
$product = $pdo->getProductReference($_GET['reference']);

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
<?php require_once(__DIR__ . '/navbar.php'); ?>
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
                <button class="cart-button">
                    <span class="add-to-cart">Add to cart</span>
                    <span class="added">Added</span>
                    <i class="fas fa-shopping-cart"></i>
                    <i class="fas fa-box"></i>
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
</body>

</html>