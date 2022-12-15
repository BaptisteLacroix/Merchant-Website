<?php


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Baptiste Lacroix">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Painting Oil Beautify</title>
</head>

<body>

<header>
    <nav id="premier">
        <div class="nav-left">
            <ol>
                <li>
                    <a href="index.php">MENU</a>
                </li>
            </ol>
        </div>
        <div class="nav-right">
            <ol>
                <li>
                    <a href="explore.php">Explore</a>
                </li>
                <li>
                    <a href="#">About us</a>
                </li>
                <li>
                    <a href="#"><img id="shoppingCart" src="img/shoppingCart.png" width="1024" height="1024"
                                     alt="oil painting of shopping cart"></a>
                </li>
            </ol>
        </div>
    </nav>
</header>

<section>
    <p id="top"></p>
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
                <form>
                    <h3>Sign In</h3>
                    <label>
                        <input type="email" placeholder="email@exemple.com" required>
                    </label>
                    <label>
                        <input type="password" placeholder="Password" required>
                    </label>
                    <input type="submit" value="login">
                    <a href="#" class="forgot">Forgot password ?</a>
                </form>
            </div>
            <div class="form sign-up-form">
                <form>
                    <h3>Sign Un</h3>
                    <label>
                        <input type="text" placeholder="FirstName" required>
                    </label>
                    <label>
                        <input type="text" placeholder="LastName" required>
                    </label>
                    <label>
                        <input type="email" placeholder="email@exemple.com" required>
                    </label>
                    <label>
                        <input type="password" placeholder="Password" required>
                    </label>
                    <label>
                        <input type="password" placeholder="Confirm Password" required>
                    </label>
                    <input type="submit" value="register">
                </form>
            </div>
        </div>
    </div>
</section>
<script src="./backend/javascript/login.js"></script>
</body>
</html>
