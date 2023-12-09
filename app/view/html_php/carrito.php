<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FluffyHugs | Carrito</title>
  <!-- Boostrap v4.6.2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- agregando link para darle estilos a la alerta -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- CSS -->
  <!-- favIcon -->
  <link rel="icon" type="image/x-icon" href="../../../media/images/oso-de-peluche.png" />
</head>

<body>
  <?php require_once 'navbar.php'; ?>
  <div class="container d-flex justify-content-center mt-5">
    <table class="table  table-striped table-hover">
      <thead>
        <tr>
          <th scope=" col">Producto</th>
          <th scope="col">Cantidad</th>
          <th scope="col">Descripción</th>
          <th scope="col">Precio unitario</th>
          <th scope="col">Precio total</th>
          <th scope="col">Acción</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
  </div>
  <?php require_once 'footer.php'; ?>

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
     * Funcion para actualizar la tabla de productos
     */
    function updateTable() {
      $.ajax({
        type: "POST",
        url: "../../model/DB/manejoCarrito.php",
        data: {
          method: "getCarrito",
          prod_id: id,
        },
        success: function(responce) {
          if (responce != null) {
            var data = JSON.parse(responce);
            console.log(data);
            var total = 0;
            var html = '';
            for (var i = 0; i < data.length; i++) {
              var producto = data[i];
              total += producto.prod_precio * producto.cantidad;
              html += '<tr>';
              html += '<td>' + producto.prod_nombre + '</td>';
              html += '<td>' + producto.cantidad + '</td>';
              html += '<td>' + producto.prod_descripcion + '</td>';
              html += '<td>$' + producto.prod_precio + '</td>';
              html += '<td>$' + producto.prod_precio * producto.cantidad + '</td>';
              html += '<td><button class="btn btn-danger" onclick="eliminarProducto(' + producto.prod_id + ')">Eliminar</button></td>';
              html += '</tr>';
            }
            html += '<tr>';
            html += '<td></td>';
            html += '<td></td>';
            html += '<td></td>';
            html += '<td></td>';
            html += '<td>$' + total + '</td>';
            html += '<td><button class="btn btn-success" onclick="comprar()">Comprar</button></td>';
            html += '</tr>';
            $('tbody').html(html);
          }
        },
        error: function() {
          console.log("No se ha podido obtener la información");
        }
      });
    }

    function agregarAlCarrito(id) {
      $.ajax({
        type: "POST",
        url: "../../model/DB/manejoCarrito.php",
        data: {
          method: "addOne",
          prod_id: id,
        },
        success: function(response) {
          response = JSON.parse(response);
          console.log("Producto agregado al carrito");
          console.log(response);
          // Actualizar el número de productos en el carrito en la etiqueta span ID:num_prod
          $("#num_prod").text(response);
        },
        error: function(error) {
          console.error('Error al obtener la información del carrito:', error);
        }
      });
    }

    function eliminarProducto(id) {}
  </script>

</body>

</html>