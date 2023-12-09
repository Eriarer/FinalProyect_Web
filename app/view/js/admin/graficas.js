let pieChart, barsChart;
var productos, mostSell = [];
const colors = ['#8eb99e', '#8fa3ee', '#ca9ee0', '#e2b4d1', '#eb998f', '#f7cab5', '#f5ef99', '#d2e8db'];
const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
  "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
];
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
  console.log(fechaInicio, fechaFin);
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
            backgroundColor: ['#8eb99e', '#8fa3ee', '#ca9ee0', '#e2b4d1', '#eb998f', '#f7cab5', '#f5ef99', '#d2e8db']
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

function getData(semanas) {

  var labels = [];
  for (let i = 0; i < semanas.length; i++) {
    // truncar el total a 1 decimal
    var total = semanas[i]['total'].toFixed(1);
    labels.push('Dia: ' + semanas[i]['dias'][0]['dia_mes'] + '/' + semanas[i]['dias'][semanas[i]['dias'].length - 1]['dia_mes'] +
      "\nTotal: " + total + '$');
  }

  // Nuevo vector para agrupar los días de la semana
  const diasAgrupados = [];

  // Iterar sobre cada día de la semana (0 a 6)
  for (let i = 0; i < semanas[0].dias.length; i++) {
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
  return data;
}

function drawChart2(semanas) {
  let canva2;
  canva2 = document.getElementById('chart2').getContext('2d');

  var nomDias = ['Lunes ', 'Martes ', 'Miercoles ', 'Jueves ', 'Viernes ', 'Sabado ', 'Domingo '];

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
