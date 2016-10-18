<html>
<header>
    <title>camagru login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</header>
<body>
<?php
include_once ('header.php');
?>
<div id="login">
    <form name="reg_user" method="post" action="verify_user.php">
        <input type="email" name="email" placeholder="Email" required>
        <br/>
        <input type="password" name="pass" placeholder="Password" required>
        <br/>
        <input type="submit" name="login" value="login">
    </form>
    <a href="create_reset.php">Forgot Password?</a>
</div>
</body>
</html>