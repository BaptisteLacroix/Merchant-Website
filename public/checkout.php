<?php

require_once('../backend/php/global.php');

$pdo = $_SESSION['pdo'];

if (!isLoggedIn()) {
    header('Location: ./login.php');
    exit();
}

$id_client = $_SESSION['id_client'];
$email_client = $_SESSION['email_client'];
$client_informations = $pdo->getClient($email_client)->fetch();

/** @var BDD $pdo */
if ($pdo->getCarts($id_client)->rowCount() <= 0) {
    header('Location: ./cart.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Baptiste Lacroix">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="../css/checkout.css">
    <title>Painting Oil Beautify</title>
</head>

<body>

<?php require_once('../backend/php/navbar.php'); ?>

<section>
    <div id="top">

    </div>
</section>

<section class="container">
    <div>
        <form method="post" action="../backend/php/processForm.php">
            <?php if (!empty($_GET['error'])) : ?>
                <h1 style="text-align: center; display: block"><b style="color: red; font-weight: bolder"><?= urldecode($_GET['error']) ?></b></h1>
            <?php endif ?>
            <table>
                <tbody>
                <tr>
                    <th colspan="2">Personnal Informations</th>
                </tr>
                <tr>
                    <td>
                        <label for="firstName">FirstName</label>
                    </td>
                    <td>
                        <input type="text" id="firstName" name="firstName"
                               value="<?= $client_informations['prenom_client'] ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="lastName">LastName</label>
                    </td>
                    <td>
                        <input type="text" id="lastName" name="lastName"
                               value="<?= $client_informations['nom_client'] ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="email">Email</label>
                    </td>
                    <td>
                        <input type="email" id="email" name="email" value="<?= $client_informations['email_client'] ?>"
                               required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="tel">Mobile Phone</label>
                    </td>
                    <td>
                        <input type="tel" pattern="^[0-9]{10}$" id="tel" name="tel" value="<?= $client_informations['telephone_client'] ?>"
                               required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="address">Address</label>
                    </td>
                    <td>
                        <input type="text" id="address" name="address"
                               value="<?= $client_informations['adresse_client'] ?>"
                               required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="postalCode">Postal Code</label>
                    </td>
                    <td>
                        <input type="text" pattern="^[0-9]{5}$" id="postalCode" name="postalCode"
                               value="<?= $client_informations['code_postal_client'] ?>"
                               required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="city">City</label>
                    </td>
                    <td>
                        <input type="text" id="city" name="city"
                               value="<?= $client_informations['ville_client'] ?>"
                               required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="country">Country</label>
                    </td>
                    <td>
                        <input type="text" id="country" name="country"
                               value="<?= $client_informations['pays_client'] ?>"
                               required>
                    </td>
                </tr>
                </tbody>
            </table>
            <button type="submit" name="payment">Payment Informations</button>
        </form>
    </div>
</section>

<script src="../backend/javascript/footer.js"></script>
</body>

</html>
