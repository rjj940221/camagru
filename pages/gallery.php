
<?php
include_once('header.php');
?>
<div id="content">
    <div id="gallery">
    </div>
    <div id='pager'>
        <ul id="pager_list" class="pagination">

        </ul>
    </div>
    <div id="dialog_back">
        <div id="gallery_dialog" class="dialog">
            <div id="gallery_dialog_content">
                <div id="gallery_dialog_image">
                    <img id="gallery_dialog_img" src="" alt="failed to load image data">
                </div>
                <div id="gallery_dialog_comments">
                    <h3>Comments</h3>
                </div>
                <div id='gallery_dialog_action'>
                    <?php
                    if (isset($_SESSION['logged_on_user'])) {
                        echo "<button class='gallery_dialog_action' id='gallery_dialog_like'>like</button>";
                    } else
                        echo "login for more options"
                    ?>
                </div>
                <div id="gallery_dialog_add_comment">
                    <?php
                    if (isset($_SESSION['logged_on_user'])) {
                        echo "
                        <textarea id='gallery_dialog_add_comment_txt' ></textarea>
                        <button id='gallery_dialog_add_comment_btn'>Post Comment</button>
";
                    } else
                        echo "login to leave a comment";
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="footer">
    <div id="footer_content">camagru&#169;<i>rojones</i></div>
</div>
</body>
</html>