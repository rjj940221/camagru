<?php
session_start();
include_once ("../config/database.php");


function overlay_save($user, $over,$user_width, $user_height,$DB_DSN, $DB_USER, $DB_PASSWORD)
{
    if (isset($_SESSION['logged_on_user'])) {
        $over = imagescale($over, $user_width, $user_height, IMG_BILINEAR_FIXED);
        imagecopymerge_alpha($user, $over, 0, 0, 0, 0, $user_width, $user_height, 100);

        imagejpeg($user, "temp.jpeg");

        $image = file_get_contents('temp.jpeg');
        $image = base64_encode($image);
        //eval("rm temp.jpeg");

        try {
            $dpo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $dpo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stat = $dpo->prepare("INSERT INTO `tb_images` (`user_id`, `image`) VALUES (:user_id, :image);");
            $stat->bindParam(':image', $image);
            $stat->bindParam(':user_id', $_SESSION['logged_on_user']);
            $stat->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    } else
        echo false;
}

function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
{

    $cut = imagecreatetruecolor($src_w, $src_h);
    imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
    imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);

    imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);

}