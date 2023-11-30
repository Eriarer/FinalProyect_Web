<?php
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
    echo "getProduct " . $_POST['id'];
  } else if ($method === "modifyProduct") {
    $id = $_POST['id'];
    $categoria = $_POST['categoria'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $stock = $_POST['stock'];
    $precio = $_POST['precio'];
    $descuento = $_POST['descuento'];
    $imagen = $_FILES["imagen"]["name"];
    //$id, $categoria, $prod_name, $prod_description, $prod_imgPath, $prod_stock, $prod_precio, $prod_descuento
    $response = $db->modifyProduct($id, $categoria, $nombre, $descripcion, $imagen, $stock, $precio, $descuento);
    echo $response ? "success" : "error";
    return $response ? "success" : "error";
  }
  echo "error";
  return "error";
}
