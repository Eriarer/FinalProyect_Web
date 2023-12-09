<?php
require_once '../controllDB.php';
require_once '../dataBaseCredentials.php';
require_once '../../routes_files.php';

$db = new dataBase($credentials, $CONFIG);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //este metodo utiliza un periodo de tiempo para obtener las facturas
  $fechaInicio = date("Y-m-d", strtotime($_POST['fechaInicio']));
  $fechaFin = date("Y-m-d", strtotime($_POST['fechaFin']));

  if ($fechaInicio > $fechaFin) {
    throw new Exception("La fecha de inicio debe ser menor a la fecha de fin.");
  }

  $result = $db->getVentasPorSemana($fechaInicio, $fechaFin);
  echo $result;
  return;
}
