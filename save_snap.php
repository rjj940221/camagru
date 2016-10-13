<?php
print_r($_POST);
if (isset($_POST['img'])) {
    $user = explode($_POST['img']);
    $user = $user[1];
    $user = imagecreatefromstring($user);
    $over = file_get_contents("overlays/funny_frame_thing.png");
    $over = imagecreatefromstring($over);

    list($user_width, $user_height) = getimagesize($_FILES['imageToUpload']['tmp_name']);
    $over = imagescale($over, $user_width, $user_height, IMG_BILINEAR_FIXED);

    imagecopymerge_alpha($user, $over, 0, 0, 0, 0, $user_width, $user_height, 100);

    imagejpeg($user, "overlays/temp.jpeg");


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
    } catch (PDOException $e) {
        echo $e;
    }
} else
    echo false;