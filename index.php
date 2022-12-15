<?php

require './backend/php/connectionBDD.php';

$pdo = new bdd();
$products =$pdo->getProducts();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Baptiste Lacroix">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/accueil.css">
    <link rel="stylesheet" href="css/buttons.css">
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


<div class="container">
    <div class="horizontal-scroll">
        <button class="btn-scroll" id="btn-scroll-left"></button>
        <button class="btn-scroll" id="btn-scroll-right"></button>
        <div class="images-containers">
            <?php foreach ($products as $product) { ?>
                <div class="image-size">
                    <img src="./img/<?php echo $product['reference_produit'] ?>.png" alt="<?php echo $product['titre_produit'] ?>">
                    <a class="btn-information cta" href="./product.php?reference=<?php echo $product['reference_produit'] ?>">
                        <span class="hover-underline-animation">
                            Shop now
                        </span>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script src="./backend/javascript/accueil.js"></script>
<footer>
    <p>
        <a href="mailto:baptiste&period;lacroix&commat;etu&period;unice&period;fr">Lacroix Baptiste</a>
    </p>
</footer>
</body>

</html>