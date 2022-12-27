<?php

require_once('../../backend/php/global.php');

/** @var BDD $pdo */
$pdo = $_SESSION['pdo'];

require_once '../globalAdmin.php';

testConnectionIframes($pdo);


$suppliers = $pdo->getAllSuppliers()->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Baptiste Lacroix">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="../../css/dashboard/general.css">
    <link rel="stylesheet" href="../../css/dashboard/update.css">
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
                <th>Remove</th>
                <th>Name</th>
                <th>Address</th>
                <th>Postal code</th>
                <th>City</th>
                <th>Country</th>
                <th>Mobile phone</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($suppliers as $supplier) { ?>
                <tr id="<?= $supplier['id_fournisseur'] ?>">
                    <td>
                        <button class="delete" onclick="deleteFromSuppliers(<?= $supplier['id_fournisseur'] ?>)">
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
                        <?= $supplier['nom_fournisseur'] ?>
                    </td>
                    <td>
                        <?= $supplier['adresse_fournisseur'] ?>
                    </td>
                    <td>
                        <?= $supplier['code_postal_fournisseur'] ?>
                    </td>
                    <td>
                        <?= $supplier['ville_fournisseur'] ?>
                    </td>
                    <td>
                        <?= $supplier['pays_fournisseur'] ?>
                    </td>
                    <td>
                        <?= $supplier['telephone_fournisseur'] ?>
                    </td>
                    <td>
                        <?= $supplier['email_fournisseur'] ?>
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
        <form method="POST" enctype="multipart/form-data" action="../../backend/php/updateSuppliers.php">
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Postal code</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Mobile phone</th>
                    <th>Email</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <label>
                            <input type="text" name="name" placeholder="Name" required>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="text" name="address" placeholder="Address" required>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="text" name="postalCode" pattern="^[0-9]{5}$" placeholder="Postal code"
                                   required>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="text" name="city" placeholder="City" required>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="text" name="country" placeholder="Country" required>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="tel" name="phone" pattern="^[0-9]{10}$" placeholder="Mobile Phone" required>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="email" name="email" placeholder="Email" required>
                        </label>
                    </td>
                </tr>
                </tbody>
            </table>

            <div id="adding-box">
                <input id="showForm" type="submit">
                <label for="showForm">Add new product</label>
            </div>
        </form>
    </div>
</section>

<script>
    function deleteFromSuppliers(id_supplier) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../backend/php/updateSuppliers.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('function_name=deleteFromSuppliers&arguments[]=' + id_supplier);
        xhr.onload = function () {
            if (this.status === 200 && JSON.parse(this.responseText).success) {
                removeNode(id_supplier);
            }
        }
    }

    function removeNode(id_supplier) {
        let node = document.getElementById(id_supplier);
        let parentNode = node.parentNode;
        parentNode.removeChild(node);
    }
</script>

</body>
</html>