<?php
session_start();
include_once("../config/database.php");

include_once "save_image.php";

if (isset($_SESSION['logged_on_user'])) {
    if (isset($_POST['img']) && isset($_POST['over_name'])) {
        $user_str =  $_POST['img'];
        $user_str = str_replace("data:image/png;base64,", "", $user_str);
        $user_str = str_replace(" ", "+", $user_str);
        $user_str = base64_decode($user_str);
        $user = imagecreatefromstring($user_str);
        imageflip($user,IMG_FLIP_HORIZONTAL);
        $over_location = str_replace("http://localhost:8080/camagru/","",$_POST['over_name']);
        $over_location = "../".$over_location;
        $over = file_get_contents($over_location);
        $over = imagecreatefromstring($over);
        list($user_width, $user_height) = getimagesizefromstring($user_str);

        overlay_save($user, $over, $user_width, $user_height,$DB_DSN, $DB_USER, $DB_PASSWORD);

    } else
        echo false;
}
else
    echo false;
?>
