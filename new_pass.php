<html>
<header>
    <title>camagru login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</header>
<body>
<?php
include_once('header.php');
session_start();

if (isset($_SESSION['logged_on_user']))
{
    echo "<h2>You are all ready logged in!</h2>";
}
else
{
    print_r($_GET);
    if (isset($_GET['token']) && isset($_GET['id']))
    {
        include_once ('config/database.php');
        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stat = $pdo->prepare("SELECT `reset` FROM `tb_users` WHERE `pass`=:token AND `id`= :id;");
        $stat->bindParam(':token', $_GET['token']);
        $stat->bindParam(':id', $_GET['id']);
        $stat->execute();
        $reset = $stat->fetchColumn();
        if($reset == true){
            echo "<div id='new_pass'>
<input type='password' id='reset_pass'><br/>
<input type='password' id='reset_pass_con'><br/>
<button>reset</button>

</div>";
        }
        else{
            echo "<h2>This action appears to be invalid</h2>";
        }
    }
    else
        echo "<h2>This link appears to be invalid</h2>";
}
?>
<h3>random</h3>
</body>
</html>