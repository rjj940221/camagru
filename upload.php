<?php
session_start();
include_once ("config/database.php");

if (!isset($_SESSION['logged_on_user']) || $_POST['upload'] != "Upload Image")
    echo "Error var test failed";
else{
    //print_r($_FILES);
    if (getimagesize($_FILES['imageToUpload']['tmp_name']))
    {

        $image = addslashes($_FILES['imageToUpload']['tmp_name']);
        $name = addslashes($_FILES['imageToUpload']['name']);
        $image = file_get_contents($image);
        $user = imagecreatefromstring($image);

        $over = file_get_contents("overlays/funny_frame_thing.png");
        $over = imagecreatefromstring($over);

        list($user_width, $user_height) = getimagesize($_FILES['imageToUpload']['tmp_name']);
        $over = imagescale($over,$user_width,$user_height,IMG_BILINEAR_FIXED);

        imagecopymerge_alpha($user,$over,0,0,0,0,$user_width,$user_height,100);

        imagejpeg($user,"overlays/temp.jpeg");



        $image = file_get_contents('overlays/temp.jpeg');
        $image = base64_encode($image);
        eval("rm overlays/temp.jpeg");

        try {
            $dpo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $dpo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stat = $dpo->prepare("INSERT INTO `tb_images` (`user_id`, `image`) VALUES (:user_id, :image);");
            $stat->bindParam(':image', $image);
            $stat->bindParam(':user_id', $_SESSION['logged_on_user']);
            $stat->execute();
        }
        catch(PDOException $e)
        {
            echo $e;
        }
    }
    else
        echo "file error";

}
function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
{

    $cut = imagecreatetruecolor($src_w, $src_h);
    imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
    imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);

    imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);

}