<?php
session_start();

if (isset($_SESSION['logged_on_user']) && $_POST['image_id']) {
    include_once('config/database.php');
    try {
        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stat = $pdo->prepare("SELECT * FROM `tb_like` WHERE `user_id`=:user_id AND `image_id`=:image_id;");
        $stat->bindParam(':user_id', $_SESSION['logged_on_user']);
        $stat->bindParam(':image_id', $_POST['image_id']);
        $stat->execute();
        if ($stat->rowCount() == 0)
            echo "false";
        else
            echo "true";
    } catch (PDOException $e) {
        echo " some thing went wrong with the database ";
        echo $e->getMessage();
    }
}
else
    echo "Missing Data";
?>