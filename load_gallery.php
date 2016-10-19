<?php
include_once('config/database.php');

try {
    $respons = array();
    $dpo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $dpo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = $dpo->query("SELECT * FROM `tb_images` ORDER BY `id` DESC;");
    if ($data) {
        foreach ($data as $row) {
            $respons [] = $row;
        }
        $respons = json_encode($respons);
        echo $respons;
    } else {
        echo "false";
    }

} catch (PDOException $e) {
    echo $e->errorInfo;
}
?>