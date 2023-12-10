let pieChart, barsChart;
var productos, mostSell = [];
const colors = ['#b5ead7', '#c6cfea', '#ddbdf0', '#ff9aa2', '#ffb7b2', '#fedac0', '#e2f0cb'];
const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
  "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
];
const nomDias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
$(document).ready(function () {

  // obtener el Mes actual y colocarlo en el texto
  // agregar funcionalidad a los botones para que cambien el mes
  var mes = new Date().getMonth();
  var anio = new Date().getFullYear();
  var maxMes = new Date().getMonth();
  var maxAnio = new Date().getFullYear();
  $("#mes").text(meses[mes] + " de " + anio);
  $("#btn-izq").click(function () {
    if (mes == 0) {
      mes = 11;
      anio--;
    } else {
      mes--;
    }
    $("#mes").text(meses[mes] + " de " + anio);
    // actualizar los graficos
    actualizarGraficos(anio, mes);
  });
  $("#btn-der").click(function () {
    if (anio == maxAnio && mes == maxMes) {
      return;
    }
    if (mes == 11) {
      mes = 0;
      anio++;
    } else {
      mes++;
    }
    $("#mes").text(meses[mes] + " de " + anio);
    // actualizar los graficos
    actualizarGraficos(anio, mes);
  });

  // obtener la fecha de inicio y fin del mes actual 
  var fechaInicio = new Date(anio, mes, 1);
  var fechaFin = new Date(anio, mes + 1, 0);
  // ajustar las fechas al formato YYYY-MM-DD
  fechaInicio = fechaInicio.toISOString().slice(0, 10);
  fechaFin = fechaFin.toISOString().slice(0, 10);
  initChart1(fechaInicio, fechaFin);
  initChart2(fechaInicio, fechaFin);
});

function actualizarGraficos(anio, mes) {
  var fechaInicio = new Date(anio, mes, 1);
  var fechaFin = new Date(anio, mes + 1, 0);
  // ajustar las fechas al formato YYYY-MM-DD
  fechaInicio = fechaInicio.toISOString().slice(0, 10);
  fechaFin = fechaFin.toISOString().slice(0, 10);
  updateChart1(fechaInicio, fechaFin);
  updateChart2(fechaInicio, fechaFin);
}

function updateChart1(fechaInicio, fechaFin) {
  $.ajax({
    url: '../../../model/DB/facturas/mostSelled.php',
    method: 'POST',
    data: {
      fechaInicio: fechaInicio,
      fechaFin: fechaFin
    },
    success: function (response) {
      response = JSON.parse(response);
      if (response.length == 0) {
        pieChart.data = {};
      } else {
        pieChart.data = {
          labels: productLabels(response),
          datasets: [{
            label: 'Dataset 1',
            data: productsCount(response),
            backgroundColor: colors
          }]
        };
      }
      pieChart.update();
    }
  });
}

function updateChart2(fechaInicio, fechaFin) {
  $.ajax({
    url: '../../../model/DB/facturas/getVentasSemana.php',
    method: 'POST',
    data: {
      fechaInicio: fechaInicio,
      fechaFin: fechaFin
    },
    success: function (response) {
      response = JSON.parse(response);
      console.log(response);
      // si no hay datos, borrar la data
      if (response.length == 0) {
        barsChart.data = {};
      } else {
        barsChart.data = getData(response);
      }
      barsChart.update();
    }
  });
}

function initChart1(fechaInicio, fechaFin) {
  $.ajax({
    url: '../../../model/DB/facturas/mostSelled.php',
    method: 'POST',
    data: {
      fechaInicio: fechaInicio,
      fechaFin: fechaFin
    },
    success: function (response) {
      response = JSON.parse(response);
      drawChart1(response);
    }
  });
}

function initChart2(fechaInicio, fechaFin) {
  $.ajax({
    url: '../../../model/DB/facturas/getVentasSemana.php',
    method: 'POST',
    data: {
      fechaInicio: fechaInicio,
      fechaFin: fechaFin
    },
    success: function (response) {
      response = JSON.parse(response);
      console.log(response);
      drawChart2(response);
    }
  });
}

function productLabels(data) {
  let productsLabels = [];
  for (let i = 0; i < data.length; i++) {
    productsLabels.push(data[i]['prod_name']);
  }
  return productsLabels;
}

function productsCount(data) {
  let productsCount = [];
  for (let i = 0; i < data.length; i++) {
    productsCount.push(data[i]['total']);
  }
  return productsCount;
}

function drawChart1(mostSell) {
  let canva1;
  canva1 = document.getElementById('chart1').getContext('2d');

  // Chart 1
  pieChart = new Chart(canva1, {
    type: 'pie',
    data: {
      labels: productLabels(mostSell),
      datasets: [{
        label: 'Dataset 1',
        data: productsCount(mostSell),
        backgroundColor: colors
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

function getData(semanas) {
  var labels = [];
  for (let i = 0; i < semanas.length; i++) {
    var total = semanas[i]['total'].toFixed(1);
    labels.push('Dia: ' + semanas[i]['dias'][0]['dia_mes'] + '/' + semanas[i]['dias'][semanas[i]['dias'].length - 1]['dia_mes'] +
      "\nTotal: " + total + '$');
  }

  var dataset = [];
  for (let i = 0; i < semanas.length; i++) {
    for (let j = 0; j < semanas[i]['dias'].length; j++) {
      var temp = {
        label: "",
        data: [],
        backgroundColor: '',
        order: 2
      }
      temp.label = semanas[i]['dias'][j]['nombre_dia'] + '-' + semanas[i]['dias'][j]['dia_mes'];
      switch (i) {
        case 0:
          temp.data = [semanas[i]['dias'][j]['total_ventas'], 0, 0, 0];
          break;
        case 1:
          temp.data = [0, semanas[i]['dias'][j]['total_ventas'], 0, 0];
          break;
        case 2:
          temp.data = [0, 0, semanas[i]['dias'][j]['total_ventas'], 0];
          break;
        case 3:
          temp.data = [0, 0, 0, semanas[i]['dias'][j]['total_ventas']];
          break;
        default:
          temp.data = [0, 0, 0, 0];
          break;
      }
      temp.backgroundColor = colors[semanas[i]['dias'][j]['dia_semana']];
      dataset.push(temp);
    }
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

  var dias = [];
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

  dataset.push(...dias);
  var data = {
    labels: labels,
    datasets: dataset
  };

  console.log(data);
  return data;
}



function drawChart2(semanas) {
  let canva2;
  canva2 = document.getElementById('chart2').getContext('2d');
  barsChart = new Chart(canva2, {
    type: 'bar',
    data: getData(semanas),
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
