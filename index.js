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
  var animationDuration = 30; // segundos

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
      '<img src="' + imgPath + '" alt="" class="image" onerror="this.src=\'' + relleno + '\'">' +
      '<section class="body_des">' +
      '<h3 class="tit_des">' + productosDestacados[index].prod_name + '</h4>' +
      '<p class="texto">' + productosDestacados[index].categoria + '<br>' +
      '<sub> stock: ' + productosDestacados[index].prod_stock + '</sub>' +
      '</p>' +
      '</section>' +
      '</article>');

    // Agregar la tarjeta al contenedor
    contenedor.append(tarjeta);
  }
  contenedor.show("slow");
}

function getAllProducts() {
  $.ajax({
    url: 'app/model/DB/manejoProductos.php',
    type: 'POST',
    data: {
      method: 'getAllProducts'
    },
    success: function (data) {
      var productos = JSON.parse(data);
      // Conseguir máximo 6 productos y crear un vector de productos mezclando categorías
      var productosCategoria = {};
      var categorias = [];

      // Obtener categorías únicas
      productos.forEach(function (producto) {
        if (!categorias.includes(producto.categoria)) {
          categorias.push(producto.categoria);
        }
      });

      // Inicializar productos agrupados por categoría
      categorias.forEach(function (categoria) {
        productosCategoria[categoria] = [];
      });

      // Agrupar productos por categoría
      productos.forEach(function (producto) {
        productosCategoria[producto.categoria].push(producto);
      });

      var productosDestacados = [];
      // Iterar hasta alcanzar el límite de productos destacados (6) o no haya más productos
      while (productosDestacados.length < 6) {
        let productosDisponibles = false;

        // Iterar por cada categoría
        categorias.forEach(function (categoria) {
          // Verificar si hay productos disponibles en la categoría actual
          if (productosCategoria[categoria].length > 0) {
            // Agregar un producto de la categoría actual a los destacados
            productosDestacados.push(productosCategoria[categoria].shift());
            productosDisponibles = true;
          }
        });

        // Si no hay más productos disponibles en ninguna categoría, salir del bucle
        if (!productosDisponibles) {
          break;
        }
      }

      agregarProductosAlContenedor(productosDestacados);

      infiniteScroll(productosDestacados);

    }
  });
}