<?php
session_start();
include_once __DIR__ . '/../../model/DB/dataBaseCredentials.php';
include_once __DIR__ . '/../../model/routes_files.php';
include_once __DIR__ . '/../../model/DB/controllDB.php';

$db = new dataBase($credentials, $CONFIG);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $method = $_POST['method'];
  if ($method === "emailExist") {
    $email = $_POST['email'];
    $response = $db->emailExist($email);
    echo $response ? "success" : "error";
    return $response ? "success" : "error";
  } else if ($method === "altaUsuario") {
    $email = $_POST['usr_email'];
    // verificar que el email no exista
    $response = $db->emailExist($email);
    if ($response) {
      echo "error";
      return "error";
    }
    $name = $_POST['usr_name'];
    $account = $_POST['usr_account'];
    $password = $_POST['usr_pwd'];
    $admin = 0;
    $pregunta = $_POST['pregunta'];
    $respuesta = $_POST['respuesta'];
    // encriptar contraseña con BCRYPT y agregarle salt
    $password = password_hash($password, PASSWORD_BCRYPT);
    $response = $db->altaUsuario($email, $name, $account, $password, $admin, $pregunta, $respuesta);
    echo $response ? "success" : "error";
    return $response ? "success" : "error";
  } else if ($method === "getSecurityQuestion") {
    $email = $_POST['email'];
    $response = $db->getSecurityQuestion($email);
    echo $response;
    return $response;
  } else if ($method === "verifySecurityAnswer") {
    $email = $_POST['email'];
    $respuesta = $_POST['respuesta'];
    $response = $db->verifySecurityAnswer($email, $respuesta);
    echo $response ? "success" : "error";
    return $response ? "success" : "error";
  } else if ($method === "unblock") {
    $email = $_POST['email'];
    $response = $db->unblock($email);
    if (!$response) {
      echo "error";
      return "error";
    }
    $password = $_POST['password'];
    $password = password_hash($password, PASSWORD_BCRYPT);
    $response = $db->updatePassword($email, $password);
    echo $response ? "success" : "error";
    return $response ? "success" : "error";
  } else if ($method === "cuponExist") {
    $cupon = $_POST['cupon'];
    if ($cupon === "NEWFLUFFY15" || $cupon === "FLUFFY10" || $cupon === "FLUFFY5") {
      echo true;
      return "true";
    } else {
      echo false;
      return "false";
    }
  } else if ($method === "usarCupon") {
    $cupon = $_POST['cupon'];
    $email = $_POST['email'];
    $id = $db->getId($email);
    $response = $db->usarCupon($id, $cupon);
    echo $response ? "success" : "error";
    return $response ? "success" : "error";
  }
}
