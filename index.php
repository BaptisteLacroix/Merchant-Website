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

<script>

    // Const
    const sCont = document.querySelector(".images-containers");
    const hScroll = document.querySelector(".horizontal-scroll");
    // let
    let currentScrollPosition = 0;
    let scrollAmount = 320;
    let maxScroll = -sCont.offsetWidth + hScroll.offsetWidth;

    let buttonLeft = document.getElementById('btn-scroll-left');
    let buttonRight = document.getElementById('btn-scroll-right');

    function addListener() {
        // The base ID for the <span> elements
        let divContainer = document.getElementsByClassName('images-containers');
        // foreach divContainer add event listener
        for (let i = 0; i < divContainer.length; i++) {
            divContainer[i].addEventListener('wheel', function (event) {
                // If wheel up so go left
                event.preventDefault();
                if (event.deltaY < 0) {
                    scrollHorizontally(1);
                } else {
                    scrollHorizontally(-1);
                }
            });
        }
    }


    // Define a function that creates and adds the elements to the page
    function createElements() {
        // Left button
        buttonLeft.onclick = () => {
            scrollHorizontally(1);
        };
        buttonLeft.style.opacity = "0";

        // Right button
        buttonRight.onclick = () => {
            scrollHorizontally(-1);
        };


        addListener();
    }


    function scrollHorizontally(val) {
        currentScrollPosition += val * scrollAmount;

        if (currentScrollPosition >= 0) {
            currentScrollPosition = 0;
            buttonLeft.style.opacity = 0;
        } else {
            buttonLeft.style.opacity = 1;
        }

        if (currentScrollPosition <= maxScroll) {
            currentScrollPosition = maxScroll
            buttonRight.style.opacity = 0;
        } else {
            buttonRight.style.opacity = 1;
        }

        sCont.style.left = currentScrollPosition + "px";
    }

    createElements();

</script>
<footer>
    <p>
        <a href="mailto:baptiste&period;lacroix&commat;etu&period;unice&period;fr">Lacroix Baptiste</a>
    </p>
</footer>
</body>

</html>