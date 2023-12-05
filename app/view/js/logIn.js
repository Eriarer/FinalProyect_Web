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
  $('#cambiarPassword').hide();

  // al momento que se envia el formulario, se verifica que los campos no esten vacios
  $('#loginForm').submit(function (e) {
    verifyLoginForm(e);
  });
  $('#loginForm').on('change', function () {
    $('#logEmailText').text('');
    $('#logPasswordText').text('');
    $('#captchaInput').text('');
    $('#captchaInput').removeClass('is-invalid');
  });

  $('#registerForm').submit(function (e) {
    verifyRegisterForm(e);
  });
  $('#registerForm').on('change', function () {
    $('#regEmailText').text('');
    $('#regUsernameText').text('');
    $('#regAccountNameText').text('');
    $('#regSecurityAnswerText').text('');
    $('#captchaInput').removeClass('is-invalid');
  });
  $('#captchaInput').on('change', function () {
    $('#captchaInput').removeClass('is-invalid');
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
    refreshCaptcha();
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
    $('#captchaInput').val('');
    $('#captchaInput').focus();
    $('#captchaInput').addClass('is-invalid');
    $('#captchaInput').removeClass('is-valid');
    $('#captchaInputText').text('El captcha es incorrecto');
    e.preventDefault();
    refreshCaptcha();
    return;
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
      // quedarse con el ultimo caracter
      data = data.slice(-1);
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
                window.location.href = '../../../index.php';
              }
            });
          } else {
            window.location.href = '../../../index.php';
          }
          break;
        case '1':
          lanzarSweetAlert('error', ':C', 'Tu cuenta esta deshabilitada');
          refreshCaptcha();
          break;
        case '2':
          lanzarSweetAlert('error', 'Oops...', 'Los datos ingresados son erroneos');
          refreshCaptcha();
          break;
      }
    }
  });
  e.preventDefault();
}

function verifyRegisterForm(e) {
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
  limpiarRecuperar();
  console.log('recuperarCuenta');
  $('#btnRecuperar').click(function () {
    // imprimir todos los atributos del modal
    var regex = /\S+@\S+\.\S+/;
    // verificamos
    // el cuestionario no este visible, el email sea valido y el campo no sea readonly
    console.log('VerificandoEmail');
    if (!$('#cuestionarioRecuperar').is(':visible') && $('#emailRecuperar').val() != '' && regex.test($('#emailRecuperar').val()) && !$('#emailRecuperar').is('[readonly]')) {
      verificarEmailRecuperacion();
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
            data = JSON.parse(data);
            if (data != 'error') {
              $('#emailRecuperar').attr('readonly', true);
              $('#preguntaSeguridad').val(PREGUNTA_SEGUIRDA[data['pregunta']]);
              $('#btnRecuperar').text('Enviar');
              $('#cuestionarioRecuperar').show('slow');
            }
          }
        });
        // mostrar el campo de respuesta
        console.log('mostrar el campo de respuesta');
        $('#btnRecuperar').text('Enviar');
        //elimimar el listener del boton
        $('#btnRecuperar').off('click');
        $('#btnRecuperar').click(function () {
          obtenerPreguntaSeguridad();
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
        if (data == 'success') {
          // ocultar el cuestionario
          $('#cuestionarioRecuperar').hide('slow');
          // mostrar el campo de contraseña
          $('#cambiarPassword').show('slow');

          console.log('mostrar el campo de contraseña');
          //elimimar el listener del boton
          $('#btnRecuperar').prop('disabled', true);
          $('#btnRecuperar').text('Cambiar contraseña');
          $('#btnRecuperar').off('click');
          $('#btnRecuperar').click(function () {
            cambiarContrasena();
          });
          $('#passwordRecuperar').on('input', function () {
            newPaswordVerify();
          });
          $('#confirmPasswordRecuperar').on('input', function () {
            newPaswordVerify();
          });
        } else {
          //limpiar el campo de respuesta pregunta y email de recuperacion
          limpiarRecuperar();
          recuperarCuenta();
          lanzarSweetAlert('error', 'Ay', 'La respuesta de seguridad es incorrecta');
        }
      }
    });
  }
}

function cambiarContrasena() {
  $.ajax({
    url: '../../model/DB/manejoProductos.php',
    type: 'POST',
    data: {
      'method': 'unblock',
      'email': $('#emailRecuperar').val(),
      'password': $('#passwordRecuperar').val()
    },
    success: function (data) {
      if (data == 'success') {
        limpiarRecuperar();
        lanzarSweetAlert('success', ':)', 'Tu contraseña ha sido cambiada con exito\nYa puedes iniciar sesion');
      } else {
        lanzarSweetAlert('error', 'D:', 'Ha ocurrido un errorIntentalo más tarde.');
        limpiarRecuperar();
        recuperarCuenta();
      }
    }
  });
}



function newPaswordVerify() {
  console.log('newPaswordVerify');
  if ($('#passwordRecuperar').val() == $('#confirmPasswordRecuperar').val()) {
    $('#passwordRecuperarText').text('');
    $('#btnRecuperar').prop('disabled', false);
  } else {
    $('#passwordRecuperarText').text('Las contraseñas no coinciden');
    $('#btnRecuperar').prop('disabled', true);
  }
}

function limpiarRecuperar() {
  $('#cuestionarioRecuperar').hide('slow');
  $('#cambiarPassword').hide('slow');
  $('#emailRecuperar').attr('readonly', false);
  $('#emailRecuperar').val('');
  $('#respuestaSeguridad').val('');
  $('#preguntaSeguridad').val('');
  $('#passwordRecuperar').val('');
  $('#confirmPasswordRecuperar').val('');
  $('#btnRecuperar').text('Verificar Email');
  $('#btnRecuperar').prop('disabled', false);
  $('#btnRecuperar').off('click');
  $('#passwordRecuperarText').text('');
  $('#captchaInput').removeClass('is-invalid');
  //verificar si es un input de texto, si es asi, cambiarlo a password
  if ($('#passwordRecuperar').attr('type') == 'text') {
    togglePassword('passwordRecuperar');
  }
  if ($('#confirmPasswordRecuperar').attr('type') == 'text') {
    togglePassword('confirmPasswordRecuperar');
  }
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