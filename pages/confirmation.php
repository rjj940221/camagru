
<?php
include_once('header.php');
?>
<div id="content">
    <?php
include_once('../config/database.php');

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
    </div>
<div id="footer">
    <div id="footer_content">camagru&#169;<i>rojones</i></div>
</div>
</body>
