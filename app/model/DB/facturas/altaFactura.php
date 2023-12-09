<?php
require_once '../controllDB.php';
require_once '../dataBaseCredentials.php';
require_once '../../routes_files.php';

$db = new dataBase($credentials, $CONFIG);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
}
