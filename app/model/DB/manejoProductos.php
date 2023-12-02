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
  } else if ($method === "emailExist"){
    $email = $_POST[' '];
    $response = $db->emailExist($email);
    echo $response ? "success" : "error";
    return $response ? "success" : "error";
  }else if ($method === "altaUsuario"){
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
  }else if($method === "login"){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $response = $db->login($email, $password);
    if($response == 0){
      $user = $db->getUserByEmail($email);
      //escribir la variable de sesion
      $_SESSION['email'] = $email;
      $_SESSION['name'] = $user['usr_account'];
      $_SESSION['admin'] = $user['usr_admin'];
      session_write_close();
    }
    echo $response;
    return $response;
  }else if($method === "logout"){
    session_unset();
    session_destroy();
    return "success";
  }else if($method === "setCoockie"){
    $email = $_POST['email'];
    $user = $db->getUserByEmail($email);
    //escribir las cookies
    $name = $user['usr_account'];
    $admin = $user['usr_admin'];
    $time = time() + (86400 * 2); // 2 dias
    setcookie("email", $email, $time, "/");
    setcookie("name", $name, $time, "/");
    setcookie("admin", $admin, $time, "/");
    echo "success";
    return "success";
  }
    echo $response;
    return $response;
  echo "error";
  return "error";
}
