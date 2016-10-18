<?php
include_once("config/database.php");

$respons = array();
//print_r($_POST);
if (isset($_POST['image'])) {
    try {
        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $PDO_ATT);
        $stat = $pdo->prepare("SELECT `comment` FROM `tb_comments` WHERE `image_id`=:image;");
        $stat->bindParam(':image', $_POST['image']);
        $stat->execute();
        while ($row = $stat->fetch(PDO::FETCH_ASSOC)) {
            $respons[] = $row['comment'];
        }
    } catch (PDOException $e) {
        echo "false";
    }
    $respons = json_encode($respons);
    echo $respons;
} else
    echo "false";