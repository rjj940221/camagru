<?php

session_start();
unset($_SESSION['logged_on_user']);
header("location: /camagru/pages/index.php");