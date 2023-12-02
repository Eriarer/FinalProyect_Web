<?php
$css = $CONFIG['P_view'] . 'css/';
$footerCSS = $css . 'headers/footer.css';
?>

<link rel="stylesheet" href="<?= $footerCSS ?>">
<link rel="shortcut icon" href="../../media/imagenes/oso-de-peluche.png" type="image/x-icon">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<!-- leyenda de derechos y fecha - mensaje de que es un proyecto academico -->
<!-- Footer -->
<footer class="bg-body-tertiary text-center" id="piePag">
  <!-- Grid container -->
  <div class="container p-4">
    <!-- Section: Social media -->
    <section class="mb-4">
      <!-- Facebook -->
      <h3>SIGUENOS EN REDES SOCIALES!</h3>
      <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="#!" role="button"><i class="fab fa-facebook-f"></i></a>

      <!-- Twitter -->
      <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="#!" role="button"><i class="fab fa-twitter"></i></a>

      <!-- Google -->
      <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="#!" role="button"><i class="fab fa-google"></i></a>

      <!-- Instagram -->
      <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="#!" role="button"><i class="fab fa-instagram"></i></a>

      <!-- Linkedin -->
      <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="#!" role="button"><i class="fab fa-linkedin-in"></i></a>

      <!-- Github -->
      <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="#!" role="button"><i class="fab fa-github"></i></a>
    </section>
    <!-- Section: Social media -->

    <!-- Section: Form -->
    <section class="">
      <form action="">
        <!--Grid row-->
        <div class="row d-flex justify-content-center">
          <!--Grid column-->
          <div class="col-auto">
            <p class="pt-2">
              <strong>Suscríbete a nuestra tienda</strong>
            </p>
          </div>
          <!--Grid column-->

          <!--Grid column-->
          <div class="col-md-5 col-12">
            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
              <input type="email" id="form5Example24" class="form-control" />
              <label class="form-label" for="form5Example24">Email address</label>
            </div>
          </div>
          <!--Grid column-->

          <!--Grid column-->
          <div class="col-auto contBtn">
            <!-- Submit button -->
            <button data-mdb-ripple-init type="submit" class="btn btn-outline mb-4 btnSuscribe">
              Subscribe
            </button>
          </div>
          <!--Grid column-->
        </div>
        <!--Grid row-->
      </form>
    </section>
    <!-- Section: Form -->

    <!-- Section: Text -->
    <section class="mb-4">
      <p>
        &copy; 2023 FluffyHugs. Todos los derechos reservados. El contenido de este sitio es para propósitos educativos como parte del proyecto académico en la materia de Programacion de sistemas web en la Universidad Autonoma de Aguascalientes.
      </p>
    </section>

    <!-- Section: Links -->
    <section class="">
      <!--Grid row-->
      <div class="row">
        <!--Grid column-->
        <div class="list-footer col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Enlaces Rapidos</h5>
          <ul class="list-unstyled mb-0 ">
            <li>
              <a class="text-body" href="#!">Inicio</a>
            </li>
            <li>
              <a class="text-body" href="#!">Tienda</a>
            </li>
            <li>
              <a class="text-body" href="#!">Acerca de Nosotros</a>
            </li>
            <li>
              <a class="text-body" href="#!">Contacto</a>
            </li>
            <li>
              <a class="text-body" href="#!">FAQs</a>
            </li>
          </ul>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Atención al cliente</h5>
          <ul class="list-unstyled mb-0">
            <li>
              <p class="text-body">Teléfono</p>
            </li>
            <li>
              <p class="text-body">Dirección</p>
            </li>
            <li>
              <p class="text-body">Correo Electrónico</p>
            </li>
          </ul>
        </div>
        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14806.24246221518!2d-102.33273314458006!3d21.912989300000007!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8429ef1da1ab338d%3A0x89a0246637c42ddb!2sUniversidad%20Aut%C3%B3noma%20de%20Aguascalientes!5e0!3m2!1ses!2smx!4v1698689117205!5m2!1ses!2smx" width="500" height="270" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
      <!--Grid row-->
    </section>
    <!-- Section: Links -->
  </div>
  <!-- Grid container -->

  <!-- Copyright -->
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
    © 2023 FluffyHugs
  </div>
  <!-- Copyright -->
</footer>
<!-- Footer -->