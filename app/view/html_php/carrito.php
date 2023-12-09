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
  <link rel="stylesheet" href="../css/main.css" />
  <link rel="stylesheet" href="../css/carrito.css">
  <!-- favIcon -->
  <link rel="icon" type="image/x-icon" href="../../../media/images/oso-de-peluche.png" />
</head>

<body>
  <?php require_once 'navbar.php'; ?>
  <div class="container mb-5">
    <div class="container d-flex justify-content-center mt-5">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">Producto</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Descripción</th>
            <th scope="col">Precio unitario</th>
            <th scope="col">Ahorra</th>
            <th scope="col">Precio total</th>
            <th scope="col">Acción</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>

    </div>
    <p>Subtotal:</p>
    <!-- Boton con enlace a la página de compra -->
    <div class="container d-flex justify-content-center">
      <a href="compra.php" class="btn btn-primary">Comprar</a>
    </div>
  </div>
  <?php require_once 'footer.php'; ?>
  <script>
    /**
     * Funcion para actualizar la tabla de productos
     */
    $(document).ready(function() {
      $.ajax({
        type: "POST",
        url: "../../model/DB/manejoCarrito.php",
        data: {
          method: "getCarrito",
        },
        success: function(responce) {
          if (responce != null) {
            responce = JSON.parse(responce);
            var total = 0;
            var html = '';
            var url = "../../media/images/productos/";
            // crear una fila por cada producto con sus respectivos datos
            var tbody = $("tbody");
            tbody.empty();
            for (var i = 0; i < responce.length; i++) {
              var span = '';
              var producto = responce[i];
              console.log(producto);
              var tr = $("<tr></tr>");
              var cant_edit = '';
              var ahorro = (producto.prod_descuento / 100) * producto.prod_precio * producto.cantidad;
              var total = producto.prod_precio * producto.cantidad;
              var cant_edit = '<input id="changeCant' + producto.prod_id + '" type="number" value="' + producto.cantidad + '" min="1" max="' + producto.prod_stock + '" onchange="losefocus(' + producto.prod_id + ',this.value)">';
              if (ahorro > 0) {
                span = '<br><span style="text-decoration: line-through; color: gray; font-size: 90%;">$' + total + '</span>';
              }
              tr.addClass("text-center");
              html = '<td>' + "<img src='" + url + producto.prod_imgPath + "' alt='" + producto.prod_name + "' width='100px' onerror=\"this.onerror=null;this.src='" + "../../media/images/imgRelleno.png" + "'\">" +
                '<br>' + producto.prod_name + '</td>';
              // html += '<td>' + producto.cantidad + '</td>';
              html += '<td>' + cant_edit + '</td>';
              html += '<td>' + producto.prod_description + '</td>';
              html += '<td>$' + producto.prod_precio + '</td>';
              html += '<td>$' + ahorro + '</td>';
              html += '<td>$' + (total - ahorro) + span + '</td>';
              html += '<td><button class="btn btn-danger" onclick="eliminarProducto(' + producto.prod_id + ')">Descartar</button></td>';
              tr.html(html);
              tbody.append(tr);

            }
          }
        },
        error: function() {
          console.log("No se ha podido obtener la información");
        }
      });
    });

    function losefocus(id, value) {
      if (value <= 0) {
        $("#changeCant" + id).val(1);
        value = 1;
      }

      obtenerStock(id) //para hacer la promesa y que se ejecute el codigo de abajo hasta que se resuelva la promesa
        .then(function(stock) {
          if (value > stock) {
            value = stock;
            $("#changeCant" + id).val(value);
          }

          return $.ajax({
            type: "POST",
            url: "../../model/DB/manejoCarrito.php",
            data: {
              method: "updateCantidad",
              cantidad: value,
              prod_id: id,
            },
          });
        })
        .then(function(response) {
          response = JSON.parse(response);
          $("#num_prod").text(response);
          console.log("perdio el FOCUS SUCCESS");
        })
        .catch(function(error) {
          console.error('Error:', error);
        });
    }

    function obtenerStock(id) {
      return new Promise(function(resolve, reject) {
        $.ajax({
          type: "POST",
          url: "../../model/DB/manejoCarrito.php",
          data: {
            method: "getStock",
            prod_id: id,
          },
          success: function(response) {
            response = JSON.parse(response);
            resolve(response);
          },
          error: function(error) {
            console.error('Error al obtener la información del carrito:', error);
            reject(error);
          }
        });
      });
    }

    

    function eliminarProducto(id) {
      // Realiza la solicitud AJAX para eliminar el producto
      $.ajax({
        type: "POST",
        url: "../../model/DB/manejoCarrito.php",
        data: {
          method: "delete",
          prod_id: id
        },
        success: function(response) {
          Swal.fire({
            title: "Producto eliminado",
            text: "El artículo ha sido eliminado correctamente",
            icon: "success"
          });
        },
        error: function(xhr, status, error) {
          Swal.fire({
            title: "Error",
            text: "Ha ocurrido un error al eliminar el producto",
            icon: "error"
          });
        }
      });
    }
  </script>

</body>

</html>