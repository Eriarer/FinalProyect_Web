<?php
include_once __DIR__ . '/../app/model/controllDB.php';
include_once __DIR__ . '/../app/model/dataBaseCredentials.php';
include_once __DIR__ . '/../app/model/routes_files.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $conexion = mysqli_connect($credntials['host'], $credntials['user'], $credntials['pass'], $credntials['db']);
  if (!$conexion) {
      die('Error de Conexión (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
  }
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $password2 = $_POST['password2'];
  $recovery_question = $_POST['recovery_question'];
  $recovery_answer = $_POST['recovery_answer'];

  // Validar que las contraseñas coincidan
  if($password != $password2){
    echo "<script>alert('Las contraseñas no coinciden');</script>";
    // eliminar la peticion POST
    $_SERVER["REQUEST_METHOD"] = "";
  }else{
    // Validar que el usuario no exista
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    //crear objeto DB
    $db = new dataBase($credntials, $CONFIG);
    $result = $db->emailExist($email);
    if($result){
      echo "<script>alert('El correo ya existe');</script>";
      // eliminar la peticion POST
      $_SERVER["REQUEST_METHOD"] = "";
    }else{
      $result = $db->altaUsuarios($email, $username, $hashedPassword, 0, $recovery_question, $recovery_answer);
      if($result){
        echo "<script>alert('Usuario registrado');</script>";
        // eliminar la peticion POST
        $_SERVER["REQUEST_METHOD"] = "";
      }else{
        echo "<script>alert('Error al registrar usuario');</script>";
        // eliminar la peticion POST
        $_SERVER["REQUEST_METHOD"] = "";
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Registro e Inicio de Sesión</title>
      <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h2>Registro de Usuario</h2>
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <div class="form-group">
                        <label for="username">Nombre de usuario:</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Correo electrónico:</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="password2">Repetir contraseñá:</label>
                        <input type="password" class="form-control" name="password2" required>
                    </div>

                    <div class="form-group">
                        <label for="recovery_question">Pregunta de recuperación:</label>
                        <input type="text" class="form-control" name="recovery_question" required>
                    </div>
                
                    <div class="form-group">
                        <label for="recovery_answer">Respuesta de recuperación:</label>
                        <input type="text" class="form-control" name="recovery_answer" required>
                    </div>
                
                    <button type="submit" class="btn btn-primary" name="register">Registrar</button>
                </form>
            </div>
            <div class="col-md-6">
                <h2>Iniciar Sesión</h2>
                <form action="encriptacion.php" method="post">
                    <div class="form-group">
                        <label for="loginUsername">Nombre de usuario:</label>
                        <input type="text" class="form-control" id="loginUsername" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="loginPassword">Contraseña:</label>
                        <input type="password" class="form-control" id="loginPassword" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-success" name="login">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  </body>
</html>
