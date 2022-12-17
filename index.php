<?php

require_once __DIR__ . '/backend/php/global.php';

$pdo = $_SESSION['pdo'];
$products = $pdo->getProducts();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Baptiste Lacroix">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="css/accueil.css">
    <link rel="stylesheet" href="css/buttons.css">
    <title>Painting Oil Beautify</title>
</head>

<body>

<?php require_once(__DIR__ . '/navbar.php'); ?>

<div class="container">
    <div class="horizontal-scroll">
        <button class="btn-scroll" id="btn-scroll-left"></button>
        <button class="btn-scroll" id="btn-scroll-right"></button>
        <div class="images-containers">
            <?php foreach ($products as $product) { ?>
                <div class="image-size">
                    <img src="./img/<?php echo $product['reference_produit'] ?>.png"
                         alt="<?php echo $product['titre_produit'] ?>">
                    <a class="btn-information cta"
                       href="./product.php?reference=<?php echo $product['reference_produit'] ?>">
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
<script src="./backend/javascript/footer.js"></script>
</body>

</html>