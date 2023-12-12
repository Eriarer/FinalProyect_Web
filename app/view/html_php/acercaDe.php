<?php
session_start();
$lastUpdateDate = filemtime(__FILE__);
?>
<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FluffyHugs | Acerca de</title>
  <!-- Boostrap v4.6.2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/nosotros.css">
  <link rel="stylesheet" href="../css/main.css">
  <!-- favIcon -->
  <link rel="icon" type="image/x-icon" href="../../media/images/oso-de-peluche.png" />
</head>
<?php include_once("navbar.php") ?>

<?php include_once("navbar.php") ?>

<body>
  <div class="Tit">
    <br>
    <h1 class="animate__animated animate__backInDown">ACERCA DE NOSOTROS</h1>
    <hr>
  </div>

  <div class="Historia row-col-lg-2">
    <div class="logoSlogan col">
      <img src="../../media/images/LogoSF.png" alt="">
      <div>
        <br>
        <p class="eslogan">
          "Transformando momentos en abrazos suaves y esponjosos"
        </p><br>
      </div>
    </div>
    <div class="col">
      <p>
        En FluffyHugs, una empresa familiar fundada en 2023, nos dedicamos a enriquecer vidas con nuestros peluches únicos y cariñosamente creados.
        Nuestro compromiso con la calidad, sostenibilidad y creatividad se refleja en cada diseño, desde tiernos animales hasta imaginativas creaciones. Valoramos la conexión con nuestros clientes, ofreciendo más que juguetes: compañeros de vida que crean recuerdos inolvidables y un servicio excepcional que nos distingue.
      </p>
      <p>
        Creemos firmemente en la calidad, la sostenibilidad y la creatividad. Por eso, cada uno de nuestros peluches está hecho con los mejores materiales, garantizando no solo suavidad y durabilidad, sino también el respeto por nuestro planeta
      </p>
      <p>
        ¡Únete a nuestra familia y descubre por qué FluffyHugs es más que una tienda de peluches, es un lugar donde los sueños se hacen realidad!
      </p>
    </div>

  </div>


  <div class="cajitas">
    <div class="cajitas">
      <div class="card-group">
        <div class="card col ">
          <img class="card-img-top imgCards" src="../../media/images/vision.jpeg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Visión:</h5>
            <p class="card-text">Nuestra visión es ser líderes en el mundo de los peluches, inspirando sonrisas y creando momentos mágicos para personas de todas las edades. Nos esforzamos por innovar y expandir nuestra gama de productos, manteniendo siempre un compromiso firme con la sostenibilidad y la alegría pura.</p>
          </div>
        </div>
        <div class="card ">
          <img class="card-img-top" src="../../media/images/mision.jpeg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Misión:</h5>
            <p class="card-text">Nuestra misión es enriquecer vidas a través de nuestros peluches, ofreciendo productos de alta calidad, seguros y sostenibles. Nos comprometemos a crear experiencias memorables, apoyando la imaginación y el bienestar emocional de nuestros clientes.</p>
          </div>
        </div>
        <div class="card">
          <img class="card-img-top" src="../../media/images/objetivo.jpeg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Objetivos:</h5>
            <p class="card-text">
            <ul>
              <li>Calidad y Seguridad: Garantizar que cada peluche cumpla con los más altos estándares de calidad y seguridad.</li>
              <li>Sostenibilidad: Implementar prácticas ecológicas en la producción y distribución de nuestros productos.</li>
              <li>Innovación: Continuar innovando en diseño y funcionalidad para ofrecer una gama diversa y atractiva de peluches.</li>
              <li> Satisfacción del Cliente: Mantener una excelente atención al cliente y asegurar la plena satisfacción en cada compra.</li>
              <li> Crecimiento: Expandir nuestra presencia en el mercado, tanto a nivel nacional como internacional. </li>
            </ul>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include_once("footer.php") ?>
</body>


</html>