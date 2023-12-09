<?php
session_start();
include_once __DIR__ . '/../../model/DB/dataBaseCredentials.php';
include_once __DIR__ . '/../../model/routes_files.php';
include_once __DIR__ . '/../../model/DB/controllDB.php';

$db = new dataBase($credentials, $CONFIG);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $method = $_POST['method'];
    $usr_id = $db->getID($_SESSION['email']);

    if ($method === "delete") {
        $prod_id = $_POST['prod_id'];
        $response = $db->eliminarCarrito($usr_id, $prod_id);
        $_SESSION['productos'] = $response;
        echo json_encode($response);
        return;
    } else if ($method === "add") {
        $prod_id = $_POST['prod_id'];
        $cantidad = $_POST['cantidad'];
        $response = $db->insertarCarrito($usr_id, $prod_id, $cantidad);
        $_SESSION['productos'] = $response;
        echo json_encode($response);
        return;
    } else if ($method === "addOne") {
        $prod_id = $_POST['prod_id'];
        $response = $db->aumentarCantidad($usr_id, $prod_id);
        $_SESSION['productos'] = $response;
        echo json_encode($response);
        return;
    } else if ($method === "subOne") {
        $prod_id = $_POST['prod_id'];
        $response = $db->disminuirCantidad($usr_id, $prod_id);
        $_SESSION['productos'] = $response;
        echo json_encode($response);
        return;
    } else if ($method === "getCarrito") {
        $response = $db->obtenerCarrito($usr_id);
        echo json_encode($response);
        return;
    }
}
