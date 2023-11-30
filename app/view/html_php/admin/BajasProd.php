<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Baja Productos</title>
  <!-- Boostrap v4.6.2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- agregando link para darle estilos a la alerta -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <?php require_once '../navbar.php'; ?>
  <div class="container d-flex justify-content-center mt-5">
    <table class="table  table-striped table-hover">
      <thead>
        <tr>
          <th scope=" col">ID</th>
          <th scope="col">Categoria</th>
          <th scope="col">Nombre</th>
          <th scope="col">Descripcion</th>
          <th scope="col">Imagen</th>
          <th scope="col">Stock</th>
          <th scope="col">Precio</th>
          <th scope="col">Descuento</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
  </div>
  <?php require_once '../footer.php'; ?>
  <script>
    var old_productos = null;
    $(document).ready(function() {
      resizeTable();

      $(window).on("resize", function() {
        resizeTable();
      });

      updateTable();
    });

    /**
     * Comprueba si el ancho de la tabla es mayor al ancho de la ventana
     */
    function resizeTable() {
      if ($("table").width() > $(window).width()) {
        $("table").addClass("table-responsive");
      } else {
        $("table").removeClass("table-responsive");

        if ($("table").width() > $(window).width()) {
          $("table").addClass("table-responsive");
        }
      }
    }

    function confirmarEliminar(id) {
      Swal.fire({
        title: "¿Estás seguro?",
        text: "El producto con id " + id + " será eliminado permanentemente",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Borrar",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {
          eliminarProducto(id);
        }
      });
    }

    function eliminarProducto(id) {
      // Realiza la solicitud AJAX para eliminar el producto
      $.ajax({
        type: "POST",
        url: "../../../model/DB/manejoProductos.php",
        data: {
          method: "delete",
          id: id
        },
        success: function(response) {
          if (response == "success") {
            Swal.fire({
              title: "Producto eliminado",
              text: "El artículo ha sido eliminado correctamente",
              icon: "success"
            });
          } else {
            Swal.fire({
              title: "Error",
              text: "Ha ocurrido un error al eliminar el producto",
              icon: "error"
            });
          }
        }
      });
    }

    function updateTable() {
      // Uso de la función con un callback
      obtenerTablaProductos(function(productos) {
        if (!isEqual(old_productos, productos)) {
          console.log("Actualizando tabla");
          old_productos = productos;
          rellenarTabla(productos);
        }
      });
      setTimeout(updateTable, 500); // Actualizar cada 500ms
    }

    function isEqual(a, b) {
      // Función para comparar dos objetos
      function isEqual(obj1, obj2) {
        return JSON.stringify(obj1) === JSON.stringify(obj2);
      }
    }

    function obtenerTablaProductos(callback) {
      $.ajax({
        type: "POST",
        url: "../../../model/DB/manejoProductos.php",
        data: {
          method: "getAllProducts"
        },
        success: function(response) {
          // Eliminar cualquier texto al inicio que diga 'string(*) '
          var productos = JSON.parse(response);
          callback(productos);
        },
        error: function(xhr, status, error) {
          console.error("Error en la solicitud AJAX:", status, error);
          callback(null);
        }
      });
    }

    function rellenarTabla(productos) {
      if (productos == null) {
        return;
      }
      // crear una fila por cada producto con sus respectivos datos
      var tbody = $("tbody");
      tbody.empty();
      for (var i = 0; i < productos.length; i++) {
        var producto = productos[i];
        var tr = $("<tr></tr>");
        tr.addClass("text-center");
        tr.append("<th>" + producto.prod_id + "</th>");
        tr.append("<td>" + producto.categoria + "</td>");
        tr.append("<td>" + producto.prod_name + "</td>");
        tr.append("<td>" + producto.prod_description + "</td>");
        // la ruta de la imagen se guarda en la base de datos va a ser local, por lo que se debe agregar el path de la carpeta
        // cortar la ruta de la imagen '/' y obtener el ultimo elemento
        console.log(producto.prod_imgPath);
        var prodImg = producto.prod_imgPath.split("/");
        prodImg = prodImg[prodImg.length - 1];
        var url = "../../../media/images/productos/" + prodImg;
        console.log(url);
        tr.append("<td><img src='" + url + "' alt='" + prodImg + "' width='100px'></td>");
        tr.append("<td>" + producto.prod_stock + "</td>");
        tr.append("<td>" + producto.prod_precio + "</td>");
        tr.append("<td>" + producto.prod_descuento + "</td>");
        tr.append("<td><button class='btn btn-danger' onclick='confirmarEliminar(" + producto.prod_id + ")'>Eliminar</button></td>");
        tbody.append(tr);
      }
    }
  </script>
</body>

</html>