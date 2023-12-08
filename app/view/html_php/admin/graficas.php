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
</head>

<body>
  <?php require_once '../navbar.php'; ?>
  <div class="row row-cols-1 row-cols-lg-2">
    <div class="col ">
      <canvas id="chart1" width="100%" height="100%"></canvas>
    </div>
    <div class="col ">
      <canvas id="chart2" width="100%" height="100%"></canvas>
    </div>
  </div>
  <?php require_once '../footer.php'; ?>

  <script>
    // Chart 1
    // grafica de pie
    let pieChart, barsChart;
    $(document).ready(function() {
      initCharts();
      //sleep 3segundos

    });

    function initCharts() {
      let canva1, canva2;
      canva1 = document.getElementById('chart1').getContext('2d');
      canva2 = document.getElementById('chart2').getContext('2d');

      // Chart 1
      pieChart = new Chart(canva1, {
        type: 'pie',
        data: {
          labels: ['Red', 'Orange', 'Yellow', 'Green', 'Blue'],
          datasets: [{
            label: 'Dataset 1',
            data: [12, 19, 3, 5, 2],
            backgroundColor: ['#ff0000', '#ff8000', '#ffff00', '#00ff00', '#0000ff']
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom',
            },
            title: {
              display: true,
              text: 'Lo más vendido'
            }
          }
        },
      });

      // Chart 2
      barsChart = new Chart(canva2, {
        type: 'bar',
        data: {
          labels: ['Red', 'Orange', 'Yellow', 'Green', 'Blue'],
          datasets: [{
              label: 'Dataset 1 (Bars)',
              data: [1, 10, 1, 4, 1],
              backgroundColor: ['#0000ff', '#ff0000', '#ff8000', '#ffff00', '#00ff00'],
              order: 2
            },
            {
              label: 'Dataset 2 (Bars)',
              data: [11, 9, 2, 1, 1],
              backgroundColor: ['#ff0000', '#ff8000', '#ffff00', '#00ff00', '#0000ff'],
              order: 2
            },
            {
              label: 'Total',
              data: [12, 19, 3, 5, 2],
              type: 'line',
              borderColor: '#000000',
              fill: false,
              order: 0
            }
          ]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom',
              //filtrar la leyendas que el label sea hide y ocultarlas
              labels: {
                filter: function(item, chart) {
                  // Oculta el label solo para el Dataset 3 (Line)
                  return item.datasetIndex !== 2;
                }
              }
            },
            title: {
              display: true,
              text: 'Ventas'
            }
          },
          scales: {
            x: {
              stacked: true,
            },
            y: {
              stacked: true
            }
          }
        },
      });
    }
  </script>
</body>

</html>