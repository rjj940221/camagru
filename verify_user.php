<?php
include_once ("config/database.php");
session_start();

if ($_POST['login'] !== "login")
    echo "Error";
else{
    if (!isset($_POST['email']) || !isset($_POST['pass']))
        echo "Error";
    else {
        $pdo = new PDO($DB_DSN,$DB_USER,$DB_PASSWORD, $PDO_ATT);
        try {
            $stat = $pdo->prepare("SELECT * from tb_users WHERE email = :email;");
            $stat->bindParam(':email', $_POST['email']);
            $stat->execute();
            $row = $stat->fetch(PDO::FETCH_ASSOC);
            if (password_verify($_POST['pass'], $row['pass'])) {
                $_SESSION['logged_on_user'] = $row['id'];
                echo "login successful";
                print_r($_SESSION);
                header("location:index.php");
            }

            else
                echo "login failed";
        }
        catch (PDOException $e) {
            echo "alert($e)";
        }
    }
}
?>