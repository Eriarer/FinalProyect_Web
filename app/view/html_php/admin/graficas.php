<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FluffyHugs | Admin > gráficas </title>
  <!-- favIcon -->
  <link rel="icon" type="image/x-icon" href="../../../media/images/oso-de-peluche.png" />
  <!-- Boostrap v4.6.2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- agregando link para darle estilos a la alerta -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Chart.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
  <!-- CSS -->
  <link rel="stylesheet" href="../../css/main.css" />
  <link rel="stylesheet" href="../../css/admin/graficas.css" />
</head>

<body>
  <?php require_once '../navbar.php'; ?>
  <div class="d-flex justify-content-center align-items-center">
    <!-- generar 2 botones y un texto, el texto tiene un string del mes y los botones permiten navegar de mes a la izquierda a la dercha-->
    <button class="btn btn-primary" id="btn-izq"><i class="nf nf-cod-triangle_left"></i></button>
    <h1 id="mes" class="text-center px-5">Mes</h1>
    <button class="btn btn-primary" id="btn-der"><i class="nf nf-cod-triangle_right"></i></button>
  </div>
  <div class="d-flex justify-content-center align-items-center">
    <div class="container row row-cols-1 row-cols-lg-2">
      <div class="col ">
        <canvas id="chart1" width="100%" height="100%"></canvas>
      </div>
      <div class="col ">
        <canvas id="chart2" width="100%" height="100%"></canvas>
      </div>
    </div>
  </div>
  <?php require_once '../footer.php'; ?>
  <script src="../../js/admin/graficas.js">
  </script>
</body>

</html>