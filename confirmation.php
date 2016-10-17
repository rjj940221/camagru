<html>
<header>
    <title>camagru</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</header>
<body>
<?php
include_once ('header.php');
include_once ('config/database.php');
//print_r($_GET);
//print_r($_SESSION);
if (isset($_GET['mp']) && isset($_GET['mh']) && hash('whirlpool',"some random".$_GET['mp']."text") == $_GET['mh'])
{
    try {
        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stat = $pdo->prepare("UPDATE `tb_users` SET `active`=TRUE WHERE `email`=:email;");
        $stat->bindParam(':email', $_GET['mp']);
        $stat->execute();
        echo "statement executed";
        header("location: index.php");
        }
        catch(PDOException $e)
        {
            echo "Error: ";
            echo $e->getMessage();
        }
}
else
    echo "<h2>Ohps somthing seems to have gon wrong</h2>";
    ?>
</body>
