<?php
include_once("config/database.php");
session_start();
$respons = array();
if (isset($_SESSION['logged_on_user'])) {
    try {
        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $PDO_ATT);
        $stat = $pdo->prepare("SELECT `image`, `id` from `tb_images` WHERE `user_id` = :user_id;");
        $stat->bindParam(':user_id', $_SESSION['logged_on_user']);
        $stat->execute();
        while ($row = $stat->fetch(PDO::FETCH_ASSOC)) {
            $data = array('id'=>$row['id'], 'image_data'=>"data:image/png;base64," . $row['image']);
            $respons[] = $data;
        }
    } catch (PDOException $e) {
        echo "alert($e)";
    }
    $respons = json_encode($respons);
    echo $respons;
} else
    echo "false";
?>