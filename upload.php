<?php
session_start();
include_once ("save_image.php");
include_once ("config/database.php");

if (!isset($_SESSION['logged_on_user']) /*|| $_POST['upload'] != "Upload Image"*/)
    echo "Error var test failed";
else{
    //print_r($_FILES);
    if (getimagesize($_FILES['image']['tmp_name']))
    {

        $image = addslashes($_FILES['image']['tmp_name']);
        $name = addslashes($_FILES['image']['name']);
        $image = file_get_contents($image);
        $user = imagecreatefromstring($image);
        list($user_width, $user_height) = getimagesize($_FILES['image']['tmp_name']);
        $over = file_get_contents("overlays/boarder2.png");
        $over = imagecreatefromstring($over);

        overlay_save($user, $over, $user_width, $user_height, $DB_DSN, $DB_USER, $DB_PASSWORD);
    }
    else
        echo "file error";

}
?>