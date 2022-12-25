<?php

require_once('../../backend/php/global.php');


if (!isLoggedIn()) {
    header('Location: ../../public/login.php');
    exit();
}

/** @var BDD $pdo */
$pdo = $_SESSION['pdo'];
$clients = $pdo->getAllClient()->fetchAll();

if (!empty($_POST['function_name']) && $_POST['function_name'] == 'add') {
    $var = $pdo->addAdmin($_POST['arguments'][0]);
    echo json_encode(
        [
            'success' => !$var->fetch(),
        ]);
    exit();
} else if (!empty($_POST['function_name']) && $_POST['function_name'] == 'remove') {
    $var = $pdo->removeAdmin($_POST['arguments'][0]);
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
    <link rel="stylesheet" href="../../css/dashboard/general.css">
    <link rel="stylesheet" href="../../css/dashboard/people.css">
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
                <th>Lastname</th>
                <th>Firstname</th>
                <th>Email</th>
                <th>Address</th>
                <th>Postal Code</th>
                <th>City</th>
                <th>Country</th>
                <th>Mobile phone</th>
                <th>Admin</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($clients as $client) { ?>
                <tr>
                    <td>
                        <?= $client['nom_client'] ?>
                    </td>
                    <td>
                        <?= $client['prenom_client'] ?>
                    </td>
                    <td>
                        <?= $client['email_client'] ?>
                    </td>
                    <td>
                        <?= $client['adresse_client'] ?>
                    </td>
                    <td>
                        <?= $client['code_postal_client'] ?>
                    </td>
                    <td>
                        <?= $client['ville_client'] ?>
                    </td>
                    <td>
                        <?= $client['pays_client'] ?>
                    </td>
                    <td>
                        <?= $client['telephone_client'] ?>
                    </td>
                    <?php
                    $boolean = ($pdo->getAdminByClientId($client['id_client'])->fetch() == null);
                    if ($boolean) {
                        $className = 'addAdmin';
                        $name = 'addAdmin';
                        $text = 'Add';
                    } else {
                        $className = 'removeAdmin';
                        $name = 'removeAdmin';
                        $text = 'Remove';
                    }
                    ?>
                    <td>
                        <button class="<?= $className ?>" type="submit" value="<?= $client['id_client'] ?>"
                                name="<?= $name ?>"><?= $text ?></button>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</section>
<script>
    const addAdmin = document.querySelectorAll('.addAdmin');
    const removeAdmin = document.querySelectorAll('.removeAdmin');

    addAdmin.forEach((button) => {
        button.addEventListener('click', () => {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'people.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('function_name=add&arguments[]=' + button.value);
            xhr.onload = function () {
                // if the response == true
                if (this.status === 200 && JSON.parse(this.responseText).success) {
                    button.innerHTML = 'Remove';
                    button.classList.remove('addAdmin');
                    button.classList.add('removeAdmin');
                    button.name = 'removeAdmin';
                    // refresh the page
                    window.location.reload();
                }
            }
        })
    });

    removeAdmin.forEach((button) => {
        button.addEventListener('click', () => {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'people.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('function_name=remove&arguments[]=' + button.value);
            xhr.onload = function () {
                if (this.status === 200 && JSON.parse(this.responseText).success) {
                    button.innerHTML = 'Add';
                    button.classList.remove('removeAdmin');
                    button.classList.add('addAdmin');
                    button.name = 'addAdmin';
                    // refresh the page
                    window.location.reload();
                }
            }
        })
    });
</script>

</body>
</html>