<?php
include_once __DIR__ . '/../../../app/model/routes_files.php';
$rutaBase = __DIR__ . '/../../media/images/productos/';

$productos = array(
  'Por ocasiones' => array(
    array(
      'nombre' => 'Amor Perezoso',
      'descripcion' => 'Este peluche es un encantador perezoso, diseñado para irradiar amor y ternura. Su pelaje es largo y sedoso, invitando a ser acariciado, en tonos de gris suave que recuerdan a la lujosa textura de un abrigo de invierno.',
      'precio' => 390,
      'imagen' => '../../media/images/productos/Perezoso.png',
      'descuento' => 10,
      'existencias' => 100,
      'categoria' => 'ocasiones'
    ),
    array(
      'nombre' => 'Valentina Elefantina',
      'descripcion' => 'Elaborado con materiales hipoalergénicos y suaves al tacto, este peluche es perfecto para todas las edades. Su relleno es esponjoso, lo que lo hace extremadamente abrazable y reconfortante.',
      'imagen' => '../../media/images/productos/Elefante.png',
      'precio' => 190,
      'descuento' => 20,
      'existencias' =>
      10,
      'categoria' => 'ocasiones'
    ),
    array(
      'nombre' => 'Jorge Graduado',
      'descripcion' => 'Con un tamaño mediano, este peluche es ideal tanto para decorar un espacio como para ser un compañero de abrazos.',
      'precio' => 150,
      'imagen' => '../../media/images/productos/chango.png',
      'descuento' => 10,
      'existencias' =>
      0,
      'categoria' => 'ocasiones'
    ),
    array(
      'nombre' => 'Pablo Graduado',
      'descripcion' => 'Elaborado con materiales hipoalergénicos y suaves al tacto, este peluche es perfecto para todas las edades. Su relleno es esponjoso, lo que lo hace extremadamente abrazable y reconfortante.',
      'precio' => 290,
      'imagen' => '../../media/images/productos/pingui.png',
      'descuento' => 10,
      'existencias' =>
      250,
      'categoria' => 'ocasiones'
    ),
    array(
      'nombre' => 'Picasso Navideño',
      'descripcion' => 'Este peluche es un encantador pingüino, diseñado para irradiar amor y ternura. Invitando a ser acariciado, en tonos navideños suave que recuerdan a la lujosa textura de un abrigo de invierno.',
      'precio' => 270,
      'imagen' => '../../media/images/productos/pinguiNav.png',
      'descuento' => 10,
      'existencias' => 0,
      'categoria' => 'ocasiones'
    ),
    array(
      'nombre' => 'Copito',
      'descripcion' => 'Elaborado con materiales hipoalergénicos y suaves al tacto, este peluche es perfecto para todas las edades. Su relleno es esponjoso, lo que lo hace extremadamente abrazable y reconfortante.',
      'precio' => 190,
      'imagen' => '../../media/images/productos/monoNiev.png',
      'descuento' => 10,
      'existencias' => 20,
      'categoria' => 'ocasiones'
    ),
    array(
      'nombre' => 'Salem',
      'descripcion' => 'Este peluche de gatito es más que un juguete; es un compañero que lleva un mensaje de amor y tranquilidad, perfecto para regalar en ocasiones especiales como halloween, dia de muertos o simplemente como un gesto para expresar cariño y afecto.',
      'precio' => 100,
      'imagen' => '../../media/images/productos/gato.png',
      'descuento' => 10,
      'existencias' => 0,
      'categoria' => 'ocasiones'
    ),
    array(
      'nombre' => 'Xochitl',
      'descripcion' => 'Elaborado con materiales hipoalergénicos y suaves al tacto, este peluche es perfecto para todas las edades. Su relleno es esponjoso, lo que lo hace extremadamente abrazable y reconfortante.',
      'precio' => 250,
      'imagen' => '../../media/images/productos/florC.png',
      'descuento' => 10,
      'existencias' => 0,
      'categoria' => 'ocasiones'
    )
  ),
  'Especiales' => array(
    array(
      'nombre' => 'Party Rex',
      'descripcion' => 'Este peluche es un encantador de dinosaurio, diseñado para irradiar amor y ternura. Su pelaje es sedoso, invitando a ser acariciado, en tonos de verdes suave .',
      'precio' => 300,
      'imagen' => '../../media/images/productos/DinoPumpe.png',
      'descuento' => 10,
      'existencias' => 0,
    ),
    array(
      'nombre' => 'Bob Stegosaurus',
      'descripcion' => 'Elaborado con materiales hipoalergénicos y suaves al tacto, este peluche es perfecto para todas las edades. Su relleno es esponjoso, lo que lo hace extremadamente abrazable y reconfortante.',
      'precio' => 350,
      'imagen' => '../../media/images/productos/DinoGlobos.png',
      'descuento' => 10,
      'existencias' => 76,
    ),
    array(
      'nombre' => 'Fénix',
      'descripcion' => 'Elaborado con materiales hipoalergénicos y suaves al tacto, este peluche es perfecto para todas las edades.',
      'precio' => 450,
      'imagen' => '../../media/images/productos/DragoNar.png',
      'descuento' => 10,
      'existencias' => 0,
    ),
    array(
      'nombre' => 'Akura',
      'descripcion' => 'Con un tamaño mediano, este peluche es ideal tanto para decorar un espacio como para ser un compañero de abrazos',
      'precio' => 400,
      'imagen' => '../../media/images/productos/DragoVer.png',
      'descuento' => 10,
      'existencias' => 10,
    ),
    array(
      'nombre' => 'Michi Melody',
      'descripcion' => 'Este peluche es un encantador michi, diseñado para irradiar amor y ternura. Su pelaje es suave, invitando a ser acariciado, en tonos de gris suave que recuerdan a la lujosa textura de un abrigo de invierno.',
      'precio' => 300,
      'imagen' => '../../media/images/productos/Melody.png',
      'descuento' => 10,
      'existencias' => 0,
    ),
    array(
      'nombre' => 'Cinnamoroll',
      'descripcion' => 'Elaborado con materiales hipoalergénicos y suaves al tacto, este peluche es perfecto para todas las edades.',
      'precio' => 370,
      'imagen' => '../../media/images/productos/Cinam.png',
      'descuento' => 10,
      'existencias' => 10,
    ),
    array(
      'nombre' => 'Ake Pirata',
      'descripcion' => 'Es el compañero perfecto para los jóvenes aventureros y los entusiastas de las historias de piratas. Es un regalo ideal que inspira imaginación y lleva la diversión de los cuentos de piratas al cuarto de juegos.',
      'precio' => 850,
      'imagen' => '../../media/images/productos/Pirata.png',
      'descuento' => 10,
      'existencias' => 0,
    ),
    array(
      'nombre' => 'Super Pau',
      'descripcion' => 'Este Super Panda Héroe no es solo un peluche, es un símbolo de coraje y bondad, ofreciendo horas de juego imaginativo y convirtiéndose en un confidente para los pequeños héroes en entrenamiento.',
      'precio' => 280,
      'imagen' => '../../media/images/productos/Super.png',
      'descuento' => 10,
      'existencias' => 10,
    ),
    array(
      'nombre' => 'Ajoudini',
      'descripcion' => 'Elaborado con materiales hipoalergénicos y suaves al tacto, este peluche es perfecto para todas las edades.',
      'precio' => 300,
      'imagen' => '../../media/images/productos/Mago.png',
      'descuento' => 10,
      'existencias' => 0,
    )
  )
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/Productoestilo.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <title>Document</title>
  <!-- Boostrap v4.6.% -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  <!-- JQuery y Ajax -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- CSS -->
  <link rel="stylesheet" href="../css/main.css">
</head>

<body>
  <div class="container-fluid">
    <?php
    foreach ($productos as $categoria => $productosCategoria) {
      echo "<h1 class='text-center'>$categoria</h1>";
      echo "<hr>";
      echo "<div class='row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4'>";
      foreach ($productosCategoria as $producto) {
        echo "<div class='col p-2'>";
        echo "  <div class='myCard'>";
        echo "      <div class='cardHeader'>";
        echo "      <img src='" . $producto['imagen'] . "' alt='" . $producto['nombre'] . "'>";
        echo "      <div class='overlay'>$" . $producto['precio'] . "</div>";
        echo "      <div class='descuento'>";
        if ($producto['descuento'] != 0) {
          echo "Ahorra " . $producto['descuento'] . "%";
        }
        echo "      </div>";
        echo "    </div>";
        echo "    <div class='cardBody'>";
        echo "      <h3 class='title-product'>" . $producto['nombre'] . "</h3>";
        echo "      <p class='desciption'>" . $producto['descripcion'] . "</p>";
        echo "      <span class='price'>Existencias: " . $producto['existencias'] . "</span>";
        echo "    </div>";
        echo "    <div class='cardFooter'>";
        echo "      <a href='#' class='btn-cart'>Comprar ahora</a>";
        echo "      <a href='#'><i class='nf nf-md-cart_plus'></i></a>";
        echo "    </div>";
        echo "  </div>";
        echo "</div>";
      }
      echo "</div>";
    }
    ?>
    <script>
      $(document).ready(function() {
        $('.myCard').addClass("animate__animated animate__fadeInUp");
      });
    </script>
</body>

</html>