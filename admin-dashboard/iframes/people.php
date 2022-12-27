<?php

require_once('../../backend/php/global.php');


/** @var BDD $pdo */
$pdo = $_SESSION['pdo'];

require_once '../globalAdmin.php';

testConnectionIframes($pdo);

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
                <tr id="<?= $client['id_client'] ?>">
                    <td>
                        <button class="delete" onclick="deleteFromUsers(<?= $client['id_client'] ?>)">
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
    <div id="adding-element">
        <?php if (!empty($_GET['error'])) : ?>
            <p><b style="color: red; font-weight: bolder"><?= urldecode($_GET['error']) ?></b></p>
        <?php endif ?>
        <form method="POST" enctype="multipart/form-data" action="../../backend/php/updateUsers.php">
            <table>
                <thead>
                <tr>
                    <th>Lastname</th>
                    <th>Firstname</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Postal Code</th>
                    <th>Password</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Mobile phone</th>
                    <th>Admin</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <label>
                            <input type="text" name="lastname" placeholder="lastname" required>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="text" name="firstname" placeholder="firstname" required>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="email" name="email" placeholder="email" required>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="text" name="address" placeholder="Address">
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="text" name="postalCode" pattern="^[0-9]{5}$" placeholder="Postal code">
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="password" name="password" placeholder="Password" required>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="text" name="city" placeholder="City">
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="text" name="country" placeholder="Country">
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="tel" name="phone" pattern="^[0-9]{10}$" placeholder="Mobile Phone">
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="checkbox" name="admin">
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

    function deleteFromUsers(id_client) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../backend/php/updateUsers.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('function_name=deleteFromUsers&arguments[]=' + id_client);
        xhr.onload = function () {
            if (this.status === 200 && JSON.parse(this.responseText).success) {
                removeNode(id_client);
            }
        }
    }

    function removeNode(id_client) {
        let node = document.getElementById(id_client);
        let parentNode = node.parentNode;
        parentNode.removeChild(node);
    }
</script>

</body>
</html>