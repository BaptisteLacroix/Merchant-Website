<?php

require_once('../../backend/php/global.php');
/** @var BDD $pdo */
$pdo = $_SESSION['pdo'];
$products = $pdo->getProducts();

if (!isLoggedIn()) {
    header('Location: ../../public/login.php');
    exit();
} else if ($pdo->getAdminByClientId($_SESSION['id_client'])->rowCount() <= 0) {
    header('Location: ../../index.php');
    exit();
}

if (!empty($_POST['function_name']) && $_POST['function_name'] == 'updateStatus') {
    $var = $pdo->updateStatus($_POST['arguments'][0]);
    echo json_encode(
        [
            'success' => !$var->fetch(),
        ]);
    exit();
}

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
                <th>Delete</th>
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
                <tr id="<?= $product['id_produit'] ?>">
                    <td>
                        <button class="delete" onclick="deleteFromProducts(<?= $product['id_produit'] ?>)">
                            <svg class="trash-svg" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                 preserveAspectRatio="xMidYMid meet"
                                 viewBox="0 0 36 36">
                                <path fill="currentColor"
                                      d="M6 9v22a2.93 2.93 0 0 0 2.86 3h18.23A2.93 2.93 0 0 0 30 31V9Zm9 20h-2V14h2Zm8 0h-2V14h2Z"
                                      class="clr-i-solid clr-i-solid-path-1"/>
                                <path fill="currentColor"
                                      d="M30.73 5H23V4a2 2 0 0 0-2-2h-6.2A2 2 0 0 0 13 4v1H5a1 1 0 1 0 0 2h25.73a1 1 0 0 0 0-2Z"
                                      class="clr-i-solid clr-i-solid-path-2"/>
                                <path fill="none" d="M0 0h36v36H0z"/>
                            </svg>
                        </button>
                    </td>
                    <td>
                        <img src="data:image/jpeg;base64,<?= base64_encode($product['image']) ?>" class="sh_img"
                             alt="<?php echo $product['titre_produit'] ?>">
                    </td>
                    <td>
                        <?= $product['reference_produit'] ?>
                    </td>
                    <?php
                    $status = $product['status'] == 0 ? ["color: red", "Disabled", 0] : ["color: green", "Active", 1];
                    ?>
                    <td>
                        <button class="status-state" id="<?= $product['reference_produit'] ?>"
                                style="<?= $status[0] ?>;">
                            <?= $status[1] ?></button>
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
                <input id="fileInput" type="file" name="file" accept="image/*" required/>
                <label for="fournisseur">
                    <select name="fournisseur" id="fournisseur" required>
                        <?php
                        $suppliers = $pdo->getAllSuppliers()->fetchAll();
                        foreach ($suppliers as $supplier) {
                            echo "<option value='" . $supplier['id_fournisseur'] . "'>" . $supplier['nom_fournisseur'] . "</option>";
                        }
                        ?>
                    </select>
                </label>
                <label>
                    <input type="text" name="reference" placeholder="FRA000" required/>
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
                    <input type="text" name="marque" placeholder="Claude Monet" required/>
                </label>
                <label>
                    Titre
                    <input type="text" name="titre" placeholder="Sunflowers in Vase" required/>
                </label>
                <label>
                    Type
                    <input type="text" name="type" placeholder="Oil" required/>
                </label>
                <label>
                    Aspect
                    <input type="text" name="aspect" placeholder="Smooth" required/>
                </label>
                <label>
                    taille
                    <input type="text" name="taille" placeholder="50x50" required/>
                </label>
                <label>
                    Couleur
                    <input type="text" name="couleur" placeholder="red" required/>
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
                    <input type="number" name="public_price" placeholder="19.99" step="0.01" required/>
                </label>
                <label>
                    Private Price
                    <input type="number" name="private_price" placeholder="12.99" step="0.01" required/>
                </label>
                <label>
                    Quantity
                    <input type="number" name="quantite" placeholder="6" required/>
                </label>
                <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                <input type="submit" name="submit" class="submit action-button" value="Submit"/>
            </fieldset>
        </form>
    </div>

</section>

<script>
    const buttons = document.getElementsByClassName("status-state");
    // foreah button
    for (let i = 0; i < buttons.length; i++) {
        buttons[i].addEventListener('click', () => {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './stock.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('function_name=updateStatus&arguments[]=' + buttons[i].id);
            xhr.onload = function () {
                if (this.status === 200 && JSON.parse(this.responseText).success && buttons[i].innerText === 'Disabled') {
                    buttons[i].style.color = "green";
                    buttons[i].innerHTML = "Active";
                } else if (this.status === 200 && JSON.parse(this.responseText).success && buttons[i].innerText === 'Active') {
                    buttons[i].style.color = "red";
                    buttons[i].innerHTML = "Disabled";
                }
            }
        });
    }

    function deleteFromProducts(id_produit) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../backend/php/updateStocks.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('function_name=deleteFromProducts&arguments[]=' + id_produit);
        xhr.onload = function () {
            if (this.status === 200 && JSON.parse(this.responseText).success) {
                removeNode(id_produit);
            }
        }
    }

    function removeNode(id_produit) {
        let node = document.getElementById(id_produit);
        let parentNode = node.parentNode;
        parentNode.removeChild(node);
    }
</script>

</body>
</html>

