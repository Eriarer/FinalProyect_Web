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
    $json =  $db->getProduct($_POST['id']);
    echo $json;
    return $json;
  } else if ($method === "emailExist") {
    $email = $_POST['email'];
    $response = $db->emailExist($email);
    echo $response ? "success" : "error";
    return $response ? "success" : "error";
  } else if ($method === "altaUsuario") {
    $email = $_POST['usr_email'];
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
  } else if ($method === "login") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $response = $db->login($email, $password);
    //resetear los intentos fallidos
    if ($response == 0) {
      $user = $db->getUserByEmail($email);
      $db->unblock($email);
      //escribir la variable de sesion
      $_SESSION['email'] = $email;
      $_SESSION['name'] = $user['usr_account'];
      session_write_close();
    }
    echo $response;
    return $response;
  } else if ($method === "logout") {
    session_unset();
    session_destroy();
    //borrar las cookies
    setcookie("name", '', time() - 3600, "/");
    setcookie('email', '', time() - 3600, '/');
    setcookie('password', '', time() - 3600, '/');
    return "success";
  } else if ($method === "setCoockie") {
    $email = $_POST['email'];
    $user = $db->getUserByEmail($email);
    $passwordCrypt = $user['usr_pwd'];
    //escribir las cookies
    $name = $user['usr_account'];
    $time = time() + (86400 * 2); // 2 dias
    setcookie("email", $email, $time, "/");
    setcookie("name", $name, $time, "/");
    setcookie("password", $passwordCrypt, $time, "/");
    echo "success";
    return "success";
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
  }
  echo "error";
  return "error";
}
