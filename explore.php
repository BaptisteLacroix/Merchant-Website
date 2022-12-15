<?php

require './backend/php/connectionBDD.php';

$pdo = new bdd();
$products = $pdo->getProducts();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Baptiste Lacroix">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/explore.css">
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
<section>
    <div id="top">
        <h1>Explorer</h1>
    </div>
</section>
<section id="explorer">
    <div class="container">
        <?php foreach ($products as $product) { ?>
            <div class="card">
                <div>
                    <h1 id="<?php echo $product['reference_produit'] ?>"><?php echo $product['titre_produit'] ?></h1>
                    <p><?php echo $product['descriptif_produit'] ?></p>
                    <button class="btn-information cta">
                        <span class="hover-underline-animation">Shop now</span>
                    </button>
                </div>
                <div class="cover">
                    <div class="cover-front">
                        <div>
                            <img src="./img/<?php echo $product['reference_produit'] ?>.png" class="sh_img"
                                 alt="<?php echo $product['titre_produit'] ?>">
                        </div>
                    </div>
                    <div class="cover-back"></div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
<script>
    // Select all the buttons and add onclickevent to them
    // this onclick will send the user to the product page of the element
    // The information is contained on  $product['reference_produit']
    const buttons = document.querySelectorAll('.btn-information');
    buttons.forEach(button => {
        button.addEventListener('click', () => {
            window.location.href = `./product.php?reference=${button.parentElement.parentElement.children[0].children[0].id}`;
        });
    });
</script>
<footer>
    <p>
        <a href="mailto:baptiste&period;lacroix&commat;etu&period;unice&period;fr">Lacroix Baptiste</a>
    </p>
</footer>
</body>

</html>