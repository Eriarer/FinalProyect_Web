<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- Boostrap v4.6.2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <!-- Jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="app/view/css/main.css">
  <title>FluffyHugs | Inicio</title>
  <!-- favIcon -->
  <link rel="icon" type="image/x-icon" href="app/media/images/oso-de-peluche.png" />
</head>
<?php include_once("app/view/html_php/navbar.php") ?>

<body>
  <div id="carouselExampleIndicators" class="carousel slide carrusel " data-ride="carousel">
    <div class="carousel-inner incarrusel">
      <img class="backCarr" src="app/media/images/LogoSF.png" alt="logo">
      <div class="carousel-item active imgcarrusel">
        <img src="app/media/images/fondoNavidad.png" alt="First slide" class="mx-auto d-block img-fluid ">
      </div>
      <div class="carousel-item imgcarrusel">
        <img src="app/media/images/fondoHalloween.png" alt="Second slide" class="mx-auto d-block img-fluid ">
      </div>
      <div class="carousel-item imgcarrusel">
        <img src="app/media/images/fondoCumple.png" alt="Third slide" class="mx-auto d-block img-fluid ">
      </div>
      <div class="carousel-item imgcarrusel">
        <img src="app/media/images/fondoGradua.png" alt="Fourth slide" class="mx-auto d-block img-fluid ">
      </div>
      <div class="carousel-item imgcarrusel">
        <img src="app/media/images/Cupon.png" alt="Five slide" class="mx-auto d-block img-fluid ">
      </div>
    </div>
    <a class="carousel-control-prev carrAnt carousel-control" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next carrSig carousel-control" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </a>
  </div>


  <!-- fin carrusel -->
  <div class="bienvenida container">
    <h3> ¡Bienvenidos a FluffyHugs! <img src="app/media/images/bienvenido.png" height="50"></h3>
    <p>Explora un mundo donde la ternura y la imaginación se encuentran. En FluffyHugs, creemos que cada peluche es más que un juguete; es un compañero de aventuras y un amigo fiel. Nuestra colección de peluches suaves y acogedores está diseñada para llevar alegría a corazones de todas las edades. Desde los clásicos ositos de peluche hasta criaturas fantásticas, cada uno de nuestros peluches tiene su propia personalidad y historia que contar.</p>
    <p style="text-align: center;"><b>¡Explora nuestra tienda y descubre tu próximo compañero de abrazos!</b></p>
  </div>
  <h3 class="Categorias subTitulo">CATEGORIAS</h3>
  <div class="images-row">
    <div class="image-row-top">
      <div class="container1">
        <img src="app/media/images/Festividades.png" alt="portadaOcasiones" class="image1">
        <div class="overlay1">
          <div class="text1">Por Ocasiones</div>
        </div>
      </div>

      <div class="container2">
        <img src="app/media/images/Especiales.png" alt="portadaEspaciales" class="image2">
        <div class="overlay2">
          <div class="text2">Especiales</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Categorias destacadas -->
  <div class="destacados">
    <h3 class="subTitulo">LO MAS DESTACADO</h3>
    <div class="conteiner_des">

    </div>
    <hr><br>
    <!-- Informacion extra -->
    <div class="container mt-4 cajasInfo">
      <div class="row text-center">

        <!-- Caja de "Sitio mayorista" -->
        <div class="col-md-3 mb-3">
          <div class="card h-100">
            <div class="card-body">
              <i class="fas fa-shopping-cart icon-box"></i>
              <h5 class="card-title">Sitio mayorista</h5>
              <p class="card-text">Compra mínima $1,000 MXN (más gastos de envío)</p>
            </div>
          </div>
        </div>

        <!-- Caja de "Envíos gratis" -->
        <div class="col-md-3 mb-3">
          <div class="card h-100">
            <div class="card-body">
              <i class="fas fa-truck icon-box"></i>
              <h5 class="card-title">Envíos gratis*</h5>
              <p class="card-text">En compras mayores a $3,499 MXN</p>
            </div>
          </div>
        </div>

        <!-- Caja de "Compra segura" -->
        <div class="col-md-3 mb-3">
          <div class="card h-100">
            <div class="card-body">
              <i class="fas fa-lock icon-box"></i>
              <h5 class="card-title">Compra segura</h5>
              <p class="card-text">Seremos tus proveedores de confianza</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 mb-3">
          <div class="card h-100">
            <div class="card-body">
              <i class="fas fa-percent icon-box"></i>
              <h5 class="card-title">Descuentos</h5>
              <p class="card-text">En productos seleccionados</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br><br>

    <!-- -------------------------metodos de pago--------- -->
    <div class="container">
      <h3 class="subTitulo">METODOS DE PAGO</h3><br>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4 d-flex justify-content-center">
        <div class="col">
          <!-- alinear al centro, flex columna -->
          <div class="metodo d-flex flex-column align-items-center">
            <img class="Metodopago" src="app/media/images/tarjetaCD.png" alt="tarjetas">
            <div class="text_pago">
              <p>Credito/debito</p>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="metodo d-flex flex-column align-items-center">
            <img class="Metodopago" src="app/media/images/efectivo2.png" alt="efectivo">
            <div class="text_pago">
              <p>Efectivo</p>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="metodo d-flex flex-column align-items-center">
            <img class="Metodopago" src="app/media/images/tarjetaRegalo.png" alt="tarjetaRegalo">
            <div class="text_pago">
              <p>Tarjeta de regalo</p>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="metodo d-flex flex-column align-items-center">
            <img class="Metodopago" src="app/media/images/oxxo.png" alt="oxxo">
            <div class="text_pago">
              <p>Tiendas Oxxo</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <br>
    <?php include_once("app/view/html_php/footer.php") ?>
    <script src="index.js"></script>
</body>

</html>