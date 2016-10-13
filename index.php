<html>
<header>
    <title>camagru</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="scripts.js"></script>
</header>
<body>
<?php
include_once ('header.php');

?>
<div id="capture">
    <div id="upload">
        <form action="upload.php" method="post" enctype="multipart/form-data">
            Select image to upload:
            <input type="file" name="imageToUpload" id="fileToUpload" accept="image/*" required>
            <br/>
            <input type="submit" value="Upload Image" name="upload">
        </form>
    </div>
    <div id="camera">
        <video id="video">Video stream not available.</video>
        <button id="startbutton">Take photo</button>
        <canvas id="canvas">
        </canvas>
    </div>
</div>
<div id="upload">
    <?php
    include_once ("config/database.php");
    session_start();
    $pdo = new PDO($DB_DSN,$DB_USER,$DB_PASSWORD, $PDO_ATT);
    try {
        $stat = $pdo->prepare("SELECT * from `tb_images` WHERE `user_id` = :user_id;");
        $stat->bindParam(':user_id', $_SESSION['logged_on_user']);
        $stat->execute();
        while ($row = $stat->fetch(PDO::FETCH_ASSOC))
        {
            echo "<div><img class='img_thumb' src='data:image/png;base64,".$row['image']."' /></div>";
        }
    }
    catch (PDOException $e) {
        echo "alert($e)";
    }
    ?>
</div>
</body>
</html>