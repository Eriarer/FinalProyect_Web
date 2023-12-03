var IMAGE;
var TEXT;
var PREGUNTA_SEGUIRDA = {
  "1": "¿Cuál es el nombre de tu primera mascota?",
  "2": "¿En qué ciudad naciste?",
  "3": "¿Cuál es tu película favorita?"
};



$(document).ready(function () {
  refreshCaptcha();
  initView();
  $("#cuestionarioRecuperar").hide();
});

function initView() {
  initCaptcha();

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

  recuperarCuenta();
}

// CAPTCHA
function initCaptcha() {

  $('#changeCaptcha').click(function () {
    $('#changeCaptcha').addClass('rotate-left');
    $('#changeCaptcha').prop('disabled', true);
    setTimeout(function () {
      $('#changeCaptcha').removeClass('rotate-left');
      $('#changeCaptcha').prop('disabled', false);
    }, 300);
    setTimeout(function () {
      refreshCaptcha();
    }, 150);
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
          lanzarSweetAlert('error', 'Oops...', 'Tu cuenta esta deshabilitada');
          break;
        case '2':
          lanzarSweetAlert('error', 'Oops...', 'Los datos ingresados son erroneos');
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
            'email': $('#emailReg').val(),
            'password': $('#passwordReg').val()
          },
          success: function (data) {
            // logear el usuario
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

// recuperar cuenta
function recuperarCuenta() {
  $('#btnRecuperar').click(function () {
    console.log($('#recuperarCuenta').attr('tabindex'));
    // imprimir todos los atributos del modal
    console.log('recuperarCuenta');
    var regex = /\S+@\S+\.\S+/;
    if (!$('#cuestionarioRecuperar').is(':visible') && $('#emailRecuperar').val() != '' && regex.test($('#emailRecuperar').val())) {
      verificarEmailRecuperacion();
    } else {
      obtenerPreguntaSeguridad();
    }
  });


  var modal = $('#recuperarCuenta');
  // si el modal se cierra, se limpian los campos, el tabindex vuelve a -1
  $('#recuparCuenta').on('hidden.bs.modal', function () {
    console.log('modal cerrado');
    limpiarRecuperar();
  });
}

function verificarEmailRecuperacion() {
  // verificar que el email exista en la base de datos
  $.ajax({
    url: '../../model/DB/manejoProductos.php',
    type: 'POST',
    data: {
      'method': 'emailExist',
      'email': $('#emailRecuperar').val()
    },
    success: function (data) {
      if (data == 'success') {
        //recuperar la pregunta de seguridad
        $.ajax({
          url: '../../model/DB/manejoProductos.php',
          type: 'POST',
          data: {
            'method': 'getSecurityQuestion',
            'email': $('#emailRecuperar').val()
          },
          success: function (data) {
            console.log(data);
            data = JSON.parse(data);
            console.log(data);
            console.log(PREGUNTA_SEGUIRDA[data['pregunta']]);
            if (data != 'error') {
              $('#emailRecuperar').attr('readonly', true);
              $('#preguntaSeguridad').val(PREGUNTA_SEGUIRDA[data['pregunta']]);
              $('#btnRecuperar').text('Enviar');
              $('#cuestionarioRecuperar').show('slow');
            }
          }
        });
      } else {
        lanzarSweetAlert('error', 'Oops...', 'El email ingresado no existe');
      }
    }
  });
}

function obtenerPreguntaSeguridad() {
  if ($('#respuestaSeguridad').val() != '') {
    $.ajax({
      url: '../../model/DB/manejoProductos.php',
      type: 'POST',
      data: {
        'method': 'verifySecurityAnswer',
        'email': $('#emailRecuperar').val(),
        'respuesta': $('#respuestaSeguridad').val()
      },
      success: function (data) {
        console.log(data);
        if (data == 'success') {
          $.ajax({
            url: '../../model/DB/manejoProductos.php',
            type: 'POST',
            data: {
              'method': 'unblock',
              'email': $('#emailRecuperar').val(),
            },
            success: function (data) {
              if (data == 'success') {
                limpiarRecuperar();
                lanzarSweetAlert('success', 'Éxito', 'Tu cuenta ha sido desbloqueada');
              } else {
                lanzarSweetAlert('error', 'Oops...', 'Ha ocurrido un error<br>Intentalo más tarde.');
              }
            }
          });
        } else {
          //limpiar el campo de respuesta pregunta y email de recuperacion
          limpiarRecuperar();
          lanzarSweetAlert('error', 'Oops...', 'La respuesta de seguridad es incorrecta');
        }
      }
    });
  }
}

function limpiarRecuperar() {
  $('#cuestionarioRecuperar').hide('slow');
  $('#emailRecuperar').attr('readonly', false);
  $('#emailRecuperar').val('');
  $('#respuestaSeguridad').val('');
  $('#preguntaSeguridad').val('');
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