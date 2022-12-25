<?php
$pdo = $_SESSION['pdo'];

if (isLoggedIn() && !empty($_COOKIE['id_client'])) {
    $rows = $pdo->getCarts($_COOKIE['id_client'])->rowCount();
    //$rows = 0;
} else if (isLoggedIn() && !empty($_SESSION['id_client'])) {
    $rows = $pdo->getCarts($_SESSION['id_client'])->rowCount();
    //$rows = 0;
} else {
    $rows = 0;
}
?>

<header>
    <div class="logo"><a href="../index.php">Oil Painting</a></div>
    <div class="hamburger"><span></span></div>
    <nav class="nav-bar">
        <ul>
            <li><a href="../index.php" class="active">Home</a></li>
            <li><a href="./explore.php">
                    <svg class="icon-svg" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                         preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20">
                        <g fill="white">
                            <path fill-rule="evenodd"
                                  d="M4.475 4.475a5.5 5.5 0 1 0 7.778 7.778a5.5 5.5 0 0 0-7.778-7.778Zm6.364 6.364a3.5 3.5 0 1 1-4.95-4.95a3.5 3.5 0 0 1 4.95 4.95Z"
                                  clip-rule="evenodd"></path>
                            <path d="M11.192 13.314a1.5 1.5 0 1 1 2.122-2.122l3.535 3.536a1.5 1.5 0 1 1-2.121 2.121l-3.536-3.535Z"></path>
                        </g>
                    </svg>
                </a></li>
            <li><a href="./about.php">About Us</a></li>
            <li>
                <a href="./cart.php">
                    <svg class="icon-svg" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                         preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                        <path fill="white"
                              d="M7 22q-.825 0-1.412-.587Q5 20.825 5 20q0-.825.588-1.413Q6.175 18 7 18t1.412.587Q9 19.175 9 20q0 .825-.588 1.413Q7.825 22 7 22Zm10 0q-.825 0-1.412-.587Q15 20.825 15 20q0-.825.588-1.413Q16.175 18 17 18t1.413.587Q19 19.175 19 20q0 .825-.587 1.413Q17.825 22 17 22ZM5.2 4h14.75q.575 0 .875.512q.3.513.025 1.038l-3.55 6.4q-.275.5-.738.775Q16.1 13 15.55 13H8.1L7 15h12v2H7q-1.125 0-1.7-.988q-.575-.987-.05-1.962L6.6 11.6L3 4H1V2h3.25Z"></path>
                    </svg>
                    <span id="cart-quantity"><?= $rows ?></span>
                </a>
            </li>
            <li>
                <a href="./login.php">
                    <svg class="icon-svg" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                         preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16">
                        <g fill="white">
                            <path d="M11 6a3 3 0 1 1-6 0a3 3 0 0 1 6 0z"></path>
                            <path fill-rule="evenodd"
                                  d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"></path>
                        </g>
                    </svg>
                </a>
            </li>
            <li>
                <a href="../backend/php/logout.php">
                    <svg class="icon-svg" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                         preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                        <path fill="white"
                              d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2a9.985 9.985 0 0 1 8 4h-2.71a8 8 0 1 0 .001 12h2.71A9.985 9.985 0 0 1 12 22zm7-6v-3h-8v-2h8V8l5 4l-5 4z"/>
                    </svg>
                </a>
            </li>
        </ul>
    </nav>
</header>
<script>
    let linkNav = document.createElement('link');
    linkNav.rel = 'stylesheet';
    linkNav.type = 'text/css';
    linkNav.href = '../css/navbar.css';
    document.head.appendChild(linkNav);

    let hamburger = document.querySelector('.hamburger');
    let nav = document.querySelector('.nav-bar');
    hamburger.onclick = function () {
        nav = document.querySelector('.nav-bar');
        nav.classList.toggle('active');
        hamburger.classList.toggle('active');
    }
</script>
