<?php
session_start();
include_once __DIR__ . '/../../model/DB/dataBaseCredentials.php';
include_once __DIR__ . '/../../model/routes_files.php';
include_once __DIR__ . '/../../model/DB/controllDB.php';

$db = new dataBase($credentials, $CONFIG);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $method = $_POST['method'];
  if ($method === "delete") {
    $id = $_POST['id'];
    $response = $db->bajaProducto($id);
    echo $response ? "success" : "error";
    return $response ? "success" : "error";
  } else if ($method === "getAllProducts") {
    $json =  $db->getAllProducts();
    echo $json;
    return $json;
  } else if ($method === "getProduct") {
    $json =  $db->getProduct($_POST['id']);
    echo $json;
    return $json;
  } else if ($method === "disminuirStock") {
    $id = $_POST['id'];
    $cantidad = $_POST['cantidad'];
    $response = $db->disminuirStock($id, $cantidad);
    echo $response ? "success" : "error";
    return $response ? "success" : "error";
  }
  echo "error";
  return "error";
}
