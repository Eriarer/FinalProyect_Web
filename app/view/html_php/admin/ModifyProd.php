<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Productos</title>
  <!-- Boostrap v4.6.2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- agregando link para darle estilos a la alerta -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
  /*Estilos del modal */
  .mymodal {
    position: fixed;
    ;
    /* centrar el modal */
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    overflow: auto;
    /* agrega barra desplaza si el contenido es mayor al alto del modal */
    outline: 0;
    background: gainsboro;
    border-radius: 10px;
  }
</style>

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
        <!-- LLENADO EN JS -->
      </tbody>
    </table>
  </div>
  <!-- Modal personalizado -->

  <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <!-- Contenido del Modal -->
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modificar Producto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card" id="altProd">
            <div class="card-body">
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method='post' enctype="multipart/form-data">
                <div class="form-group mt-1 row">
                  <div class="form-group mt-3 col-md-6">
                    <label for="nombre">Nombre del producto</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                  </div>
                  <div class="form-group mt-2 col-md-6">
                    <label for="categoria">Categoría</label>
                    <select class="form-control" id="categoria" name="categoria" required>
                      <optgroup class="categoria">
                        <option selected="selected">Por ocasiones</option>
                        <option>Ediciones Especiales</option>
                      </optgroup>
                    </select>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group mt-3 col-md-4">
                    <label for="stock">Existencias #</label>
                    <input type="number" class="form-control" id="stock" name="stock" required>
                  </div>
                  <div class="form-group mt-3 col-md-4">
                    <label for="precio">Precio $</label>
                    <input type="number" class="form-control" id="precio" name="precio" required>
                  </div>
                  <div class="form-group mt-3 col-md-4">
                    <label for="descuento">Descuento %</label>
                    <input type="number" class="form-control" id="descuento" name="descuento" required>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6 mt-3">
                    <label for="imagen">Imagen del producto</label>
                    <input type="file" class="form-control-file" id="imagen" name="imagen" accept=".jpg, .jpeg, .png, .webp, .svg, .webm" required>
                    <!-- Agrega el elemento img para mostrar la vista previa -->
                    <img id="imagenPreview" src="../../../media/images/imgRelleno.png" alt="Vista previa de la imagen" class="img-fluid" style="max-width: 200px; margin-top: 10px;">
                  </div>
                  <div class="form-group col-md-6 mt-3">
                    <label for="descripcion">Descripción</label><br>
                    <textarea name="descripcion" id="descripcion" class="form-control" cols="30" rows="10" required></textarea>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success" name="submit">Aceptar</button>
        </div>
      </div>
    </div>
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

      // Asigna el evento change al input de imagen
      $("#imagen").change(function() {
        // Llama a la función para mostrar la vista previa
        mostrarVistaPrevia(this);
      });
    });

    // Función para mostrar la vista previa de la imagen
    function mostrarVistaPrevia(input) {
      if (input && input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          // Muestra la vista previa de la imagen
          $("#imagenPreview").attr("src", e.target.result).show();
        };

        reader.readAsDataURL(input.files[0]);
      }
    }

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

    function updateModal(id) {
      //obtener el js de los datos del producto
      $.ajax({
        type: "POST",
        url: "../../../model/DB/manejoProductos.php",
        data: {
          method: "getAllProducts"
        },
        success: function(response) {
          var productos = JSON.parse(response);
          for (var i = 0; i < productos.length; i++) {
            var producto = productos[i];
            if (producto.prod_id == id) {
              $("#nombre").val(producto.prod_name);
              $("#categoria").val(producto.categoria);
              $("#stock").val(producto.prod_stock);
              $("#precio").val(producto.prod_precio);
              $("#descuento").val(producto.prod_descuento);
              $("#descripcion").val(producto.prod_description);
              // la ruta de la imagen se guarda en la base de datos va a ser local, por lo que se debe agregar el path de la carpeta
              // cortar la ruta de la imagen '/' y obtener el ultimo elemento
              var prodImg = producto.prod_imgPath.split("/");
              prodImg = prodImg[prodImg.length - 1];
              var url = "../../../media/images/productos/" + prodImg;
              $("#imagenPreview").attr("src", url);
              $("#imagen").val("");
              $("#imagen").removeAttr("required");
              // ajustar el boton de aceptar para que llame a la funcion de modificar 
              $(".btn-success").attr("onclick", "modificarProducto(" + id + ")");
              break;
            }
          }
        },
        error: function(xhr, status, error) {
          console.error("Error en la solicitud AJAX:", status, error);
        }
      });
    }

    function modificarProducto(id) {
      //obtener los datos del producto
      var nombre = $("#nombre").val();
      var categoria = $("#categoria").val();
      var stock = $("#stock").val();
      var precio = $("#precio").val();
      var descuento = $("#descuento").val();
      var descripcion = $("#descripcion").val();
      var imagen = $("#imagen")[0].files[0];
      //realizar la solicitud AJAX
      $.ajax({
        type: "POST",
        url: "../../../model/DB/manejoProductos.php",
        data: {
          method: "modifyProduct",
          id: id,
          categoria: categoria,
          nombre: nombre,
          descripcion: descripcion,
          stock: stock,
          precio: precio,
          descuento: descuento,
          imagen: imagen
        },
        processData: false,
        contentType: false,
        success: function(response) {
          if (response == "success") {
            Swal.fire({
              title: "Producto modificado",
              text: "El artículo ha sido modificado correctamente",
              icon: "success"
            });
          } else {
            Swal.fire({
              title: "Error",
              text: "Ha ocurrido un error al modificar el producto",
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
          old_productos = productos;
          rellenarTabla(productos);
        }
      });
      setTimeout(updateTable, 500); // Actualizar cada 500ms
    }

    function isEqual(a, b) {
      // Función para comparar dos objetos
      function isEqual(obj1, obj2) {
        // verificar que la diferencia no sea solo por que no se pueden encontrar 
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
        var prodImg = producto.prod_imgPath.split("/");
        prodImg = prodImg[prodImg.length - 1];
        var url = "../../../media/images/productos/" + prodImg;
        tr.append("<td><img src='" + url + "' alt='" + prodImg + "' width='100px'></td>");
        tr.append("<td>" + producto.prod_stock + "</td>");
        tr.append("<td>" + producto.prod_precio + "</td>");
        tr.append("<td>" + producto.prod_descuento + "</td>");
        tr.append("<td><button class='btn btn-primary' onclick='updateModal(" + producto.prod_id + ")' data-toggle='modal' data-target='#myModal'>MODIFICAR</button></td>");
        tbody.append(tr);
      }
    }
  </script>
</body>

</html>