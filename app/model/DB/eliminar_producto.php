<?php
include_once __DIR__ . '/../../model/DB/dataBaseCredentials.php';
include_once __DIR__ . '/../../model/routes_files.php';
include_once __DIR__ . '/../../model/DB/controllDB.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $db = new dataBase($credentials, $CONFIG);
    $response = $db->bajaProducto($id);

    if ($response) {
        echo "success";
    } else {
        echo "error";
    }
}
