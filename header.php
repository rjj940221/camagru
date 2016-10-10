
    <ul class="nav_ul">
        <li class="nav_itm">
            <a  class='nav_a' href='index.php'>HOME</a>
        </li>
        <li class="nav_itm">
            <a  class='nav_a' href='gallery.php'>GALLERY</a>
        </li>

            <?php
            if(!(isset($_SESSION['logged_on_user'])) || $_SESSION['logged_on_user'] == "")
                echo "<li class='nav_itm' style='float: right'>
<a  class='nav_a' href='login.php'>LOGIN</a>
 </li><li class='nav_itm' style='float: right'>
 <a class='nav_a' href='register.php'>REGISTER</a>
</li>";
            else
                echo "<li class='nav_itm' style='float: right'><button onclick='' class='nav_itm'>LOGOUT</button></li>";
            ?>
    </ul>

