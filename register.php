<html>
<header>
    <title>camagru</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</header>
<body>
<?php
include_once ('header.php');
?>

<form action="transact_register.php" name="register" method="post">
    <input type="email" name="email" required placeholder="Email">
    <br/>
    <input type="email" name="con_email" required placeholder="Confirm email">
    <br/>
    <input type="password" name="pass" required placeholder="Password">
    <br/>
    <input type="password" name="con_pass" required placeholder="Confirm Password">
    <br/>
    <input type="submit" name="register" value="register">
</form>
</body>
</html>