<?php

require './backend/php/connectionBDD.php';

$pdo = new bdd();


if (isset($_POST['login'])) {
    echo $_POST['password'];
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $hash = password_hash($password, PASSWORD_DEFAULT);

    if (empty($email) && !preg_match('/[\w\-]{2,}@[\w\-]{2,}\.[\w\-]+/', $email) || empty($password)) {
        $errorMsg = 'Please fill all the fields with valid values';
        // if the both passwords are not the same.
    } else {
        $client = $pdo->getClient($email);
        if ($client->rowCount() > 0) {
            $client = $client->fetch();
            if (password_verify($password, $client['password_client'])) {
                session_start();
                $_SESSION['client'] = $client;
                header('Location: index.php');
                exit();
            } else {
                $errorMsg = 'Wrong email or password';
            }
        } else {
            $errorMsg = 'Wrong email or password';
        }
    }

} else if (isset($_POST['register'])) {
    echo 'register';
    $prenom = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $nom = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $cpassword = filter_input(INPUT_POST, 'cpassword', FILTER_SANITIZE_STRING);

    // If there are some input non-filled
    if (empty($prenom) && !preg_match('/^[A-Za-z\s\-]+$/', $prenom) ||
        empty($nom) && !preg_match('/^[A-Za-z\s\-]+$/', $nom) ||
        empty($email) && !preg_match('/[\w\-]{2,}@[\w\-]{2,}\.[\w\-]+/', $email) ||
        empty($password) || empty($cpassword)) {
        $errorMsg = 'Please fill all the fields with valid values';
        // if the both passwords are not the same.
    } else if ($password != $cpassword) {
        $errorMsg = 'Passwords do not match';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $client = $pdo->getClient($email);
        // If email is already used
        if ($client->rowCount() > 0) {
            $errorMsg = 'Email already used';
        } else {
            $pdo->addNewClient($prenom, $nom, $email, $hash);
            $client = $pdo->getClient($email);
            $client = $client->fetch();
            session_start();
            $_SESSION['client'] = $client;
            header('Location: index.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Baptiste Lacroix">
    <link rel="stylesheet" href="css/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Painting Oil Beautify</title>
</head>

<body>

<script src="backend/javascript/navbar.js"></script>

<section>
    <div id="top"></div>
</section>

<section id="login-container">
    <div class="container">
        <div class="background-sign-in">
            <div class="box signin">
                <h2> Already have an account ? </h2>
                <button id="sign-in" class="sign-in-button">Sign in</button>
            </div>
            <div class="box signup">
                <h2> Don't have an account ? </h2>
                <button id="sign-up" class="sign-up-button">Sign up</button>
            </div>
        </div>
        <div class="form-bx">
            <div class="form sign-in-form">
                <form method="post" action="login.php">
                    <h3>Sign In</h3>
                    <?php if (isset($_POST['login']) && !empty($errorMsg)) {
                        echo '<p><b style="color: red; font-weight: bolder">' . $errorMsg . '</b></p>';
                    } ?>
                    <label>
                        <input type="email" name="email" placeholder="email@exemple.com" required>
                    </label>
                    <label>
                        <input type="password" name="password" placeholder="Password" required>
                    </label>
                    <input type="submit" name="login">
                    <div style="display: inline-block; margin-bottom: 10px;">
                        <label for="remember" style="display: inline-block"> Remember me
                            <input id="remember" name="remember" type="checkbox" value="yes">
                        </label>
                    </div>
                    <a href="#" class="forgot">Forgot password ?</a>
                </form>
            </div>
            <div class="form sign-up-form">
                <form method="post" action="login.php">
                    <h3>Sign Up</h3>
                    <?php if (isset($_POST['register']) && !empty($errorMsg)) {
                        echo '<p><b style="color: red; font-weight: bolder">' . $errorMsg . '</b></p>';
                    } ?>
                    <label>
                        <input type="text" name="firstName" placeholder="Prénom" required>
                    </label>
                    <label>
                        <input type="text" name="lastName" placeholder="Nom" required>
                    </label>
                    <label>
                        <input type="email" name="email" placeholder="email@exemple.com" required>
                    </label>
                    <label>
                        <input type="password" name="password" placeholder="Mot de passe" required>
                    </label>
                    <label>
                        <input type="password" name="cpassword" placeholder="Confirmez le mot de passe" required>
                    </label>
                    <input type="submit" name="register">
                </form>
            </div>
        </div>
    </div>
</section>
<script src="./backend/javascript/login.js"></script>
<script src="./backend/javascript/footer.js"></script>
</body>
</html>
