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
            sendmail($_POST['email']);
        }
        catch(PDOException $e)
        {
            if ($e->errorInfo[1] == 1062){
                try {
                    $dpo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                    $dpo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stat = $dpo->prepare("SELECT `active` FROM `tb_users` WHERE `email`=:email;");
                    $stat->bindParam(':email', $_POST['email']);
                    $stat->execute();
                    $active = $stat->fetchColumn();
                    if ($active == false) {
                        sendmail($_POST['email']);
                        echo "we have sent you an email";
                    }
                    else
                        echo "user exists";
                }
                catch (PDOException $e)
                {
                    echo "Database not working";
                }
            }
            //else
                //echo $e->getMessage();
        }
    }
}

function sendmail($email)
{
    $mh = hash('whirlpool',"some random".$_POST['email']."text");
    mail($_POST['email'], "Confirm registration to camagru","http://localhost:8080/camagru/confirmation.php?mh=".$mh."&mp=".$_POST['email']);
}