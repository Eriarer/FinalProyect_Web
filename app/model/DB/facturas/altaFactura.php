<?php
require_once '../controllDB.php';
require_once '../dataBaseCredentials.php';
require_once '../../routes_files.php';

$db = new dataBase($credentials, $CONFIG);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // datos a recibir del POST
  //$email, $productos, $fecha, $iva, $gastos_envio, 
  //$pais, $direccion, $metodo_pago, $nombre, $correo, 
  //$telefono, $subtotal, $total, $cupon, $costo_iva
  $email = $_POST['email'];
  $productosFactura = $_POST['productosFactura'];
  $fecha = date("Y-m-d", strtotime($_POST['fecha']));
  $iva = $_POST['iva'];
  $gastosEnvio = $_POST['gastosEnvio'];
  $pais = $_POST['pais'];
  $direccion = $_POST['direccion'];
  $metodo_pago = $_POST['metodo_pago'];
  $nombre = $_POST['nombre'];
  $correo = $_POST['correo'];
  $telefono = $_POST['telefono'];
  $subtotal = $_POST['subtotal'];
  $total = $_POST['total'];
  $cupon = $_POST['cupon'];
  $costo_iva = $_POST['costo_iva'];

  $result = $db->altaFactura($email, $productosFactura, $fecha, $iva, $gastosEnvio, $pais, $direccion, $metodo_pago, $nombre, $telefono, $subtotal, $total, $cupon, $costo_iva);
  echo $result;
  return;
}
