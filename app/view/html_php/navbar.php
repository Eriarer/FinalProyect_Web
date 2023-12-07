<?php
require_once __DIR__ . '/../../model/routes_files.php';
include_once __DIR__ . '/../../model/DB/dataBaseCredentials.php';
include_once __DIR__ . '/../../model/DB/controllDB.php';
// si las coockies estan seteadas verificarlas en la base de datos si es que el usuario existe
// de ser así setear la variable de sesion 
$db = new dataBase($credentials, $CONFIG);
if (isset($_COOKIE['email']) && isset($_COOKIE['password']) && isset($_COOKIE['name'])) {
  $email = $_COOKIE['email'];
  $password = $_COOKIE['password'];
  $response = $db->login($email, $password);
  // si la respuesta es diferente de 0 es porque el usuario no existe o esta bloqueado
  // borramos las cookies
  if ($response != 0) {
    setcookie("name", '', time() - 3600, "/");
    setcookie('email', '', time() - 3600, '/');
    setcookie('password', '', time() - 3600, '/');
  } else {
    $user = $db->getUserByEmail($email);
    //escribir la variable de sesion
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $user['usr_account'];
  }
} else {
  setcookie("name", '', time() - 3600, "/");
  setcookie('email', '', time() - 3600, '/');
  setcookie('password', '', time() - 3600, '/');
}

$image = $CONFIG['P_images'] . 'LogoSF.png';
$base = $CONFIG['base_url'];
$php = $CONFIG['P_php'];
$css = $CONFIG['P_view'] . 'css/';
$navbarCSS = $css . 'headers/navbar.css';
?>

<link rel="stylesheet" href="<?= $navbarCSS ?>">
<nav id="barramenu" class="navbar navbar-expand-md navbar-dark ">
  <a class=" navbar-brand" href="#">
    <img src="<?= $image ?>" width="100" height="auto">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class=" navbar-nav me-auto">
      <li class="nav-item">
        <a class="nav-link" tootlip="Inicio" href="<?= $base . 'index.php' ?>"><i class="nf nf-md-home"></i></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" tootlip="Tienda" href="<?= $php . 'PaginaProductos.php' ?>"><i class="nf nf-md-shopping"></i></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" tootlip="Acerca de" href="<?= $php . 'acercaDe.php' ?>"><i class="nf nf-fa-info_circle"></i></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" tootlip="Contacto" href="<?= $php . 'contacto.php' ?>"><i class="nf nf-fa-phone_square"></i></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" tootlip="Preguntas frecuentes" href="<?= $php . 'FAQs.php' ?>"><i class="nf nf-fa-question_circle"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav navbar-highlight">
      <?php
      $nombre = isset($_SESSION['name']) ? $_SESSION['name'] : '';
      $correo = isset($_SESSION['email']) ? $_SESSION['email'] : '';
      if ($nombre != '' && $correo != '') {
        $admin = $db->validAdmin($correo);
        if ($admin == true) {
      ?>
          <!-- <li class="nav-item nav-item-admin mr-3 no-tooltip menu">
            <a class="nav-link" href=""><i class="nf nf-fa-gear"></i></a>
            <div class="menu_desple">
              <a href="<?= $php . 'admin/AltaProd.php' ?>" class="opcion">Alta-productos</a>
              <a href="<?= $php . 'admin/BajasProd.php' ?>" class="opcion">Baja-productos</a>
              <a href="<?= $php . 'admin/ModifyProd.php' ?>" class="opcion">Edición-productos</a>
            </div>
          </li> -->
          <li class="nav-item no-tooltip" id="menu">
            <a class="nav-link" href="#" id="navbarDropdown">
              <i class="nf nf-fa-gear"></i>
            </a>
            <div id="menu_inner">
              <a class="nav-link" href="<?= $php . 'admin/AltaProd.php' ?>">Alta productos</a>
              <a class="nav-link" href="<?= $php . 'admin/BajasProd.php' ?>">Baja productos</a>
              <a class="nav-link" href="<?= $php . 'admin/ModifyProd.php' ?>">Edición productos</a>
            </div>
          </li>
        <?php
        }
      }
      $nombre = isset($_SESSION['name']) ? $_SESSION['name'] : '';
      if ($nombre != '') :
        ?>

        <li class="nav-item no-tooltip">
          <a class="nav-link" href="#"><?= $_SESSION['name'] ?></a>
        </li>
        <li class="nav-item ">
          <a class="nav-link" tootlip="Cerrar sesión" id="logOutNav"><i class="nf nf-md-logout"></i></a>
        </li>
        <li class="nav-item d-flex align-items-center no-tooltip" id="carriotContainer">
          <a class="nav-link " href=" #" id="carrito">
            <i class="nf nf-md-cart_variant"></i>
            <span id="num_prod"><?= isset($_SESSION['productos']) ? $_SESSION['productos'] : 0; ?></span> <!-- cantidad de productos -->
          </a>
        </li>
      <?php
      else :
      ?>
        <li class="nav-item mr-3">
          <a class="nav-link" tootlip="Iniciar sesión" id="logInNav"><i class="nf nf-md-login"></i></a>
        </li>
      <?php
      endif;
      ?>
    </ul>
  </div>
