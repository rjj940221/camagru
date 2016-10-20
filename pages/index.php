
<?php
include_once('header.php');

?>
<div id="content"><?php
session_start();
if (isset($_SESSION['logged_on_user'])) {
    echo "
<div id='capture'>
    <div id='scroll'>
            <div class='over'><img class='over_img' src='../overlays/boarder1.png'></div>
            <div class='over'><img class='over_img' src='../overlays/boarder2.png'></div>
            <div class='over'><img class='over_img' src='../overlays/boarder3.png'></div>
            <div class='over'><img class='over_img' src='../overlays/boarder4.png'></div>
            <div class='over'><img class='over_img' src='../overlays/boarder5.png'></div>
            <div class='over'><img class='over_img' src='../overlays/boarder6.png'></div>
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
        <img id='over_pre'>
        <button id='startbutton' disabled>Take photo</button>
    </div>
</div>
<div id='user_upload'>

</div>
";
} else
    echo "Login for more features.";
?>
    </div>
<div id="dialog_back" >
    <div id="index_dialog" class="dialog">
        <div id="index_dialog_content">
            <div id="index_dialog_image">
                <img id="index_dialog_img" src="" alt="failed to load image data">
            </div>
            <button id="index_dialog_delete">Delete</button>
        </div>
    </div>
</div>
<div id="footer">
    <div id="footer_content">camagru&#169;<i>rojones</i></div>
</div>
</body>
</html>
