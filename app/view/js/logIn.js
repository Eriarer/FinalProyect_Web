var IMAGE;
var TEXT;

$(document).ready(function () {
  refreshCaptcha();
  initView();
});

function initView() {
  $('#register').hide();
  $('#recuperar').hide();

  // al momento que se envia el formulario, se verifica que los campos no esten vacios
  $('#loginForm').submit(function (e) {
    verifyLoginForm(e);
  });
  $('#loginForm').on('change', function () {
    $('#logEmailText').text('');
    $('#logPasswordText').text('');
    $('#captchaInput').text('');
  });

  $('#registerForm').submit(function (e) {
    verifyRegisterForm(e);
  });
  $('#registerForm').on('change', function () {
    $('#regEmailText').text('');
    $('#regUsernameText').text('');
    $('#regAccountNameText').text('');
    $('#regSecurityAnswerText').text('');
  });

  // al teclear en los campos passwordReg y confirmPasswordReg
  $('#passwordReg, #confirmPasswordReg').on('input', function () {
    if ($('#passwordReg').val() === $('#confirmPasswordReg').val()) {
      $('#coinciden').text('');
      $('#btnReg').prop('disabled', false);
    } else {
      $('#coinciden').text('Las contraseñas no coinciden');
      $('#btnReg').prop('disabled', true);
    }
  });


}

// CAPTCHA
function initCaptcha() {
  $('#changeCaptcha').click(function (e) {
    e.preventDefault();
    refreshCaptcha();
  });

  // agregarle la animacion rotate-left al boton de refrescar captcha al hacer click
  $('#changeCaptcha').click(function () {
    $('#changeCaptcha').addClass('rotate-left');
    $('#changeCaptcha').prop('disabled', true);
    setTimeout(function () {
      $('#changeCaptcha').removeClass('rotate-left');
      $('#changeCaptcha').prop('disabled', false);
    }, 300);
  });
}

function refreshCaptcha() {
  $.ajax({
    url: '../../model/captcha/captcha_generator.php',
    type: 'GET',
    success: function (data) {
      console.log(data);
      var data = JSON.parse(data);
      IMAGE = data.image;
      TEXT = data.text;
      $('#captchaImage').attr('src', '../../media/images/captcha/' + IMAGE);
      $('#captchaText').val(TEXT);
    }
  });
}

function verifyCaptcha() {
  var captchaInput = $('#captchaInput').val();
  captchaInput = captchaInput.replace(/[^a-zA-Z0-9]/g, '');
  if (captchaInput === TEXT) {
    return true;
  } else {
    refreshCaptcha();
    return false;
  }
}

// VISTAS
function toggleForm() {
  // vaciar los campos
  $('#emailLogin').val('');
  $('#passwordLogin').val('');
  $('#captchaInput').val('');
  $('#emailReg').val('');
  $('#username').val('');
  $('#accountName').val('');
  $('#securityAnswer').val('');
  $('#passwordReg').val('');
  $('#confirmPasswordReg').val('');
  $('#coinciden').text('');
  $('#logIn').toggle('slow');
  $('#register').toggle('slow');
}

function togglePassword(inputId) {
  var input = document.getElementById(inputId);
  var inputToggle = document.getElementById(inputId + 'Toggle');
  if (input.type === "password") {
    input.type = "text";
    inputToggle.innerHTML = '<i class="nf nf-fa-eye"></i>';
  } else {
    input.type = "password";
    inputToggle.innerHTML = '<i class="nf nf-fa-eye_slash"></i>';
  }
}

// FUNCIONES
function verifyLoginForm(e) {
  //verificar captcha
  if (!verifyCaptcha()) {
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
    success: function (data) {
      // 0 = login correcto | 1 = cuenta deshabilitada | 2 = datos incorrectos
      switch (data) {
        case '0':
          // si el boton de recordarme esta activado, se crea una cookie
          if ($('#rememberMe').is(':checked')) {
            $.ajax({
              url: '../../model/DB/manejoProductos.php',
              type: 'POST',
              data: {
                'method': 'setCoockie',
                'email': $('#emailLogin').val(),
              },
              success: function () {
                console.log('redireccionando');
                window.location.href = '../../../index.php';
              }
            });
          } else {
            window.location.href = '../../../index.php';
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

function verifyRegisterForm(e) {
  console.log('verifyRegisterForm');

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
    success: function (data) {
      if (data == 'success') {
        // loggear al usuario inmediatamente
        $.ajax({
          url: '../../model/DB/manejoProductos.php',
          type: 'POST',
          data: {
            'method': 'login',
            'email': $('#emailLogin').val(),
            'password': $('#passwordLogin').val()
          },
          success: function (data) {
            window.location.href = '../../../index.php';
          }
        });
      } else {
        //lanzar un sweet alert
        lanzarSweetAlert('error', 'Oops...', 'El email ingresado ya existe');
      }
    }
  });
  e.preventDefault();
}

//Lanzar SweetAlert
function lanzarSweetAlert(icon = '', title = '', text = '', footer = '') {
  Swal.fire({
    icon: icon,
    title: title,
    text: text,
    footer: footer
  });
}