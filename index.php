<html>
<header>
    <title>camagru</title>
    <link rel='stylesheet' type='text/css' href='style.css'>
    <script src='scripts.js'></script>
</header>
<body>
<?php
include_once('header.php');

?>
<?php

session_start();
if (isset($_SESSION['logged_on_user'])) {
    echo "
<div id='capture'>
    <div id='scroll'>
            <div class='over'><img class='over_img' src='overlays/boarder1.png'></div>
            <div class='over'><img class='over_img' src='overlays/boarder2.png'></div>
            <div class='over'><img class='over_img' src='overlays/boarder3.png'></div>
            <div class='over'><img class='over_img' src='overlays/boarder4.png'></div>
            <div class='over'><img class='over_img' src='overlays/boarder5.png'></div>
            <div class='over'><img class='over_img' src='overlays/boarder6.png'></div>
    </div>
    <div id='upload'>
        <form action='' enctype='multipart/form-data'>
            Select image to upload:
            <input type='file' name='image' id='fileToUpload' accept='image/*' required>
        </form>
        <button name='upload' id='btn_upload' disabled>Upload Image</button>

    </div>
    <div id='camera'>
        <video id='video'>Video stream not available.</video>
        <button id='startbutton' disabled>Take photo</button>
        <canvas id='canvas'>
        </canvas>
    </div>
</div>
<div id='user_upload'>

</div>
";
} else
    echo "Login for more features.";
?>
</body>
</html>
