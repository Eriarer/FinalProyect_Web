<?php
session_start();
include_once __DIR__ . '/../../model/DB/dataBaseCredentials.php';
include_once __DIR__ . '/../../model/routes_files.php';
include_once __DIR__ . '/../../model/DB/controllDB.php';

$db = new dataBase($credentials, $CONFIG);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $method = $_POST['method'];
  if ($method == "altaFactura") {
    $email = $_POST['email'];
    $productosFactura = $_POST['productosFactura'];
    $fecha = date("Y-m-d", strtotime($_POST['fecha']));
    $iva = $_POST['iva'];
    $gastosEnvio = $_POST['gastosEnvio'];
    $pais = $_POST['pais'];
    $direccion = $_POST['direccion'];
    $metodo_pago = $_POST['metodo_pago'];

    $result = $db->altaFactura($email, $productosFactura, $fecha, $iva, $gastosEnvio, $pais, $direccion, $metodo_pago);
    echo $result;
    return;
  } else if ($method == "getFactura") {
    $folio = $_POST['folio'];
    $result = $db->getFactura($folio);
    echo $result;
    return;
  } else if ($method == "getFacturas") {
    //este metodo utiliza un periodo de tiempo para obtener las facturas
    $fechaInicio = date("Y-m-d", strtotime($_POST['fechaInicio']));
    $fechaFin = date("Y-m-d", strtotime($_POST['fechaFin']));
    $result = $db->getFacturas($fechaInicio, $fechaFin);
    echo $result;
    return;
  }
}
