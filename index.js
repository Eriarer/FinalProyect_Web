$(document).ready(function () {
  $('.conteiner_des').hide();
  getAllProducts();
});

function infiniteScroll(productosDestacados) {
  var cantidadProductos = productosDestacados.length;

  // Obtener el ancho del contenedor incluyendo 6 tarjetas + el margen en x que tienen
  // Obtener la cantidad de tarjetas que hay en el contenedor
  var marginX = parseInt($('.card_des').css('margin-right').substring(0, $('.card_des').css('margin-right').length - 2) +
    $('.card_des').css('margin-left').substring(0, $('.card_des').css('margin-left').length - 2));
  var conteinerWidth = ($('.card_des').width() + marginX) * cantidadProductos;
  var animationDuration = 60; // segundos

  // Calcula la velocidad de desplazamiento necesario para cubrir el ancho en la duración deseada

  // Modificar el :root --container_des_width para que coincida con el ancho del contenedor
  document.documentElement.style.setProperty('--container_des_width', -conteinerWidth + 'px');

  // Agregar la animación al contenedor desplazar
  $('.conteiner_des').css('animation', 'desplazar ' + animationDuration + 's linear infinite');

  // Si el viewport cambia de tamaño, de orientación, o cualquier cambio que afecte el tamaño, recalcular el ancho del contenedor
  $(window).on('resize orientationchange', function () {
    var cantidadProductos = productosDestacados.length;
    // Quitarle el string px al margin-right
    var marginX = parseInt($('.card_des').css('margin-right').substring(0, $('.card_des').css('margin-right').length - 2) +
      $('.card_des').css('margin-left').substring(0, $('.card_des').css('margin-left').length - 2));
    var conteinerWidth = ($('.card_des').width() + marginX) * cantidadProductos;
    $('.conteiner_des').css('animation', 'desplazar ' + animationDuration + 's linear infinite');
  });
}

function agregarProductosAlContenedor(productosDestacados) {
  // Obtener la referencia al contenedor
  var contenedor = $('.conteiner_des');

  // Limpiar el contenido existente en el contenedor
  contenedor.empty();
  var base_dir = 'app/media/images/productos/';
  var relleno = 'app/media/images/imgRelleno.png';

  // Recorrer el número de tarjetas deseadas (en este caso, 15)
  for (var i = 0; i < 15; i++) {
    var index = i % productosDestacados.length;
    var imgPath = base_dir + productosDestacados[index].prod_imgPath;

    // Crear un elemento de tarjeta
    var tarjeta = $('<article class="card_des">' +
      '<img src="' + imgPath + '" alt="" class="image prod_destacado" onerror="this.src=\'' + relleno + '\'">' +
      '<section class="body_des">' +
      '<h3 class="texto">' + productosDestacados[index].prod_name + '</h4>' +
      '</section>' +
      '</article>');

    // Agregar la tarjeta al contenedor
    contenedor.append(tarjeta);
  }
  contenedor.show("slow");
}

function getAllProducts() {
  // conseguir la fecha de inicio y final en formato date YYYY-MM-DD
  var fechaFin = new Date();
  var fechaInicio = new Date();
  fechaInicio.setMonth(fechaInicio.getMonth() - 3);

  // formatear la fecha
  const formatoFecha = (fecha) => {
    const year = fecha.getFullYear();
    const month = String(fecha.getMonth() + 1).padStart(2, '0');
    const day = String(fecha.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  };

  fechaFin = formatoFecha(fechaFin);
  fechaInicio = formatoFecha(fechaInicio);
  $.ajax({
    url: 'app/model/DB/facturas/mostSelled.php',
    type: 'POST',
    data: {
      fechaInicio: fechaInicio,
      fechaFin: fechaFin
    },
    success: function (data) {
      var productos = JSON.parse(data);
      console.log(productos);

      agregarProductosAlContenedor(productos);

      infiniteScroll(productos);

    }
  });
}