<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario con CAPTCHA</title>
  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>

  <form id="captchaForm">
    <label for="captchaInput">Ingrese el CAPTCHA:</label>
    <input type="text" id="captchaInput" name="captcha">
    <img id="captchaImage" src="#" alt="CAPTCHA">
    <button id="actualizar">Actualizar CAPTCHA</button>
    <button id="verificar">Verificar CAPTCHA</button>
  </form>

  <script>
    var image;
    var text;
    // Función para actualizar la imagen CAPTCHA
    function refreshCaptcha() {
      $.ajax({
        url: '../../model/captcha/captcha_generator.php',
        type: 'GET',
        success: function(data) {
          // decodficar el JSON
          var data = JSON.parse(data);
          // obtener la ruta de la imagen
          image = data.image;
          // obtener el texto
          text = data.text;
          $('#captchaImage').attr('src', '../../media/images/captcha/' + image);
        }
      });
    }

    // Función para verificar el CAPTCHA
    function verifyCaptcha() {
      var captchaInput = $('#captchaInput').val();
      if (captchaInput === text) {
        alert('CAPTCHA correcto');
      } else {
        alert('CAPTCHA incorrecto');
        // actualizar la imagen CAPTCHA
        refreshCaptcha();
      }
    }

    // Cargar la imagen CAPTCHA al cargar la página
    $(document).ready(function() {
      refreshCaptcha();
      $('#actualizar').click(function(e) {
        e.preventDefault();
        refreshCaptcha();
      });
      $('#verificar').click(function(e) {
        e.preventDefault();
        verifyCaptcha();
      });
    });
  </script>

</body>

</html>