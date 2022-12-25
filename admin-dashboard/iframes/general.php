<?php


require_once('../../backend/php/global.php');

/** @var BDD $pdo */
$pdo = $_SESSION['pdo'];
$products = $pdo->getProducts();
$products2 = $pdo->getProducts();
$products3 = $pdo->getProducts();
$data = json_decode($pdo->getAllData(), true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Baptiste Lacroix">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="../../css/dashboard/general.css">
    <title>Painting Oil Beautify</title>
</head>

<body>

<section>
    <h2>All Statistics</h2>
    <div class="top">
        <div class="container" id="revenue-year">
            <h1><?= $pdo->getTotalRevenueTTC() ?>€</h1>
            <h3>Revenue this year (TTC)</h3>
        </div>
        <div class="container product-s">
            <h3>By product (HT)</h3>
            <div class="container-products">
                <ul>
                    <?php foreach ($products as $product) { ?>
                        <li>
                            <div class="container-product-ref">
                                <p><?= $product['reference_produit'] ?></p>
                                <p><?= $pdo->getRevenueProduct($product['reference_produit']) ?>€</p>
                            </div>
                            <div class="bar">
                                <div class="progressBar" id="<?= $product['reference_produit'] ?>-revenue">
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="container" id="units-sold-year">
            <h1><?= $pdo->getTotalQuantity() ?></h1>
            <h3>Units sold this year</h3>
        </div>
        <div class="container product-s">
            <h3>By product</h3>
            <div class="container-products">
                <ul>
                    <?php foreach ($products2 as $product) { ?>
                        <li>
                            <div class="container-product-ref">
                                <p><?= $product['reference_produit'] ?></p>
                                <p><?= $pdo->getQuantityProduct($product['reference_produit']) ?></p>
                            </div>
                            <div class="bar">
                                <div class="progressBar" id="<?= $product['reference_produit'] ?>-quantity">
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="bottom">
        <div>
            <h3>Monthly revenue</h3>
            <div class="" id=""></div>
        </div>
        <div>
            <h3>By product</h3>
            <div>
                <canvas id="productMonth" height="300" width="600" style="background: white"></canvas>
            </div>
        </div>
</section>

<script>
    let totalRevenue = <?= $pdo->getTotalRevenueHT() ?>;
    let totalQuantity = <?= $pdo->getTotalQuantity() ?>;

    console.log(totalRevenue);


    let listOfReferences = [];
    let listOfRevenue = [];
    let listOfQuantity = [];

    // On load window
    <?php foreach ($products3 as $product) { ?>
    listOfReferences.push("<?= $product['reference_produit'] ?>");
    listOfRevenue.push(<?= $pdo->getRevenueProduct($product['reference_produit']) ?>);
    listOfQuantity.push(<?= $pdo->getQuantityProduct($product['reference_produit']) ?>);
    <?php } ?>

    let listOfRevenuePercent = [];
    let listOfQuantityPercent = [];

    for (let i = 0; i < listOfRevenue.length; i++) {
        listOfRevenuePercent.push((listOfRevenue[i] / totalRevenue) * 100);
        listOfQuantityPercent.push((listOfQuantity[i] / totalQuantity) * 100);
    }

    for (let i = 0; i < listOfRevenuePercent.length; i++) {

        document.getElementById(listOfReferences[i] + "-revenue").style.width = listOfRevenuePercent[i] + "%";
    }

    for (let i = 0; i < listOfQuantityPercent.length; i++) {
        document.getElementById(listOfReferences[i] + "-quantity").style.width = listOfQuantityPercent[i] + "%";
    }

</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../../backend/javascript/admin-dashboard/revenueMonth.js"></script>
</body>
</html>
