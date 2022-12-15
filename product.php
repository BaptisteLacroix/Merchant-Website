<?php

require './backend/php/connectionBDD.php';

$pdo = new bdd();
$product = $pdo->getProductReference($_GET['reference']);

// get the first product
$product = $product->fetch();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Baptiste Lacroix">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/product.css">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Painting Oil Beautify</title>
</head>

<body>
<header>
    <nav id="premier">
        <div class="nav-left">
            <ol>
                <li>
                    <a href="index.php">MENU</a>
                </li>
            </ol>
        </div>
        <div class="nav-right">
            <ol>
                <li>
                    <a href="explore.php">Explore</a>
                </li>
                <li>
                    <a href="#">About us</a>
                </li>
                <li>
                    <a href="login.php"><img id="shoppingCart" src="img/shoppingCart.png" width="1024" height="1024"
                                     alt="oil painting of shopping cart"></a>
                </li>
            </ol>
        </div>
    </nav>
</header>
<section>
    <div class="product-container">
        <div class="container-left">
            <div class="magnify">
                <div class="magnifier"></div>
                <div class="magnified">
                    <img id="myimage" src="img/<?php echo $product['reference_produit'] ?>.png" alt="image">
                </div>
            </div>
        </div>
        <div class="container-right">
            <div>
                <h3><?php echo $product['titre_produit'] ?></h3>
                <p>DALLE-E</p>
            </div>
            <div>
                <p>
                    <?php echo $product['descriptif_produit'] ?>
                </p>
            </div>

            <div>
                <h3><?php echo $product['prix_achat_produit'] ?>€</h3>
                <p><?php echo $product['quantite_produit'] ?></p>
            </div>

            <div>
                <p>Livraison gratuite</p>
                <button>Ajouter au panier</button>
            </div>
        </div>
    </div>
</section>
<section id="commentary">

</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="backend/javascript/magnifyingEffect.js"></script>
<script src="backend/javascript/commentary.js"></script>
<footer>
    <p>
        <a href="mailto:baptiste&period;lacroix&commat;etu&period;unice&period;fr">Lacroix Baptiste</a>
    </p>
</footer>
</body>

</html>