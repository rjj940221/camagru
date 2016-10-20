
<?php
include_once('header.php');
?>
<div id="content">
    <?php

    if (isset($_POST['email']) && isset($_POST['con_email']) && isset($_POST['pass']) && isset($_POST['con_pass'])) {
        if ($_POST['email'] !== $_POST['con_email'] || $_POST['pass'] !== $_POST['con_pass']) {
            echo "<h2>Your data didn't match</h2>";
            echoform();
        } else {
            include_once("../config/database.php");
            try {
                $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stat = $pdo->prepare("INSERT INTO `tb_users`( `email`, `pass`) VALUES (:email,:pass);");
                $stat->bindParam(':email', $_POST['email']);
                $stat->bindParam(':pass', $pass);
                $stat->execute();
                echo "<h2>we have sent you an email</h2>";
                sendmail($_POST['email']);
            } catch (PDOException $e) {
                if ($e->errorInfo[1] == 1062) {
                    try {
                        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stat = $pdo->prepare("SELECT `active` FROM `tb_users` WHERE `email`=:email;");
                        $stat->bindParam(':email', $_POST['email']);
                        $stat->execute();
                        $active = $stat->fetchColumn();
                        if ($active == false) {
                            sendmail($_POST['email']);
                            echo "<h2>we have sent you an email</h2>";
                        } else
                            echo "This user exists";
                    } catch (PDOException $e) {
                        echo "<h2>Oops Something went wrong with our database</h2>";
                    }
                } else
                    echo "<h2>Oops Something went wrong with our database</h2>";
            }
        }
    } else
        echoform();

    function sendmail($email)
    {
        $mh = hash('whirlpool', "some random" . $email . "text");
        mail($email, "Confirm registration to camagru", "http://localhost:8080/camagru/pages/confirmation.php?mh=" . $mh . "&mp=" . $email);
    }

    function echoform()
    {
        echo "<form action='register.php' name='register' method='post'>
    <input type='email' name='email' required placeholder='Email'>
    <br/>
    <input type='email' name='con_email' required placeholder='Confirm email'>
    <br/>
    <input 
    type='password' 
    name='pass' 
    required 
    placeholder='Password' 
    pattern='^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}'
    title='Your password need to have at least 8 charecters contaning a loweccase leter, an uppercase letter, a special charicter [!@#$%^&*] and a number'>
    <br/>
    <input 
    type='password' 
    name='con_pass' 
    required 
    placeholder='Confirm Password' 
    pattern='^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}'
    title='Your password need to have at least 8 charecters contaning a loweccase leter, an uppercase letter, a special charicter [!@#$%^&*] and a number'>
    <br/>
    <input type='submit' name='register' value='register'>
</form>";
    }

    ?>
</div>
<div id="footer">
    <div id="footer_content">camagru&#169;<i>rojones</i></div>
</div>
</body>
</html>