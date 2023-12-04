<?php
session_start();
require_once __DIR__ . '/app/model/DB/dataBaseCredentials.php';
require_once __DIR__ . '/app/model/routes_files.php';
require_once __DIR__ . '/app/model/DB/manejoProductos.php';
$db = new dataBase($credentials, $CONFIG);
$productos = json_decode($db->getAllProducts(), true);
// obtener los primeros 6 productos de la base de datos, si hay menos de 6 productos, obtener los que haya
// ver que haya una distribución de productos por categoria
// ejemplo hay dos categorias, son 6 productos, 3 de una categoria y 3 de otra si se puede
// si no se puede, llenar con productos de la otra categoria
$categorias = [];
foreach ($productos as $producto) {
  if (!in_array($producto['categoria'], $categorias)) {
    array_push($categorias, $producto['categoria']);
  }
}
// crear un vector de productos, agrupados por categoria
$productosCategoria = array();
foreach ($categorias as $categoria) {
  $productosCategoria[$categoria] = array();
  foreach ($productos as $producto) {
    if ($producto['categoria'] == $categoria) {
      array_push($productosCategoria[$categoria], $producto);
    }
  }
}
$productosDestacados = array();
// Iterar hasta alcanzar el límite de productos destacados (6)
while (count($productosDestacados) < 6) {
  // Iterar por cada categoría
  foreach ($categorias as $categoria) {
    // Verificar si hay productos disponibles en la categoría actual
    if (!empty($productosCategoria[$categoria])) {
      // Agregar un producto de la categoría actual a los destacados
      $productosDestacados[] = array_shift($productosCategoria[$categoria]);
    }
  }
}


$cantidadProductos = count($productosDestacados);
$baseUrl = 'app/media/images/productos/';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

  <link rel="stylesheet" href="app/view/css/Tiendaestilos.css">
  <link rel="stylesheet" href="app/view/css/main.css">
  <title>FluffyHugs | Inicio</title>
  <!-- favIcon -->
  <link rel="icon" type="image/x-icon" href="app/media/images/oso-de-peluche.png" />
</head>
<?php include_once("app/view/html_php/navbar.php") ?>

<body>
  <br>
  <div id="carouselExampleIndicators" class="carousel slide carrusel" data-ride="carousel">
    <div class="carousel-inner incarrusel">
      <img class="backCarr" src="app/media/images/LogoSF.png" alt="logo">
      <div class="carousel-item active imgcarrusel">
        <img class="d-block w-100" src="app/media/images/fondoNavidad.png" alt="First slide" width="auto" height="500">
      </div>
      <div class="carousel-item imgcarrusel">
        <img class="d-block w-100" src="app/media/images/fondoHalloween.png" alt="Second slide" width="auto" height="500">
      </div>
      <div class="carousel-item imgcarrusel">
        <img class="d-block w-100" src="app/media/images/fondoCumple.png" alt="Third slide" width="auto" height="500">
      </div>
      <div class="carousel-item imgcarrusel">
        <img class="d-block w-100" src="app/media/images/fondoGradua.png" alt="Fourth slide" width="auto" height="500">
      </div>
    </div>
    <a class="carousel-control-prev carrAnt" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next carrSig" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </a><br>
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
      <?php
      for ($i = 0; $i < 15; $i++) {
        if ($cantidadProductos != 0) {
          $index = $i % $cantidadProductos;
          //agregar al carrucerl la cantidad de productos necesarios hasta que haya 16 productos
          // prod_name
          // prod_description
          // prod_stock
          // prod_imgPath
          //quedarse con la ultima parte de la ruta de la imagen dividida por /
          $imgUrl = $productosDestacados[$index]['prod_imgPath'];
          $imgUrl = $baseUrl . $imgUrl;
          // verificar si existe la imagen
          if (!file_exists($imgUrl)) {
            $imgUrl = $baseUrl . '../imgRelleno.png';
          }
          echo '<article class="card_des">
                  <img src="' . $imgUrl . '" alt="" class="image">
                  <section class="body_des">
                    <h3 class="tit_des">' . $productosDestacados[$index]['prod_name'] . '</h4>
                    <p class="texto">' . $productosDestacados[$index]['categoria'] . '<br>
                      <sub> stock: ' . $productosDestacados[$index]['prod_stock'] . '</sub>
                    </p>
                  </section>
                </article>';
        } else {
          //llenar 15 productos de place holder
          echo '<article class="card_des">
                  <img src="app/media/images/imgRelleno.png" alt="" class="image">
                  <section class="body_des">
                    <h3 class="tit_des">producto</h4>
                    <p class="texto">categoria<br>
                      <sub> stock: stock</sub>
                    </p>
                  </section>
                </article>';
        }
      }
      $cantidadProductos = $cantidadProductos == 0 ? 6 : $cantidadProductos;
      ?>
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php include_once("app/view/html_php/footer.php") ?>
    <script>
      $(document).ready(function() {
        // obtener el ancho del contenedor incluyendo 6 tarjetas + el margin en x que tienen
        //obtener la cantidad de tarjetas que hay en el contenedor
        var productos = <?= $cantidadProductos ?>;
        console.log(productos);
        // quitarle el string px al margin-right
        var marginX = parseInt($('.card_des').css('margin-right').substring(0, $('.card_des').css('margin-right').length - 2) +
          $('.card_des').css('margin-left').substring(0, $('.card_des').css('margin-left').length - 2));
        var conteinerWidth = ($('.card_des').width() + marginX) * productos;
        var animationDuration = 30; // segundos
        // Calcula la velocidad de desplazamiento necesario para cubrir el ancho en la duración deseada

        // modificar el :root --container_des_width para que coincida con el ancho del contenedor
        document.documentElement.style.setProperty('--container_des_width', -conteinerWidth + 'px');
        // agregar la animación al contenedor desplazar
        $('.conteiner_des').css('animation', 'desplazar ' + animationDuration + 's linear infinite');
        // si el viewPort cambia de tamaño, de orientación, o cualquier cambio que afecte el tamaño, recalcular el ancho del contenedor
        $(window).on('resize orientationchange', function() {
          var productos = <?= $cantidadProductos ?>;
          // quitarle el string px al margin-right
          var marginX = parseInt($('.card_des').css('margin-right').substring(0, $('.card_des').css('margin-right').length - 2) +
            $('.card_des').css('margin-left').substring(0, $('.card_des').css('margin-left').length - 2));
          var conteinerWidth = ($('.card_des').width() + marginX) * productos;
          $('.conteiner_des').css('animation', 'desplazar ' + animationDuration + 's linear infinite');
        });

      });
    </script>
</body>

</html>