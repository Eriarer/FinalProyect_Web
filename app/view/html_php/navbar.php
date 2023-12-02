<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<!-- Jquery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<?php
require_once __DIR__ . '/../../model/routes_files.php';
$image = $CONFIG['P_images'] . 'LogoSF.png';
$base = $CONFIG['base_url'];
$php = $CONFIG['P_php'];
$css = $CONFIG['P_view'] . 'css/';
$navbarCSS = $css . 'headers/navbar.css';
?>

<link rel="stylesheet" href="<?= $navbarCSS ?>">
<nav class="navbar navbar-expand-sm navbar-dark" id="barramenu">
    <a class="navbar-brand" href="#">
        <img src="<?= $image ?>" width="100" height="auto">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto">
            <li class="nav-item" tootlip="Inicio">
                <a class="nav-link" href="<?= $base . 'index.php' ?>"><i class="nf nf-md-home"></i></a>
            </li>
            <li class="nav-item" tootlip="Tienda">
                <a class="nav-link" href="<?= $php . 'PaginaProductos.php' ?>"><i class="nf nf-md-shopping"></i></a>
            </li>
            <li class="nav-item" tootlip="Acerca de">
                <a class="nav-link" href="<?= $php . 'acercaDe.php' ?>"><i class="nf nf-fa-info_circle"></i></a>
            </li>
            <li class="nav-item" tootlip="Contacto">
                <a class="nav-link" href="#"><i class="nf nf-fa-phone_square"></i></a>
            </li>
            <li class="nav-item" tootlip="Preguntas frecuentes">
                <a class="nav-link" href="<?= $php . 'FAQs.php' ?>"><i class="nf nf-fa-question_circle"></i></a>
            </li>
        </ul>
        <div class="navbar-nav ml-auto mr-3">
            <?php
            $nombre = isset($_SESSION['name']) ? $_SESSION['name'] : (isset($_COOKIE['name']) ? $_COOKIE['name'] : '');
            if ($nombre != '') :
            ?>
                <li class="nav-item" tootlip="Perfil">
                    <a class="nav-link" href="#"><?= $_SESSION['name'] ?></a>
                </li>
                <li class="nav-item" tootlip="Cerrar sesión">
                    <a class="nav-link" id="logOutNav"><i class="nf nf-md-logout"></i></a>
                </li>
                <li class="nav-item" tootlip="Carrito">
                    <a class="nav-link" href="#"><i class="nf nf-md-cart_variant"></i></a>
                </li>
            <?php
            else :
            ?>
                <li class="nav-item" tootlip="Iniciar sesión">
                    <a class="nav-link" id="logInNav"><i class="nf nf-md-login"></i></a>
                </li>
            <?php
            endif;
            ?>
        </div>
    </div>
</nav>

<script>
    var pathModel = '<?= $CONFIG['P_model'] ?>';
    var pathHTML = '<?= $CONFIG['P_php'] ?>';
    var base = '<?= $CONFIG['base_url'] ?>';
    $(document).ready(function() {
        $('#logOutNav').click(function() {
            $.ajax({
                url: pathModel + 'logout.php',
                type: 'POST',
                success: function() {
                    window.location.href = base + 'index.php';
                }
            });
        });

        $('#logInNav').click(function() {
            window.location.href = pathHTML + 'Log_register.php';
        });
    });
</script>