<html>
<header>
    <title>camagru login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</header>
<body>
<?php
include_once('header.php');
session_start();

if (isset($_SESSION['logged_on_user'])) {
    echo "<h2>You are all ready logged in!</h2>";
} else {
    if ((isset($_GET['token']) && isset($_GET['id'])) ||
        (isset($_POST['reset_pass']) && isset($_POST['reset_pass_con'])
            && $_POST['submit_pass'] == "reset" && isset($_SESSION['reset_id']))
    ) {
        if (isset($_GET['token']) && isset($_GET['id'])) {
            include_once('config/database.php');
            try {
                $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stat = $pdo->prepare("SELECT `reset` FROM `tb_users` WHERE `pass`=:token AND `id`= :id;");
                $stat->bindParam(':token', $_GET['token']);
                $stat->bindParam(':id', $_GET['id']);
                $stat->execute();
                $reset = $stat->fetchColumn();
                if ($reset == true) {
                    $_SESSION['reset_id'] = $_GET['id'];
                    echo "<form id='new_pass' action='new_pass.php' method='post'>
<input type='password' id='reset_pass' required name='reset_pass'><br/>
<input type='password' id='reset_pass_con' required name='reset_pass_con'><br/>
<input type='submit' name='submit_pass' value='reset'>
</form>
";
                } else {
                    echo "<h2>This request appears to be invalid</h2>";
                }
            } catch (PDOException $e) {
                echo "<h2>Oops something went wrong</h2>";
            }
        }
        if (isset($_POST['reset_pass']) && isset($_POST['reset_pass_con'])
            && $_POST['submit_pass'] == "reset" && isset($_SESSION['reset_id'])
        ) {
            include_once('config/database.php');
            try {
                $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stat = $pdo->prepare("SELECT `reset` FROM `tb_users` WHERE `id`= :id;");
                $stat->bindParam(':id', $_SESSION['reset_id']);
                $stat->execute();
                $reset = $stat->fetchColumn();
                if ($reset == true) {
                    if ($_POST['reset_pass'] == $_POST['reset_pass_con']) {
                        try {
                            $reset_val = false;
                            $stat3 = $pdo->prepare("UPDATE `tb_users` SET `pass`=:pass, `reset`=:reset WHERE `id`=:id;");
                            $stat3->bindParam(':id', $_SESSION['reset_id']);
                            $stat3->bindParam(':pass', password_hash($_POST['reset_pass'], PASSWORD_DEFAULT));
                            $stat3->bindParam(':reset', $reset_val);
                            $stat3->execute();
                            echo "<h2>Your password was reset</h2>";
                            unset($_SESSION['reset_id']);
                        } catch (PDOException $e) {
                            echo "<h2>Oops somethings gone wrong</h2>";
                        }

                    } else
                        echo "<h2>Password mis-match</h2><form id='new_pass' action='new_pass.php' method='post'>
<input type='password' id='reset_pass' required name='reset_pass'><br/>
<input type='password' id='reset_pass_con' required name='reset_pass_con'><br/>
<input type='submit' name='submit_pass' value='reset'>
</form>";
                } else {
                    echo "<h2>This action appears to be invalid</h2>";
                }
            } catch (PDOException $e) {
                echo "<h2>Oops something went wrong</h2>";
            }

        }
    } else
        echo "<h2>This link appears to be invalid</h2>";
}
?>
</body>
</html>