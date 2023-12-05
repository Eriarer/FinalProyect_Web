<?php
session_start();
include_once __DIR__ . '/../../model/DB/dataBaseCredentials.php';
include_once __DIR__ . '/../../model/routes_files.php';
include_once __DIR__ . '/../../model/DB/controllDB.php';

$db = new dataBase($credentials, $CONFIG);
$TIME = time() + (86400 * 2); // 2 dias

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST['email']) || empty($_POST['password'])) {
    echo "error";
    return;
  }
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
    if ($_POST['coockie'] == true) {
      $email = $user['usr_email'];
      $password = $user['usr_pwd'];
      $user = $user['usr_account'];
      setcookie("email", $email, $TIME, "/");
      setcookie("name", $user, $TIME, "/");
      setcookie("password", $password, $TIME, "/");
    }
    session_write_close();
  }
  echo $response;
  return $response;
}
echo "9";
return;
