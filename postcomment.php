<?php

if (isset($_POST['image_id']) && isset($_POST['comment']))
{
    session_start();
    include_once ('config/database.php');
    try {
        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stat = $pdo->prepare("INSERT INTO `tb_comments`(`user_id`, `comment`, `image_id`) VALUES (:user_id, :comment, :image_id);");
        $stat->bindParam(':user_id', $_SESSION['logged_on_user']);
        $stat->bindParam(':comment', $_POST['comment']);
        $stat->bindParam(':image_id', $_POST['image_id']);
        echo $stat->queryString;
        $stat->execute();
    }
    catch (PDOException $e) {
        echo " some thing went wrong with the database ";
        echo $e->getMessage();
        }

}
else
    echo "false"
?>