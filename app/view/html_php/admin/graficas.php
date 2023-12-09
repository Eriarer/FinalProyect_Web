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

  <script>
    // Chart 1
    // grafica de pie
    let pieChart, barsChart;
    var productos = {},
      mostSell = [];
    let colors = ['#8eb99e', '#8fa3ee', '#ca9ee0', '#e2b4d1', '#eb998f', '#f7cab5', '#f5ef99', '#d2e8db'];
    $(document).ready(function() {
      //obtener las facturas del 1 de diciembre al 31 de diciembre
      // el método esta en manejoFacutras.php
      /*if ($method == "getFacturas") {
      //este metodo utiliza un periodo de tiempo para obtener las facturas
      $fechaInicio = date("Y-m-d", strtotime($_POST['fechaInicio']));
      $fechaFin = date("Y-m-d", strtotime($_POST['fechaFin']));
      $result = $db->getFacturas($fechaInicio, $fechaFin);
      return $result;
      */
      $.ajax({
        url: '../../../model/DB/manejoFacturas.php',
        type: 'POST',
        data: {
          method: 'getFacturas',
          fechaInicio: '2023-12-01',
          fechaFin: '2023-12-31'
        },
        success: function(response) {
          let data = JSON.parse(response);
          const daysInMonth = new Date(2023, 12, 0).getDate();
          const daysPerWeek = Math.ceil(daysInMonth / 4);
          const length = data.length;
          // por cada factura obtener la información de los productos
          for (let i = 0; i < length; i++) {
            // obtener su total
            var detallesLen = data[i]['detalles'].length;
            for (let j = 0; j < detallesLen; j++) {
              // obtener el id del producto
              var id = data[i]['detalles'][j]['prod_id'];

              // Inicializar detalles[id] si aún no existe
              if (!productos[id]) {
                productos[id] = {
                  total: 0
                };
              }

              // obtener la cantidad
              var cantidad = data[i]['detalles'][j]['cantidad'];
              // agregar la cantidad al total del producto
              var total = productos[id]['total'];
              total += cantidad;
              productos[id]['total'] = total;
              productos[id]['prod_id'] = id;
            }
          }
          // obtener los 5 productos mas vendidos
          var top = Object.values(productos).sort((a, b) => b.total - a.total).slice(0, 5);

          // Declarar la variable 'ajaxPromises' aquí
          const ajaxPromises = [];

          // obtener los nombres de los productos mas vendidos
          //crear una funcion anonima para obtener los nombres de los productos
          // una vez que se obtengan, graficar
          for (let i = 0; i < top.length; i++) {
            const id = top[i]['prod_id'];

            // Crear una promesa para cada llamada AJAX y agregarla a la lista
            const promise = new Promise((resolve) => {
              getProductos(i, id, top, resolve);
            });

            ajaxPromises.push(promise);
          }

          // Esperar a que todas las promesas se resuelvan antes de ejecutar initChart1
          Promise.all(ajaxPromises).then(() => {
            initChart1(mostSell);
          });

          const invoicesByWeek = {};
          data.forEach((invoice) => {
            const invoiceDate = new Date(invoice.fecha_factura);
            const weekNumber = Math.ceil(invoiceDate.getDate() / daysPerWeek);

            if (!invoicesByWeek[weekNumber]) {
              invoicesByWeek[weekNumber] = [];
            }

            invoicesByWeek[weekNumber].push(invoice);
          });
          initChart2(invoicesByWeek);
        }
      });
    });

    function getProductos(i, id, top, resolve) {
      $.ajax({
        url: '../../../model/DB/manejoProductos.php',
        type: 'POST',
        data: {
          method: 'getProduct',
          id: id
        },
        success: function(response) {
          let data = JSON.parse(response);
          var array = {
            nombre: data['prod_name'],
            total: top[i]['total']
          }
          mostSell[i] = array;

          // Resuelve la promesa una vez que se ha obtenido la información del producto
          resolve();
        }
      });
    }

    function initChart1(mostSell) {
      let canva1;
      canva1 = document.getElementById('chart1').getContext('2d');
      let productsCount = [];
      let productsLabels = [];
      for (let i = 0; i < mostSell.length; i++) {
        productsCount.push(mostSell[i]['total']);
        productsLabels.push(mostSell[i]['nombre']);
      }
      // Chart 1
      pieChart = new Chart(canva1, {
        type: 'pie',
        data: {
          labels: productsLabels,
          datasets: [{
            label: 'Dataset 1',
            data: productsCount,
            backgroundColor: ['#8eb99e', '#8fa3ee', '#ca9ee0', '#e2b4d1', '#eb998f', '#f7cab5', '#f5ef99', '#d2e8db']
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
              text: 'Lo más vendido',
              color: '#153977',
              font: {
                size: '50em',
                // cambiar el color de la fuente
              }
            }
          }
        },
      });
    }

    function initChart2(invoicesByWeek) {
      let canva2;
      canva2 = document.getElementById('chart2').getContext('2d');

      // Chart 2
      barsChart = new Chart(canva2, {
        type: 'bar',
        data: {
          labels: ['Red', 'Orange', 'Yellow', 'Green', 'Blue'],
          datasets: [{
              label: 'Dataset 1 (Bars)',
              data: [1, 10, 1, 4, 1],
              backgroundColor: ['#8eb99e', '#8fa3ee', '#ca9ee0', '#e2b4d1', '#eb998f', '#f7cab5', '#f5ef99', '#d2e8db'],
              order: 2
            },
            {
              label: 'Dataset 2 (Bars)',
              data: [11, 9, 2, 1, 1],
              backgroundColor: ['#f7cab5', '#f5ef99', '#d2e8db', '#8eb99e', '#8fa3ee', '#ca9ee0', '#e2b4d1', '#eb998f'],
              order: 2
            },
            {
              label: 'Total',
              data: [12, 19, 3, 5, 2],
              type: 'line',
              borderColor: '#15397780',
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
              text: 'Ventas',
              color: '#153977',
              font: {
                size: '50em',
                // cambiar el color de la fuente
              }
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