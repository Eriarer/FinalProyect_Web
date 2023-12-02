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
            <div class="form-group">
              <label for="emailReg">Email (único)</label>
              <input type="email" class="form-control" id="emailReg" name="emailReg" required>
              <small id="regEmailText" class="form-text text-danger"></small>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="username">Nombre de Usuario</label>
                <input type="text" class="form-control" id="username" name="username" required>
                <small id="regUsernameText" class="form-text text-danger"></small>
              </div>
              <div class="form-group col-md-6">
                <label for="accountName">Nombre de Cuenta</label>
                <input type="text" class="form-control" id="accountName" name="accountName" required>
                <small id="regAccountNameText" class="form-text text-danger"></small>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="securityQuestion">Pregunta de Seguridad</label>
                <select class="form-control" id="securityQuestion" name="securityQuestion" required>
                  <option value="1" selected>¿Cuál es el nombre de tu primera mascota?</option>
                  <option value="2">¿En qué ciudad naciste?</option>
                  <option value="3">¿Cuál es tu película favorita?</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="securityAnswer">Respuesta de Seguridad</label>
                <input type="text" class="form-control" id="securityAnswer" name="securityAnswer" required>
                <small id="regSecurityAnswerText" class="form-text text-danger"></small>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="passwordReg">Contraseña</label>
                <div class="input-group">
                  <input type="password" class="form-control" id="passwordReg" name="passwordReg" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <input type="checkbox" id="showPassword" onclick="togglePassword('passwordReg')">
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="confirmPasswordReg">Repetir Contraseña</label>
                <div class="input-group">
                  <input type="password" class="form-control" id="confirmPasswordReg" name="confirmPasswordReg" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <input type="checkbox" id="showConfirmPassword" onclick="togglePassword('confirmPasswordReg')">
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group-col-md-12 mt-0 pt-0 mb-3">
                  <small id="coinciden" class="text-danger text-right"></small> 
              </div>
            </div>
            <button type="submit" id="btnReg" class="btn btn-primary">Registrarse</button>
          </form>
          <p class="mt-3">¿Ya tienes una cuenta? <a href="#" onclick="toggleForm()">Iniciar Sesión</a></p>
        </div>
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
                    <input type="checkbox" id="showLoginPassword" onclick="togglePassword('passwordLogin')">
                  </div>
                </div>
              </div>
            </div>
            <!-- Captcha -->
            <div class="form-row">
              <div class="form-group col-6">
                <label for="captchaInput">Captcha</label>
                <input type="text" class="form-control" id="captchaInput" name="captchaInput" required>
                <input type="text" id="captchaText" name="captchaText" hidden>
              </div>
              <div class="col-6">
                <img src="" alt="Captcha" id="captchaImage">
                <button type="button" class="btn btn-link" id="changeCaptcha">Cambiar Captcha</button>
              </div>
            </div>
            <!-- Recordarme -->
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="rememberMe">
              <label class="form-check-label" for="rememberMe">Recordarme</label>
            </div>
            <!-- Iniciar sesión -->
            <button type="submit" class="btn btn-primary mt-3" id="iniciarSesion">Iniciar Sesión</button>
          </form>
          <p class="mt-3">¿No tienes una cuenta? <a href="#" onclick="toggleForm()">Registrarse</a></p>
        </div>
      </div>
    </div>
  </div>
  <?php require_once 'footer.php'; ?>
  <script>
    function toggleForm() {
      $('#logIn').toggle();
      $('#register').toggle();
    }

    var image;
    var text;

    function refreshCaptcha() {
      $.ajax({
        url: '../../model/captcha/captcha_generator.php',
        type: 'GET',
        success: function(data) {
          console.log(data);
          var data = JSON.parse(data);
          image = data.image;
          text = data.text;
          $('#captchaImage').attr('src', '../../media/images/captcha/' + image);
          $('#captchaText').val(text);
        }
      });
    }

    function verifyCaptcha() {
      var captchaInput = $('#captchaInput').val();
      captchaInput = captchaInput.replace(/[^a-zA-Z0-9]/g, '');
      if (captchaInput === text) {
        return true;        
      } else {
        refreshCaptcha();
        return false;
      }
    }

    function togglePassword(inputId) {
      var x = document.getElementById(inputId);
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }

    $(document).ready(function() {
      refreshCaptcha();
      $('#changeCaptcha').click(function(e) {
        e.preventDefault();
        refreshCaptcha();
      });

      // al momento que se envia el formulario, se verifica que los campos no esten vacios
      $('#loginForm').submit(function(e) {
        verifyLoginForm(e);
      });
      $('#loginForm').on('change', function() {
        $('#logEmailText').text('');
        $('#logPasswordText').text('');
        $('#captchaInput').text('');
      });

      $('#registerForm').submit(function(e) {
        verifyRegisterForm(e);
      });
      $('#registerForm').on('change', function() {
        $('#regEmailText').text('');
        $('#regUsernameText').text('');
        $('#regAccountNameText').text('');
        $('#regSecurityAnswerText').text('');
        $('#coinciden').text('');
      });
      $('#logIn').hide();

      // al teclear en los campos passwordReg y confirmPasswordReg
      $('#passwordReg, #confirmPasswordReg').on('input', function() {
        if ($('#passwordReg').val() === $('#confirmPasswordReg').val()) {
          $('#coinciden').text('');
          $('#btnReg').prop('disabled', false);
        } else {
          $('#coinciden').text('Las contraseñas no coinciden');
          $('#btnReg').prop('disabled', true);
        }
      });
    });

    function verifyLoginForm(e){
      console.log('verifyLoginForm');
      //verificar que los campos no esten vacios
      if($('#emailLogin').val() == ""){
        e.preventDefault();
        $('#logEmailText').text('El campo no puede estar vacío');
      }
      if($('#passwordLogin').val() == ""){
        e.preventDefault();
        $('#logPasswordText').text('El campo no puede estar vacío');
      }
      if($('#captchaInput').val() == ""){
        e.preventDefault();
        $('#captchaInput').text('El campo no puede estar vacío');
      }
      //verificar captcha
      if(!verifyCaptcha()){
        e.preventDefault();
      }
      
      $.ajax({
        url: '../../model/DB/manejoProductos.php',
        type: 'POST',
        data: {
          'method': 'login',
          'email': $('#emailLogin').val(),
          'password': $('#passwordLogin').val()
        },
        success: function(data) {
          console.log(data);
          // 0 = login correcto | 1 = cuenta deshabilitada | 2 = datos incorrectos
          switch(data){
            case '0':
              // si el boton de recordarme esta activado, se crea una cookie
              if($('#rememberMe').is(':checked')){
                $.ajax({
                  url: '../../model/DB/manejoProductos.php',
                  type: 'POST',
                  data: {
                    'method': 'setCoockie',
                    'email': $('#emailLogin').val(),
                  },
                  success: function() {
                    console.log('redireccionando');
                    window.location.href  = baserUrl + 'index.php';
                  }
                });
              }else{
                window.location.href  = '../../../index.php';
              }
              break;
            case '1':
              //crear un boton para reactivar la cuenta
              var html = '<button type="button" class="btn btn-primary" id="reactivarCuenta">Reactivar Cuenta</button>';
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Tu cuenta ha sido deshabilitada',
                footer: html
              });
              break;
            case '2':
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Los datos ingresados son erroneos',
              });
              break;
          }
        }
      });
      e.preventDefault();
    }

    function verifyRegisterForm(e){
      console.log('verifyRegisterForm');
      //verificar que los campos no esten vacios
      if($('#emailReg').val() == ""){
        e.preventDefault();
        $('#regEmailText').text('El campo no puede estar vacío');
        $('#emailReg').focus();
      }
      if($('#username').val() == ""){
        e.preventDefault();
        $('#regUsernameText').text('El campo no puede estar vacío');
        $('#username').focus();
      }
      if($('#accountName').val() == ""){
        e.preventDefault();
        $('#regAccountNameText').text('El campo no puede estar vacío');
        $('#accountName').focus();
      }
      if($('#securityAnswer').val() == ""){
        e.preventDefault();
        $('#regSecurityAnswerText').text('El campo no puede estar vacío');
        $('#securityAnswer').focus();
      }
      if($('#passwordReg').val() == ""){
        e.preventDefault();
        $('#regPasswordText').text('El campo no puede estar vacío');
      }
      if($('#confirmPasswordReg').val() == ""){
        e.preventDefault();
        $('#regConfirmPasswordText').text('El campo no puede estar vacío');
        $('#confirmPasswordReg').focus();
      }
      
      $.ajax({
        url: '../../model/DB/manejoProductos.php',
        type: 'POST',
        data: {
          'method': 'altaUsuario',
          'usr_email': $('#emailReg').val(),
          'usr_name': $('#username').val(),
          'usr_account': $('#accountName').val(),
          'pregunta': $('#securityQuestion').val(),
          'respuesta': $('#securityAnswer').val(),
          'usr_pwd': $('#passwordReg').val()
        },
        success: function(data) {
          if(data == 'success'){
            //lanzar un sweet alert
            Swal.fire({
              icon: 'success',
              title: '¡Registro exitoso!',
              text: 'Ya puedes iniciar sesión',
            });
            toggleForm();
          }else{
            //lanzar un sweet alert
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'El email ingresado ya existe',
            });
          }
        }
      });
      e.preventDefault();
    }
  </script>

</body>

</html>