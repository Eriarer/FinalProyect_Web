<?php
session_start();
include_once __DIR__ . '/../../model/DB/dataBaseCredentials.php';
include_once __DIR__ . '/../../model/routes_files.php';
include_once __DIR__ . '/../../model/DB/controllDB.php';

$db = new dataBase($credentials, $CONFIG);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $method = $_POST['method'];
    $prod_id = $_POST['prod_id'];
    $cantidad = $_POST['cantidad'];
    $usr_id = $db->getID($_SESSION['email']);
    if ($method === "delete") {
        $response = $db->eliminarCarrito($usr_id, $prod_id);
        echo json_encode($response);
    } else if ($method === "add") {
        $response = $db->insertarCarrito($usr_id, $prod_id, $cantidad);
        if($response == 0){
            $response = $db->aumentarCantidad($usr_id, $prod_id);
        }
        echo json_encode($response);
    } else if ($method === "addOne") {
        $response = $db->aumentarCantidad($usr_id, $prod_id);
        echo json_encode($response);
    } else if ($method === "subOne") {
        $response = $db->disminuirCantidad($usr_id, $prod_id);
        echo json_encode($response);
    } else if ($method === "getCarrito") {
        $response = $db->obtenerCarrito($usr_id);
        echo json_encode($response);
    }
}
