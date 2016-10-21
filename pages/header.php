<html>
<header>
    <title>camagru</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../resizestyle.css" media="(max-width: 640px)">
    <script src="../gallery.js"></script>
    <script src="../scripts.js"></script>
    <meta name="viewport" content="width=device-width,initial-scale=1">
</header>
<body>
<div id="header">
    <ul class="nav_ul">
        <li class="nav_itm">
            <a class='nav_a' href='/camagru/pages/index.php'>HOME</a>
        </li>
        <li class="nav_itm">
            <a class='nav_a' href='/camagru/pages/gallery.php'>GALLERY</a>
        </li>
        <?php
        session_start();
        if (!(isset($_SESSION['logged_on_user'])) || $_SESSION['logged_on_user'] == "")
            echo "
<li class='nav_itm' style='float: right'>
    <a  class='nav_a' href='/camagru/pages/login.php'>LOGIN</a>
 </li>
 <li class='nav_itm' style='float: right'>
    <a class='nav_a' href='/camagru/pages/register.php'>REGISTER</a>
</li>";
        else
            echo "
<li class='nav_itm' style='float: right'>
    <a class='nav_a' href='/camagru/phpscripts/logout.php'>LOGOUT</a>
</li>";
        ?>
    </ul>
</div>


