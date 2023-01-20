<?php

require_once ('../backend/php/global.php');
/** @var BDD $pdo */
$pdo = $_SESSION['pdo'];
$products = $pdo->getProducts();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Baptiste Lacroix">
    <link rel="stylesheet" href="../css/explore.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Painting Oil Beautify</title>
</head>

<body>
<?php require_once('../backend/php/navbar.php'); ?>
<section>
    <div id="top" style="height: 0">
    </div>
</section>
<section id="explorer">
    <div class="container">
        <?php foreach ($products as $product) { ?>
            <div class="card">
                <div>
                    <h1 id="<?php echo $product['reference_produit'] ?>"><?php echo $product['titre_produit'] ?></h1>
                    <p><?php echo $product['descriptif_produit'] ?></p>
                    <button class="btn-information cta" value="<?php echo $product['reference_produit'] ?>">
                        <span class="hover-underline-animation">Shop now</span>
                    </button>
                </div>
                <div class="cover">
                    <div class="cover-front">
                        <div>
                            <img src="data:image/webp;base64,<?= base64_encode($product['image']) ?>" class="sh_img"
                                 alt="<?php echo $product['titre_produit'] ?>">
                        </div>
                    </div>
                    <div class="cover-back"></div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
<script src="../backend/javascript/explore.js"></script>
<script src="../backend/javascript/footer.js"></script>
</body>

</html>