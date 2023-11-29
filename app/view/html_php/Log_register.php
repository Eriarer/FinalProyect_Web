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
</head>

<body>
  <?php require_once 'navbar.php'; ?>
  <div class="container mt-5">
    <div class="card-container">
      <!-- Tarjeta de Registro -->
      <div class="card" id="register">
        <div class="card-body show-card">
          <h5 class="card-title">Formulario de Registro</h5>
          <form>
            <div class="form-group">
              <label for="emailReg">Email (único)</label>
              <input type="email" class="form-control" id="emailReg" name="emailReg" required>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="username">Nombre de Usuario</label>
                <input type="text" class="form-control" id="username" name="username" required>
              </div>
              <div class="form-group col-md-6">
                <label for="accountName">Nombre de Cuenta</label>
                <input type="text" class="form-control" id="accountName" name="accountName" required>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="securityQuestion">Pregunta de Seguridad</label>
                <select class="form-control" id="securityQuestion" name="securityQuestion" required>
                  <option value="1">¿Cuál es el nombre de tu primera mascota?</option>
                  <option value="2">¿En qué ciudad naciste?</option>
                  <option value="3">¿Cuál es tu película favorita?</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="securityAnswer">Respuesta de Seguridad</label>
                <input type="text" class="form-control" id="securityAnswer" name="securityAnswer" required>
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
            </div>
            <button type="submit" class="btn btn-primary">Registrarse</button>
          </form>
          <p class="mt-3">¿Ya tienes una cuenta? <a href="#" onclick="toggleForm()">Iniciar Sesión</a></p>
        </div>
      </div>

      <!-- Tarjeta de Inicio de Sesión -->
      <div class="card" id="logIn">
        <div class="card-body">
          <h5 class="card-title">Iniciar Sesión</h5>
          <form>
            <div class="form-group mt-3">
              <label for="emailLogin">Email</label>
              <input type="email" class="form-control" id="emailLogin" name="emailLogin" required>
            </div>
            <div class="form-group">
              <label for="passwordLogin">Contraseña</label>
              <div class="input-group">
                <input type="password" class="form-control" id="passwordLogin" name="passwordLogin" required>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <input type="checkbox" id="showLoginPassword" onclick="togglePassword('passwordLogin')">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-6">
                <label for="captchaInput">Captcha</label>
                <input type="text" class="form-control" id="captchaInput" name="captchaInput" required>
              </div>
              <div class="col-6">
                <img src="" alt="Captcha" id="captchaImage">
                <button type="button" class="btn btn-link" id="changeCaptcha">Cambiar Captcha</button>
              </div>
            </div>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="rememberMe">
              <label class="form-check-label" for="rememberMe">Recordarme</label>
            </div>
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
          var data = JSON.parse(data);
          image = data.image;
          text = data.text;
          $('#captchaImage').attr('src', '../../media/images/captcha/' + image);
        }
      });
    }

    function verifyCaptcha() {
      var captchaInput = $('#captchaInput').val();
      captchaInput = captchaInput.replace(/[^a-zA-Z0-9]/g, '');
      if (captchaInput === text) {
        alert('CAPTCHA correcto');
      } else {
        alert('CAPTCHA incorrecto');
        refreshCaptcha();
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

      $('#iniciarSesion').click(function(e) {
        e.preventDefault();
        verifyCaptcha();
      });
      $('#logIn').hide();
    });
  </script>

</body>

</html>