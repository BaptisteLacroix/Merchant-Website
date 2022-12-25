<?php

require_once('../../backend/php/global.php');
/** @var BDD $pdo */
$pdo = $_SESSION['pdo'];
$suppliers = $pdo->getAllSuppliers()->fetchAll();

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
                <tr>
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
</section>
</body>
</html>