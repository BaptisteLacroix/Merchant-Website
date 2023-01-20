<?php

require_once('../../backend/php/global.php');
/** @var BDD $pdo */
$pdo = $_SESSION['pdo'];

require_once '../globalAdmin.php';

testConnectionIframes($pdo);


if (!empty($_POST['function_name']) && $_POST['function_name'] == 'updateStatus') {
    $var = $pdo->updateStatus($_POST['arguments'][0]);
    echo json_encode(
        [
            'success' => !$var->fetch(),
        ]);
    exit();
} else if (!empty($_POST['search'])) {
    $products = $pdo->searchProduct($_POST['search']);
} else {
    $products = $pdo->getProducts();
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
        <form action="./stock.php" method="post">
            <label>
                <input type="search" name="search" placeholder="Search...">
            </label>
        </form>
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
                        <label style="cursor: pointer" for="fileInput<?= $product['reference_produit'] ?>">
                            <img id="img<?= $product['reference_produit'] ?>"
                                 src="data:image/webp;base64,<?= base64_encode($product['image']) ?>" class="sh_img"
                                 alt="<?= $product['titre_produit'] ?>">
                        </label>
                        <input style="display: none" id="fileInput<?= $product['reference_produit'] ?>" type="file"
                               name="file" accept="image/wepb"
                               onchange="updateImage('<?= $product['reference_produit'] ?>')"/>

                        <script>
                            document.getElementById('fileInput<?= $product['reference_produit'] ?>').addEventListener('change', function () {
                                if (this.files && this.files[0]) {
                                    let img = document.getElementById('img<?= $product['reference_produit'] ?>');
                                    img.src = URL.createObjectURL(this.files[0]);
                                }
                            });
                        </script>
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

    <div id="adding-element">
        <?php if (!empty($_GET['error'])) : ?>
            <p><b style="color: red; font-weight: bolder"><?= urldecode($_GET['error']) ?></b></p>
        <?php endif ?>
        <form id="adding-element-stock" method="POST" enctype="multipart/form-data"
              action="../../backend/php/updateStocks.php">
            <div class="tab">
                <h2 class="fs-title">Product Details</h2>
                <label id="file-label" style="cursor: pointer" for="fileInput">
                    <img id="icon" src="../../img/upload.svg" alt="upload file">
                </label>
                <input style="display: none" id="fileInput" type="file" name="file" accept="image/webp" required/>
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
                <label style="cursor: pointer; color: red" class="containerCheckBox" for="available">
                    Disabled
                </label>
                <input style="display: none" id="available" type="checkbox" name="status" checked/>
            </div>
            <div class="tab">
                <h2 class="fs-title">Product Profiles</h2>
                <label>
                    <input type="text" name="marque" placeholder="Marque" required/>
                </label>
                <label>
                    <input type="text" name="titre" placeholder="Titre" required/>
                </label>
                <label>
                    <input type="text" name="type" placeholder="Type" required/>
                </label>
                <label>
                    <input type="text" name="aspect" placeholder="Aspect" required/>
                </label>
                <label>
                    <input type="text" name="taille" placeholder="taille" required/>
                </label>
                <label>
                    <input type="text" name="couleur" placeholder="Couleur" required/>
                </label>
                <label>
                    <input type="text" name="descriptif" placeholder="descriptif"/>
                </label>
            </div>
            <div class="tab">
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
            </div>
            <div style="overflow:auto;">
                <div style="float:right;">
                    <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                    <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                </div>
            </div>
            <div style="text-align:center;margin-top:40px;">
                <span class="step"></span>
                <span class="step"></span>
                <span class="step"></span>
            </div>
        </form>
    </div>

</section>

<script src="../../backend/javascript/admin-dashboard/stock.js"></script>
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


    function updateImage(reference_produit) {

        let fileInput = document.getElementById('fileInput' + reference_produit);
        if (!fileInput) return console.log("fileInput element not found");
        let file = fileInput.files[0];
        if (!file) return console.log("file not selected");

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../../backend/php/updateStocks.php", true);
        let formData = new FormData();
        formData.append("function_name", "updateImage");
        formData.append("file", file);
        formData.append("reference", reference_produit);
        console.log(formData);
        xhr.send(formData);
        xhr.onload = function () {
            console.log(this.responseText);
            if (this.status === 200 && JSON.parse(this.responseText).success) {
                // Update image with the file above
                // window.location.reload();
            }
        }
    }

    // On image change event
    // Make a preview of the image
    document.getElementById('fileInput').addEventListener('change', function () {
        if (this.files && this.files[0]) {
            let img = document.getElementById('icon');
            img.src = URL.createObjectURL(this.files[0]);
        }
    });

    // if checkbox is checked change the innerHTML of the label and the color to red
    document.getElementById('available').addEventListener('change', function () {
        let label = document.getElementsByClassName('containerCheckBox')[0];
        if (this.checked) {
            label.innerHTML = "Disabled";
            label.style.color = "red";
        } else {
            label.innerHTML = "Active";
            label.style.color = "green";
        }
    });
</script>

</body>
</html>
