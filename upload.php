<?php
session_start();
include_once ("save_image.php");
include_once ("config/database.php");

if (!isset($_SESSION['logged_on_user']))
    echo "Error var test failed";
else{
    if (getimagesize($_FILES['image']['tmp_name']))
    {
        print_r($_POST);
        $over_location = $_POST['overlay'];
        $over_location = str_replace("http://localhost:8080/camagru/","",$over_location);
        echo "|".$over_location."|";
        $image = addslashes($_FILES['image']['tmp_name']);
        $name = addslashes($_FILES['image']['name']);
        $image = file_get_contents($image);
        $user = imagecreatefromstring($image);
        list($user_width, $user_height) = getimagesize($_FILES['image']['tmp_name']);
        $over = file_get_contents($over_location);
        $over = imagecreatefromstring($over);

        overlay_save($user, $over, $user_width, $user_height, $DB_DSN, $DB_USER, $DB_PASSWORD);
    }
    else
        echo "file error";

}
?>