<?php

require_once('../../backend/php/global.php');

/** @var BDD $pdo */
$pdo = $_SESSION['pdo'];

require_once '../globalAdmin.php';

testConnectionIframes($pdo);

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
    <link rel="stylesheet" href="../../css/dashboard/account.css">
    <title>Painting Oil Beautify</title>
</head>

<body>

<section>
    <h2>All Statistics</h2>
    <div class="top">
        <div class="container" id="revenue-year">
            <div>
                <h3>Revenue this year (TTC)</h3>
                <?php
                $revenue = $pdo->getTotalRevenueTTCByYears();
                ?>
                <span style="color: #456aff">+<?= $revenue == null ? 0 : $revenue ?>€</span>
            </div>
            <div>
                <h3>Profit this year (TTC)</h3>
                <?php
                $profit = $pdo->getProfit();
                $color = $profit > 0 ? 'green' : 'red';
                ?>
                <span style="color: <?= $color ?>"><?= $profit > 0 ? '+' : '-' ?><?= $profit ?>€</span>
            </div>
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
            <h3>Units sold this year</h3>
            <span style="font-size: 60px;"><?= $pdo->getTotalQuantity() ?></span>
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
                <canvas id="revenueMonth" style="background: #20283c; width: 50%;"></canvas>
            </div>
        </div>
</section>

<script>
    let totalRevenue = <?= $pdo->getTotalRevenueHT() ?>;
    let totalQuantity = <?= $pdo->getTotalQuantity() ?>;

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

    <?php
    // Initialize variables
    $achats_client = 0;
    $achats = 0;

    $pursahes = $pdo->getPurshasingPriceForEachMonth();
    $sales = $pdo->getSalesPriceForEachMonth();

    echo "const achats = " . json_encode($pursahes) . ";\n";
    echo "const ventes = " . json_encode($sales) . ";";

    ?>
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../../backend/javascript/admin-dashboard/revenueMonth.js"></script>
</body>
</html>
