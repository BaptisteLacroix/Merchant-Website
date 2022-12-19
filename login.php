<?php

require_once './backend/php/global.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit();
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

<?php require_once(__DIR__ . '/backend/php/navbar.php'); ?>

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
                <form method="post" action="./backend/php/create_session.php">
                    <h3>Sign In</h3>
                    <?php if (!empty($_GET['error'])) : ?>
                        <p><b style="color: red; font-weight: bolder"><?= urldecode($_GET['error']) ?></b></p>
                    <?php endif ?>
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
                <form method="post" action="./backend/php/create_session.php">
                    <h3>Sign Up</h3>
                    <?php if (!empty($_GET['error'])) : ?>
                        <p><b style="color: red; font-weight: bolder"><?= urldecode($_GET['error']) ?></b></p>
                    <?php endif ?>
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
