<html>
<header>
    <title>camagru</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src='gallery.js'></script>
</header>
<body>
<?php
include_once('header.php');
?>
<div id="gallery">
    <?php
    include_once('config/database.php');

    try {
        $dpo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $dpo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $data = $dpo->query("SELECT * FROM `tb_images`;");
        if ($data) {
            foreach ($data as $row) {
                echo "<div class='gallery_div'><img class='gallery_img' src='data:image/png;base64," . $row['image'] . "'/></div>";
            }
        } else {
            echo "failure";
        }

    } catch (PDOException $e) {
        echo $e->errorInfo;
    }
    ?>
</div>
<div id="dialog_back" >
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
                    echo "";
                } else
                    echo "login for more options"
                ?>
            </div>
            <div id="gallery_dialog_add_comment">
                <?php
                if (isset($_SESSION['logged_on_user'])) {
                    echo "";
                } else
                    echo "login to leave a comment";
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>