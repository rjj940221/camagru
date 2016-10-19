<html>
<header>
    <title>camagru login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</header>
<body>
<?php
include_once('header.php');
include_once("config/database.php");
session_start();

if (isset($_POST['email']) && isset($_POST['pass']) && $_POST['login'] == "login") {
    $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $PDO_ATT);
    try {
        $stat = $pdo->prepare("SELECT * from tb_users WHERE email = :email AND active=TRUE;");
        $stat->bindParam(':email', $_POST['email']);
        $stat->execute();
        $row = $stat->fetch(PDO::FETCH_ASSOC);
        if (password_verify($_POST['pass'], $row['pass'])) {
            $_SESSION['logged_on_user'] = $row['id'];
            echo "<h2>login successful</h2>";
            header("location:index.php");
        } else
            echo "login failed";
    } catch (PDOException $e) {
        echo "Oops Somethings gone wrong.";
    }
} else
    echo "<div id='login'>
    <form name='reg_user' method='post' action='login.php'>
        <input type='email' name='email' placeholder='Email' required>
        <br/>
        <input type='password' name='pass' placeholder='Password' required>
        <br/>
        <input type='submit' name='login' value='login'>
    </form>
    <a href='create_reset.php'>Forgot Password?</a>
</div>";
?>

</body>
</html>