<?php
if ($_POST['register'] != "register")
    echo "Error";
elseif (!isset($_POST['email']) || !isset($_POST['con_email']) || !isset($_POST['pass']) || !isset($_POST['con_pass']))
    echo "Error";
else {
    if ($_POST['email'] !== $_POST['con_email'] || $_POST['pass'] !== $_POST['con_pass'])
        echo "Error";
    else{
        include_once ("config/database.php");
        try {
            $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
            $dpo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            // set the PDO error mode to exception
            $dpo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stat = $dpo->prepare("INSERT INTO `tb_users`( `email`, `pass`) VALUES (:email,:pass);");
            $stat->bindParam(':email', $_POST['email']);
            $stat->bindParam(':pass', $pass);
            $stat->execute();
            echo "<br/>done";
        }
        catch(PDOException $e)
        {
            if ($e->errorInfo[1] == 1062)
                echo "user exists";
            else
                echo $e->getMessage();
        }
    }
}