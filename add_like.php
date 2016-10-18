<?php
session_start();
include_once ('config/database.php');
if (isset($_SESSION['logged_on_user']) && $_POST['image_id']) {
    try {
        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stat = $pdo->prepare("INSERT INTO `tb_like`(`image_id`, `user_id`) VALUES (:image_id, :user_id);");
        $stat->bindParam(':user_id', $_SESSION['logged_on_user']);
        $stat->bindParam(':image_id', $_POST['image_id']);
        $stat->execute();
        echo "true";
    } catch (PDOException $e) {
        echo " some thing went wrong with the database ";
        echo $e->getMessage();
    }
}
else
    echo "false";