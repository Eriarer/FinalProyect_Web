<?php
session_start();
if (isset($_SESSION['user'])) {
  header('Location: ../html_php/index.php');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario con CAPTCHA</title>
  <!-- Boostrap v4.6.% -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- swetalert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- css -->
  <link rel="stylesheet" href="../css/log_reg.css" />
  <link rel="stylesheet" href="../css/main.css" />
</head>

<body>
  <?php require_once 'navbar.php'; ?>
  <div class="container my-5">
    <div class="card-container">
      <!-- Tarjeta de Registro -->
      <div class="card" id="register">
        <div class="card-body show-card">
          <h5 class="card-title">Formulario de Registro</h5>
          <form id="registerForm">
            <!-- Email -->
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="emailReg">Email</label>
                <input type="email" class="form-control" id="emailReg" name="emailReg" required>
                <small id="regEmailText" class="form-text text-danger"></small>
              </div>
            </div>
            <!-- Nombre y Apodo -->
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="username">Nombre</label>
                <input type="text" class="form-control" id="username" name="username" required>
                <small id="regUsernameText" class="form-text text-danger"></small>
              </div>
              <div class="form-group col-md-6">
                <label for="accountName">Apodo</label>
                <input type="text" class="form-control" id="accountName" name="accountName" placeholder="Será el nombre visible" required>
                <small id="regAccountNameText" class="form-text text-danger"></small>
              </div>
            </div>
            <!-- Pregunta segurdidad -->
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="securityQuestion">Pregunta de Seguridad</label>
                <select class="form-control custom-select" id="securityQuestion" name="securityQuestion" required>
                  <option value="1" selected>¿Cuál es el nombre de tu primera mascota?</option>
                  <option value="2">¿En qué ciudad naciste?</option>
                  <option value="3">¿Cuál es tu película favorita?</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="securityAnswer"> </label>
                <input type="text" class="form-control" id="securityAnswer" name="securityAnswer" required placeholder="Pinky">
                <small id="regSecurityAnswerText" class="form-text text-danger"></small>
              </div>
            </div>
            <!-- Contraseñas -->
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="passwordReg">Contraseña</label>
                <div class="input-group">
                  <input type="password" class="form-control" id="passwordReg" name="passwordReg" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <input type="checkbox" id="showPassword" onclick="togglePassword('passwordReg')" hidden>
                      <label class="form-check-label" for="showPassword" id="passwordRegToggle"><i class=" nf nf-fa-eye_slash"></i></label>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Repetir contrasña -->
              <div class="form-group col-md-6">
                <label for="confirmPasswordReg">Repetir Contraseña</label>
                <div class="input-group">
                  <input type="password" class="form-control" id="confirmPasswordReg" name="confirmPasswordReg" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <input type="checkbox" id="showConfirmPassword" onclick="togglePassword('confirmPasswordReg')" hidden>
                      <label class="form-check-label" for="showConfirmPassword" id="confirmPasswordRegToggle"><i class="nf nf-fa-eye_slash"></i></label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group-col-md-12 mt-0 pt-0 mb-3">
              <small id="coinciden" class="text-danger text-right"></small>
            </div>
            <div class="form-group-col-md-12 mt-0 pt-0 mb-3">
              <button type="submit" id="btnReg" class="btn btn-primary ">Registrarse</button>
            </div>
          </form>
        </div>
        <p class="mt-3 mx-auto h6">¿Ya tienes una cuenta? <a href="#" onclick="toggleForm()">Iniciar Sesión</a></p>
      </div>

      <!-- Tarjeta de Inicio de Sesión -->
      <div class="card" id="logIn">
        <div class="card-body">
          <h5 class="card-title">Iniciar Sesión</h5>
          <form id="loginForm">
            <!-- Email -->
            <div class="form-group mt-3">
              <label for="emailLogin">Email</label>
              <input type="email" class="form-control" id="emailLogin" name="emailLogin" required>
              <small id="logEmailText" class="form-text text-danger"></small>
            </div>
            <!-- Contraseña -->
            <div class="form-group">
              <label for="passwordLogin">Contraseña</label>
              <small id="logPasswordText" class="form-text text-danger"></small>
              <div class="input-group">
                <input type="password" class="form-control" id="passwordLogin" name="passwordLogin" required>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <input type="checkbox" id="showLoginPassword" onclick="togglePassword('passwordLogin')" hidden>
                    <label class="form-check-label" for="showLoginPassword" id="passwordLoginToggle"><i class="nf nf-fa-eye_slash"></i></label>
                  </div>
                </div>
              </div>
            </div>
            <!-- Captcha -->
            <div class="form-row">
              <div class="form-group col-12 col-md-6">
                <label for="captchaInput">Captcha</label>
                <input type="text" class="form-control" id="captchaInput" name="captchaInput" required>
                <input type="text" id="captchaText" name="captchaText" hidden>
              </div>
              <div class="col-12 col-md-6 d-flex align-items-center">
                <button type="button" class="btn btn-outline-primary" id="changeCaptcha"><i class="nf nf-cod-debug_restart"></i></button>
                <img src="../../media/images/imgRelleno.png" alt="Captcha" id="captchaImage">
              </div>
            </div>
            <!-- Recordarme -->
            <div class="form-check ">
              <input type="checkbox" class="form-check-input" id="rememberMe">
              <label class="form-check-label" for="rememberMe">Recordarme</label>
            </div>
            <!-- Iniciar sesión -->
            <div class="form-group-col-md-12 ">
              <button type="submit" class="btn btn-primary mt-3 ml-auto mr-3" id="iniciarSesion">Iniciar Sesión</button>
            </div>
          </form>
        </div>
        <div class="mt-3 mx-auto h6 d-flex flex-column justify-content-center align-items-center">
          <p>¿No tienes una cuenta? <a href="#" onclick="toggleForm()">Registrarse</a></p>
          <p class="mt-2">¿Tu cuenta está bloqueada? <a href="#" data-target="#recuparCuenta" data-toggle="modal">Recuperar Cuenta</a></p>
        </div>
      </div>

      <div class=" modal fade" id="recuparCuenta" tabindex="-1" onfocusout="detectarPérdidaDeFoco()">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Recuperar Cuenta</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="emailRecuperar">Email</label>
                    <input type="email" class="form-control" id="emailRecuperar" name="emailRecuperar" required>
                    <small id="emailRecuperarText" class="form-text text-danger"></small>
                  </div>
                </div>
                <div class="form-row mt-1" id="cuestionarioRecuperar">
                  <!-- pregunta de Seguridad -->
                  <label for="preguntaSeguridad">Pregunta de seguridad</label>
                  <input type="text" class="form-control" id="preguntaSeguridad" name="preguntaSeguridad" readonly>
                  <small id="preguntaSeguridadText" class="form-text text-danger"></small>
                  <label for="respuestaSeguridad">Respuesta</label>
                  <input type="text" class="form-control" id="respuestaSeguridad" name="respuestaSeguridad" required>
                  <small id="respuestaSeguridadText" class="form-text text-danger"></small>
                </div>
              </form>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="btnRecuperar">Recuperar Cuenta</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require_once 'footer.php'; ?>
  <script src="../js/logIn.js">
  </script>
</body>

</html>