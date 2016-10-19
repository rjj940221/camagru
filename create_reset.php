<html>
<header>
    <title>camagru login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</header>
<body>
<?php
include_once ("header.php");
include_once ("config/database.php");

if (isset($_POST['reset_email']) && $_POST['reset_sub'] == "reset") {
    try {
        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stat = $pdo->prepare("SELECT * FROM `tb_users` WHERE `email`=:email;");
        $stat->bindParam(':email', $_POST['reset_email']);
        $stat->execute();
        $reset = $stat->fetch(PDO::FETCH_ASSOC);
        if ($stat->rowCount() == 1) {
            $id = $reset['id'];
            $sub = "Reset camagru password.";
            $to = $reset['email'];
            $content = "Pass word reset requested please follow the following link: http://localhost:8080/camagru/new_pass.php?token=" . $reset['pass'] . "&id=" . $reset['id'];
            try
            {
                $stat2 = $pdo->prepare("UPDATE `tb_users` SET `reset`=:reset WHERE `id`=:id;");
                $setstat = true;
                $stat2->bindParam(':reset', $setstat);
                $stat2->bindParam(':id', $id);
                $stat2->execute();
            }
            catch (PDOException $e)
            {
                echo "we are having a problem ";
                echo $e->getMessage();
            }
            mail($to, $sub, $content);
            echo "<h2>We have sent you an email at ".$to."</h2>";
        } else
            echo "<h2>Somthing seams to have gon wrong</h2>";
    }
    catch (PDOException $e)
    {
        echo "whe are having some truble: ".$e->getMessage();
    }
}
else
    echo "<form method='post' action=''>
    <input type='email' id='reset_email' name='reset_email' required placeholder='email@example.com'><br/> 
    <input type='submit' id='reset_sub' name='reset_sub' value='reset'> 
</form>";
?>


</body>
</html>
