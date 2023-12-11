<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Boostrap v4.6.2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- agregando link para darle estilos a la alerta -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- css -->
  <link href="form-validation.css" rel="stylesheet">
  <link href="../../css/main.css" rel="stylesheet">
  <!-- favIcon -->
  <link rel="icon" type="image/x-icon" href="../../../media/images/oso-de-peluche.png" />
</head>

<body>
  <?php include_once '../navbar.php'; ?>
  <div class="container my-3">
    <div class="row">
      <div class="col-md-4 order-md-2 mb-4">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-muted">Carrito</span>
        </h4>
        <!-- CARRITO PAGO -->
        <ul class="list-group mb-3" id="carritoList">
        </ul>
        <!--FIN CARRITO PAGO-->

        <form class="card p-2">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Código promocional">
            <div class="input-group-append">
              <button type="submit" class="btn btn-secondary">Usar</button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-md-8 order-md-1">
        <h4 class="mb-3">Datos de envio</h4>
        <form class="needs-validation" novalidate>

          <div class="mb-3">
            <label for="name">Nombre completo (nombre y apellido)</label>
            <input type="text" class="form-control" id="name" placeholder="" value="" required>
            <div class="invalid-feedback">
              Se requiere un nombre válido.
            </div>
          </div>
          <div class="mb-3">
            <!-- numero telefonico -->
            <label for="phone">Número de teléfono</label>
            <input type="tel" class="form-control" id="phone" placeholder="" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required>
          </div>

          <div class="mb-3">
            <label for="address">Calle y número</label>
            <input type="text" class="form-control" id="address" placeholder="Calle, número ext. e int" required>
            <div class="invalid-feedback">
              Favor de ingresar una direccion
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 mb-3">
              <label for="country">País o región</label>
              <select class="custom-select d-block w-100" id="country" required>
                <option>Mexico</option>
                <option>Estados Unidos</option>
              </select>
              <div class="invalid-feedback">
                Favor de elegir una opcion
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <label for="city">Ciudad</label>
              <input type="text" class="form-control" id="city" name="ciudad" required>
            </div>

            <div class="col-md-4 mb-3">
              <label for="zip">Codigo Postal</label>
              <input type="text" class="form-control" id="zip" placeholder="00000" minlength="5" maxlength="10" required>
              <div class="invalid-feedback">
                Se requiere un codigo postal valido
              </div>
            </div>
          </div>
          <hr class="mb-4">

          <h4 class="mb-3">Formas de pago</h4>
          <div class="d-block my-3">
            <div class="custom-control custom-radio">
              <input type="radio" id="credit" name="paymentMethod" class="custom-control-input" checked required>
              <label class="custom-control-label" for="credit">Pago con tarjeta</label>
            </div>
            <div class="custom-control custom-radio">
              <input type="radio" id="oxxo" name="paymentMethod" class="custom-control-input" required>
              <label class="custom-control-label" for="oxxo">Pago en OXXO</label>
            </div>
          </div>

          <div class="row cc-container">
            <div class="col-md-6 mb-3">
              <label for="cc-name">Nombre en la tarjeta</label>
              <input type="text" class="form-control" id="cc-name" placeholder="Nombre completo" required>
              <div class="invalid-feedback">
                Se requiere el nombre en la tarjeta
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="cc-number">Numero de tarjeta:</label>
              <input type="text" class="form-control" id="cc-number" placeholder="" pattern="^[0-9]{16}$" minlength="16" maxlength="16" required>
              <div class="invalid-feedback">
                Se requiere un numero de tarjeta valido
              </div>
            </div>
          </div>
          <div class="row cc-container">
            <div class="col-md-5 mb-3">
              <label for="cc-expiration">Fecha de vencimiento: </label>
              <!-- habilitar autoCompletado -->
              <input type="month" class="form-control" id="cc-expiration" min="2023-12" max="2043-12" required>
              <div class="invalid-feedback">
                Se requiere la fecha de vencimiento
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="cc-cvv">CVV</label>
              <input type="text" class="form-control" id="cc-cvv" placeholder="***" pattern="^[0-9]{3,4}$" minlength="3" maxlength="4" required>
              <div class="invalid-feedback">
                Se requiere código de seguridad
              </div>
            </div>
          </div>
          <hr class="mb-4">
          <button class="btn btn-primary btn-lg btn-block" type="submit">Finalizar compra</button>
        </form>
      </div>
    </div>
  </div>
  </div>
  <?php include_once '../footer.php'; ?>

  <script src="form-validation.js"></script>

  <script>
    const cupones = {
      "NEWFLUFFY15": 0.15,
      "FLUFFY10": 0.10,
      "FLUFFY5": 0.05
    }
    /**
     * Funcion para actualizar la tabla de productos
     */
    $(document).ready(function() {
      createTable();
      toggleMetodoPago();
    });

    function toggleMetodoPago() {
      $("#oxxo").click(function() {
        $(".cc-container").hide('slow');
      });
      $("#credit").click(function() {
        $(".cc-container").show('slow');
      });
    }

    function createTable() {
      $.ajax({
        type: "POST",
        url: "../../../model/DB/manejoCarrito.php",
        data: {
          method: "getCarrito",
        },
        success: function(responce) {
          if (responce == null || responce == "" || responce == "[]") {
            return;
          }
          responce = JSON.parse(responce);
          console.log(responce);
          var canttotal = 0;
          var html = '';
          var url = "../../media/images/productos/";
          // crear una fila por cada producto con sus respectivos datos
          var ul = $("#carritoList");
          ul.empty();

          // Agregar los productos del carrito 
          var totcarrito = appendProductos(responce);

          var descuento = (totcarrito * 0.1);
          totcarrito = totcarrito - descuento;
          //Actualizando el código html del carrito
          var code = $('<li class="list-group-item d-flex justify-content-between bg-light"></li>');
          html = '<div class="text-success">';
          html += '<h6 class="my-0">Código promocional</h6>';
          html += '</div>';
          html += '<span class="text-success">-' + descuento + '</span>';
          code.html(html);
          ul.append(code);

          //Agregando costo de envio, para México es de 200 pesos y para Estados Unidos es de 500 pesos
          appendCostoEnvio();

          // Actualizar el total del carrito
          var li = $('<li class="list-group-item d-flex justify-content-between"></li>');
          html = '<span>Total (MXN)</span>';
          html += '<strong id="total_carrito">$' + totcarrito + '</strong>';
          li.html(html);
          ul.append(li);
          updateTotalCostoEnvio(200, 0);
        },
        error: function() {
          console.log("No se ha podido obtener la información");
        }
      });
    }

    function appendProductos(responce) {
      var ul = $("#carritoList");
      var totcarrito = 0;
      for (var i = 0; i < responce.length; i++) {
        producto = responce[i];
        var ahorro = (producto.prod_descuento / 100) * producto.prod_precio * producto.cantidad;
        var total_prod = (producto.prod_precio * producto.cantidad) - ahorro;
        totcarrito += total_prod;
        var canttotal = (canttotal + producto.cantidad);
        var li = $('<li class="list-group-item d-flex justify-content-between lh-condensed"></li>');
        html = '<div>';
        html += '<h6 class="my-0">' + producto.prod_name + '</h6>';
        html += '<small class="text-muted">' + 'Cantidad: ' + producto.cantidad + '</small>';
        html += '</div>';
        html += '<span class="text-muted">$' + total_prod + '</span>';
        li.html(html);
        ul.append(li);
      }
      return totcarrito;
    }

    function appendCostoEnvio() {
      var ul = $("#carritoList");
      var envio = 0;
      if ($("#country").val() == "Mexico") {
        envio = 200;
      } else {
        envio = 500;
      }
      var li = $('<li class="list-group-item d-flex justify-content-between"></li>');
      html = '<span>Costo de envio</span>';
      html += '<strong id="costo_envio">$' + envio + '</strong>';
      li.html(html);
      ul.append(li);
      // Agregar el listener para actualizar el costo de envio
      listenerUpdateCostoEnvio();
    }

    function listenerUpdateCostoEnvio() {
      $("#country").change(function() {
        var envio = 0;
        var lastEnvio = 0;
        if ($("#country").val() == "Mexico") {
          envio = 200;
          lastEnvio = 500;
        } else {
          envio = 500;
          lastEnvio = 200;
        }
        $("#costo_envio").html("$" + envio);
        updateTotalCostoEnvio(envio, lastEnvio);
      });
    }

    function updateTotalCostoEnvio(envio, lastEnvio) {
      //obtener el texto del total del carrito
      var total = $("#total_carrito").text();
      // Obtener solo el valor numerico (sin el signo de pesos)
      total = total.substring(1);
      // Convertir el valor a float
      total = parseFloat(total);
      // Actualizar el total del carrito
      total = total - lastEnvio + envio;

      $("#total_carrito").html("$" + total);
    }
    //Función cuando cabia de país actualizar
  </script>

</body>

</html>