</nav>

<script>
  var pathModel = '<?= $CONFIG['P_model'] ?>';
  var pathHTML = '<?= $CONFIG['P_php'] ?>';
  var base = '<?= $CONFIG['base_url'] ?>';
  $(document).ready(function() {
    $('#logOutNav').click(function() {
      $.ajax({
        url: pathModel + 'user/logout.php',
        type: 'POST',
        success: function(data) {
          console.log(data);
          // ir al index
          window.location.href = base + 'index.php';
        }
      });
    });

    $('#logInNav').click(function() {
      window.location.href = pathHTML + 'Log_register.php';
    });


    try {
      var menuInner = $(this).find('#menu_inner');
      menuInner.css('animation', 'none');
      menuInner.css('opacity', '0');
      menuInner.css('transform', 'translateX(0px)');
      // Obtener la posición actual del menú desplegable
      menuInner.css('display', 'block');
      var menuPosition = $("#menu_inner").offset().left;
      var menuWidth = $("#menu_inner").width();
      menuInner.css('display', 'none');
      // Obtener el ancho de la ventana
      var windowWidth = $(window).width();
      // Si el menú desplegable se sale de la ventana, moverlo hacia la izquierda
      if (menuPosition + menuWidth > windowWidth) {
        //calcular los pixeles que se salen del ancho de la ventana
        var pixels = menuPosition + menuWidth - windowWidth + 10;
        menuInner.css('transform', 'translateX(-' + pixels + 'px)');
        $(":root").css("--menu-translateX", "-" + pixels + "px");
      } else {
        menuInner.css('transform', 'translateX(0px)');
        $(":root").css("--menu-translateX", "0px");
      }

      var menu = $(this).find('#menu');
      // si existe el menu
      menu.mouseenter(function() {
        var menuInner = $(this).find('#menu_inner');
        menuInner.css('animation', 'none');
        menuInner.css('opacity', '0');
        menuInner.css('transform', 'translateX(0px)');
        // Obtener la posición actual del menú desplegable
        menuInner.css('display', 'block');
        var menuPosition = $("#menu_inner").offset().left;
        var menuWidth = $("#menu_inner").width();
        menuInner.css('display', 'none');
        // Obtener el ancho de la ventana
        var windowWidth = $(window).width();
        // Si el menú desplegable se sale de la ventana, moverlo hacia la izquierda
        if (menuPosition + menuWidth > windowWidth) {
          //calcular los pixeles que se salen del ancho de la ventana
          var pixels = menuPosition + menuWidth - windowWidth + 10;
          menuInner.css('transform', 'translateX(-' + pixels + 'px)');
          $(":root").css("--menu-translateX", "-" + pixels + "px");
        } else {
          menuInner.css('transform', 'translateX(0px)');
          $(":root").css("--menu-translateX", "0px");
        }
        menuInner.css('animation', 'none');
        menuInner.css('animation', 'desplegar-menu 0.3s ease-in-out forwards');
        menuInner.css('display', 'block');
      });
      menu.mouseleave(function() {
        var menuInner = $(this).find('#menu_inner');
        menuInner.css('animation', 'none');
        menuInner.css('animation', 'plegar-menu 0.3s ease-in-out forwards');
        menuInner.css('display', 'block');
      });
    } catch (e) {
      console.log(e);
    }
  });
</script>