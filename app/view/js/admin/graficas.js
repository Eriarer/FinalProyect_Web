let pieChart, barsChart;
var productos, mostSell = [];
let colors = ['#8eb99e', '#8fa3ee', '#ca9ee0', '#e2b4d1', '#eb998f', '#f7cab5', '#f5ef99', '#d2e8db'];
$(document).ready(function () {
  initChart1();
  initChart2();
});

function initChart1() {
  $.ajax({
    url: '../../../model/DB/facturas/mostSelled.php',
    method: 'POST',
    data: {
      fechaInicio: '2023-12-01',
      fechaFin: '2023-12-31'
    },
    success: function (response) {
      response = JSON.parse(response);
      drawChart1(response);
    }
  });
}

function initChart2() {
  $.ajax({
    url: '../../../model/DB/facturas/getVentasSemana.php',
    method: 'POST',
    data: {
      fechaInicio: '2023-12-01',
      fechaFin: '2023-12-31'
    },
    success: function (response) {
      response = JSON.parse(response);
      drawChart2(response);
    }
  });
}

function drawChart1(mostSell) {
  let canva1;
  canva1 = document.getElementById('chart1').getContext('2d');
  let productsCount = [];
  let productsLabels = [];
  for (let i = 0; i < mostSell.length; i++) {
    productsCount.push(mostSell[i]['total']);
    productsLabels.push(mostSell[i]['prod_name']);
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
          labels: {
            usePointStyle: true,
          }
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

function drawChart2(semanas) {
  //console.log(semanas);
  let canva2;
  canva2 = document.getElementById('chart2').getContext('2d');

  var labels = [];
  console.log(semanas[0])
  for (let i = 0; i < semanas.length; i++) {
    // truncar el total a 1 decimal
    var total = semanas[i]['total'].toFixed(1);
    labels.push('Dia: ' + semanas[i]['dias'][0]['dia_mes'] + '/' + semanas[i]['dias'][semanas[i]['dias'].length - 1]['dia_mes'] +
      "\nTotal: " + total + '$');
  }

  console.log(labels);
  // Nuevo vector para agrupar los días de la semana
  const diasAgrupados = [];

  // Iterar sobre cada día de la semana (0 a 6)
  for (let i = 0; i < semanas[0].dias.length; i++) {
    // llenar el vector de dias agrupados
    // semana[i].dias[0]
    // semana[i].dias[1]
    // semana[i].dias[2]
    // si es que existe el elemento del dia[]
    const datosPorDia = [];
    for (let j = 0; j < semanas.length; j++) {
      if (semanas[j].dias[i]) {
        datosPorDia.push(semanas[j].dias[i]);
      } else {
        datosPorDia.push({});
      }
    }
    diasAgrupados.push(datosPorDia);
  }


  // crear el dataset
  var dataset = [];
  for (let i = 0; i < diasAgrupados.length; i++) {
    var tempdataset = {
      label: "",
      data: [],
      backgroundColor: [],
      order: 2
    };
    for (let j = 0; j < diasAgrupados[i].length; j++) {
      var ventas = diasAgrupados[i][j]['total_ventas'];
      ventas = ventas ? ventas : 0;
      var dia = diasAgrupados[i][j]['dia_semana'];
      dia = dia ? dia : 0;
      tempdataset.data.push(ventas);
      tempdataset.backgroundColor.push(colors[dia]);
    }
    for (let j = 0; j < diasAgrupados[i].length; j++) {
      if (diasAgrupados[i][j]['nombre_dia']) {
        tempdataset.label = diasAgrupados[i][j]['nombre_dia'];
        break;
      }
    }
    dataset.push(tempdataset);
  }

  var line = {
    label: 'Total',
    type: 'line',
    data: [],
    backgroundColor: '#143976',
    order: 0
  }
  for (let i = 0; i < semanas.length; i++) {
    line.data.push(semanas[i]['total']);
  }
  dataset.push(line);

  // crear un vector de datast de dias para mostrar la leyenda
  var dias = [];

  var nomDias = ['Lunes ', 'Martes ', 'Miercoles ', 'Jueves ', 'Viernes ', 'Sabado ', 'Domingo '];
  for (let i = 0; i < 7; i++) {
    var tempDia = {
      label: nomDias[i],
      type: 'line',
      data: [],
      backgroundColor: colors[i],
      order: 1
    }
    dias.push(tempDia);
  }

  // empujar los tempdias al dataset
  dataset.push(...dias);
  var data = {
    labels: labels,
    datasets: dataset
  };

  barsChart = new Chart(canva2, {
    type: 'bar',
    data: data,
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            //permitir saltos de linea
            usePointStyle: true,
            //ocultar el label de todo
            filter: function (item) {
              // Mostrar solo los labels que sean un dia de la semana
              for (let i = 0; i < nomDias.length; i++) {
                if (item.text == nomDias[i]) {
                  return true;
                }
              }
              return false;
            }
          },
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
