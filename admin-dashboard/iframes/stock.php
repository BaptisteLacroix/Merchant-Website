<?php

require_once('../../backend/php/global.php');
/** @var BDD $pdo */
$pdo = $_SESSION['pdo'];
$products = $pdo->getProducts();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Baptiste Lacroix">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="../../css/dashboard/stock.css">
    <link rel="stylesheet" href="../../css/dashboard/general.css">
    <title>Painting Oil Beautify</title>
</head>

<body>

<section>
    <h1>Stocks</h1>
    <div id="search-bar">
        <label>
            <input type="search" placeholder="Search...">
        </label>
    </div>
    <div>
        <table>
            <thead>
            <tr>
                <th>Items</th>
                <th>Reference</th>
                <th>Status</th>
                <th>Stocks</th>
                <th>Public Prices</th>
                <th>Bought Prices</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product) { ?>
                <tr>
                    <td>
                        <img src="data:image/jpeg;base64,<?= base64_encode($product['image']) ?>" class="sh_img"
                             alt="<?php echo $product['titre_produit'] ?>">
                    </td>
                    <td>
                        <?= $product['reference_produit'] ?>
                    </td>
                    <td>
                        TODO: STATUS
                    </td>
                    <td>
                        <?= $product['quantite_produit'] ?>
                    </td>
                    <td>
                        <?= $product['prix_public_produit'] ?>
                    </td>
                    <td>
                        <?= $product['prix_achat_produit'] ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div id="adding-box">
        <input id="showForm" type="checkbox">
        <label for="showForm">Add new product</label>
    </div>

    <div id="adding-element">
        <form method="POST" enctype="multipart/form-data" action="../../backend/php/updateStocks.php">
            <fieldset>
                <h2 class="fs-title">Product Details</h2>
                <label for="fileInput">
                    <img id="icon" src="../../img/upload.svg" alt="upload file">
                </label>
                    <input id="fileInput" type="file" name="image" accept="image/*"/>
                <label>
                    <input type="text" name="fournisseur" placeholder="Frounisseur 1"/>
                </label>
                <label>
                    <input type="text" name="reference" placeholder="FRA000"/>
                </label>
                <label>
                    <input type="checkbox" name="status" checked/>
                </label>
                <input type="button" name="next" class="next action-button" value="Next"/>
            </fieldset>
            <fieldset>
                <h2 class="fs-title">Product Profiles</h2>
                <label>
                    Marque
                    <input type="text" name="marque" placeholder="Claude Monet"/>
                </label>
                <label>
                    Titre
                    <input type="text" name="titre" placeholder="Sunflowers in Vase"/>
                </label>
                <label>
                    Type
                    <input type="text" name="type" placeholder="Oil"/>
                </label>
                <label>
                    Aspect
                    <input type="text" name="aspect" placeholder="Smooth"/>
                </label>
                <label>
                    taille
                    <input type="text" name="taille" placeholder="50x50"/>
                </label>
                <label>
                    Couleur
                    <input type="text" name="couleur" placeholder="red"/>
                </label>
                <label>
                    descriptif
                    <input type="text" name="descriptif" placeholder="Iorem ipsum"/>
                </label>
                <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                <input type="button" name="next" class="next action-button" value="Next"/>
            </fieldset>
            <fieldset>
                <h2 class="fs-title">Finalise Product</h2>
                <label>
                    Public price
                    <input type="text" name="public_price" placeholder="19.99"/>
                </label>
                <label>
                    Private Price
                    <input type="password" name="private_price" placeholder="12.99"/>
                </label>
                <label>
                    Quantity
                    <input type="password" name="quantite" placeholder="6"/>
                </label>
                <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                <input type="submit" name="submit" class="submit action-button" value="Submit"/>
            </fieldset>
        </form>
    </div>

</section>

<section>
    <div id="bottom"></div>
</section>

</body>
</html>

