<?php
$css = $CONFIG['P_view'] . 'css/';
$footerCSS = $css . 'headers/footer.css';
?>

<link rel="stylesheet" href="<?= $footerCSS ?>">
<link rel="shortcut icon" href="../../media/imagenes/oso-de-peluche.png" type="image/x-icon">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<!-- sweet alert -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- leyenda de derechos y fecha - mensaje de que es un proyecto academico -->
<?php
include_once __DIR__ . '/../../model/routes_files.php';
// $image = $CONFIG['P_images'] . 'LogoSF.png';
$base = $CONFIG['base_url'];
$php = $CONFIG['P_php'];
?>
<footer class="bg-body-tertiary text-center" id="piePag">
  <div class="container p-4">
    <!-- Social media -->
    <section class="mb-4">
      <h3>SIGUENOS EN REDES SOCIALES!</h3>
      <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="https://www.facebook.com/?_rdr" role="button"><i class="fab fa-facebook-f"></i></a>

      <!-- Twitter -->
      <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="https://twitter.com/i/flow/login?input_flow_data=%7B%22requested_variant%22%3A%22eyJsYW5nIjoiZXMifQ%3D%3D%22%7D" role="button"><i class="fab fa-twitter"></i></a>

      <!-- Google -->
      <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="https://www.youtube.com/" role="button"><i class="fab fa-google"></i></a>

      <!-- Instagram -->
      <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="https://www.instagram.com/fluffy_hugs_official/" role="button"><i class="fab fa-instagram"></i></a>

      <!-- Linkedin -->
      <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="#!" role="button"><i class="fab fa-linkedin-in"></i></a>

      <!-- Github -->
      <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="#!" role="button"><i class="fab fa-github"></i></a>
    </section>

    <!-- Form -->
    <section class="mb-4 ">
      <form id="formSuscripcionTienda" action="" method="">
        <div class="row d-flex justify-content-center">
          <div class="col-auto">
            <p class="pt-2">
              <strong>Suscríbete a nuestra tienda</strong>
            </p>
          </div>
          <!-- Email input -->
          <div class="col-md-5 col-12">
            <div class="form-outline">
              <input type="email" id="form5Example24" class="form-control" name="email" placeholder="E-mail" required />
            </div>
          </div>
          <!-- Submit button -->
          <div class="col-auto contBtn">
            <button class="btn btn-outline btnSuscribe">Subscribe</button>
          </div>
        </div>
      </form>
    </section>

    <section class="mb-4">
      <p>
        &copy; 2023 FluffyHugs. Todos los derechos reservados. El contenido de este sitio es para propósitos educativos como parte del proyecto académico en la materia de Programacion de sistemas web en la Universidad Autonoma de Aguascalientes.
        &copy; 2023 FluffyHugs. Todos los derechos reservados. El contenido de este sitio es para propósitos educativos como parte del proyecto académico en la materia de Programacion de sistemas web en la Universidad Autonoma de Aguascalientes.
      </p>
    </section>

    <!--  Links -->
    <section class="">
      <!--Grid row-->
      <div class="row row-cols-1 row-cols-md-3 mb-4 ">
        <!--Grid column-->
        <div class="list-footer col mb-4 mb-md-0">
          <h5 class="text-uppercase">Enlaces Rapidos</h5>
          <ul class="list-unstyled mb-0 ">
            <li>
              <a class="text-body" tootlip="Inicio" href="<?= $base . 'index.php' ?>">Inicio</a>
            </li>
            <li>
              <a class="text-body" tootlip="Tienda" href="<?= $php . 'PaginaProductos.php' ?>">Tienda</a>
            </li>
            <li>
              <a class="text-body" tootlip="Acerca de" href="<?= $php . 'acercaDe.php' ?>">Acerca de Nosotros</a>
            </li>
            <li>
              <a class="text-body" tootlip="Contacto" href="<?= $php . 'contacto.php' ?>">Contacto</a>
            </li>
            <li>
              <a class="text-body" tootlip="Preguntas frecuentes" href="<?= $php . 'FAQs.php' ?>">FAQs</a>
            </li>
          </ul>
        </div>

        <!--Grid column-->
        <div class="col mb-4 mb-md-0">
          <h5 class="text-uppercase">Atención al cliente</h5>
          <ul class="list-unstyled mb-0">
            <li>
              <p class="text-body">449-338-8009</p>
            </li>
            <li>
              <p class="text-body"> Avenida Universidad 940, Ciudad Universitaria, Universidad Autónoma de Aguascalientes, 20100 Aguascalientes, Ags.</p>
            </li>
            <li>
              <p class="text-body">fluffyhugs2023@gmail.com</p>
            </li>
          </ul>
        </div>
        <!--Grid column-->
        <div class="col mb-4 mb-md-0">
          <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14806.24246221518!2d-102.33273314458006!3d21.912989300000007!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8429ef1da1ab338d%3A0x89a0246637c42ddb!2sUniversidad%20Aut%C3%B3noma%20de%20Aguascalientes!5e0!3m2!1ses!2smx!4v1698689117205!5m2!1ses!2smx" width="100%" height="100%" style="border: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%;" allowfullscreen="true" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Copyright -->
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
    © 2023 FluffyHugs
  </div>
</footer>
<script>
  var emailPath = "<?= $CONFIG['P_model'] ?>";
  $(document).ready(function() {
    $('#formSuscripcionTienda').submit(function(e) {
      console.log('entro');
      var email = $('#form5Example24').val();
      e.preventDefault();
      $.ajax({
        url: emailPath + 'mail/suscripcion/correoSuscripcion.php',
        type: "POST",
        data: {
          email: email
        },
        success: function(data) {
          Swal.fire({
            icon: 'success',
            title: '¡Gracias por suscribirte!',
            text: 'Te enviaremos un correo electrónico con las mejores ofertas',
          })
        }
      });
    });
  });
</script>