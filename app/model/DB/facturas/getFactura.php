<?php
require_once '../controllDB.php';
require_once '../dataBaseCredentials.php';
require_once '../../routes_files.php';

$db = new dataBase($credentials, $CONFIG);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $result = $db->getFactura($_POST['folio']);
  echo $result;
  return;
}
