<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <title>Tienda</title>
  <!-- Boostrap v4.6.% -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  <!-- JQuery y Ajax -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- CSS -->
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/Productoestilo.css">
</head>

<body>
  <?php
  include_once __DIR__ . '/../../model/DB/dataBaseCredentials.php';
  include_once __DIR__ . '/../../model/routes_files.php';
  include_once __DIR__ . '/../../model/DB/controllDB.php';

  include_once("navbar.php");

  $db = new dataBase($credentials, $CONFIG);
  $productos = json_decode($db->getAllProducts(), true);
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
  ?>
  <div class="container-fluid">
    <div class="mt-4 col-3 ">
      <label for="listCat">Categoria:</label>
      <select class="form-control" id="listCat" name="listCat">
        <optgroup class="groupCat">
          <option value="0" selected="selected">Sin filtro</option>
          <option value="1">Por ocasiones</option>
          <option value="2">Especiales</option>
        </optgroup>
      </select>
    </div>

    <?php foreach ($categorias as $categoria) : ?>
      <div id="<?= str_replace(" ", "_", $categoria) ?>">
        <h1 class='text-center mt-4'><?= $categoria ?></h1>
        <hr>
        <div class='row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 d-flex justify-content-center'>
          <?php foreach ($productosCategoria[$categoria] as $producto) :
            $imagenBase = '../../media/images/productos/';
            // quitarle a la ruta de la imagen
            $imageName = explode("/", $producto['prod_imgPath'])[count(explode("/", $producto['prod_imgPath'])) - 1];
            $targetImage = $imagenBase . $imageName;
            // verificar si exista la imagen
            if (!file_exists($targetImage)) {
              $targetImage = $imagenBase . '../imgRelleno.png';
            }
          ?>
            <div class='col p-2'>
              <div class='myCard'>
                <div class='cardHeader'>
                  <img src="<?= $targetImage ?>" alt="<?= $producto['prod_name'] ?>">
                  <div class='overlay'>$<?= $producto['prod_precio'] ?>
                  </div>
                  <?php if ($producto['prod_descuento'] != 0) : ?>
                      <div class='descuento'>
                        Ahorra <?= $producto['prod_descuento'] ?>%
                      </div>
                    <?php endif; ?>
                </div>

                <div class='cardBody'>
                  <h3 class='title-product'><?= $producto['prod_name'] ?></h3>
                  <p class='desciption'><?= $producto['prod_description'] ?></p>
                  <span class='price'>Existencias: <?= $producto['prod_stock'] ?></span>
                </div>
                <div class='cardFooter'>
                  <a href='#' class='btn-cart'>Comprar ahora</a>
                  <a href='#'><i class='nf nf-md-cart_plus'></i></a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>

  </div>

  <?php include_once("footer.php") ?>
  <script>
    $(document).ready(function() {
      $('.myCard').addClass(" animate__animated animate__fadeInUp");

      $('#listCat').change(function() {
        var cat = $(this).val();
        if (cat == 0) {
          $("#Por_ocasiones").show("slow");
          $("#Ediciones_Especiales").show("slow");
        } else if (cat == 1) {
          $("#Ediciones_Especiales").hide("slow");
          $("#Por_ocasiones").show("slow");
        } else if (cat == 2) {
          $("#Por_ocasiones").hide("slow");
          $("#Ediciones_Especiales").show("slow");
        }
      });
    });
  </script>
</body>

</html>