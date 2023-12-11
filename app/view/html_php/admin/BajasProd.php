<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FluffyHugs | Admin > Bajas</title>
  <!-- Boostrap v4.6.2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- agregando link para darle estilos a la alerta -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- CSS -->
  <link rel="stylesheet" href="../../css/main.css" />
  <link rel="stylesheet" href="../../css/TablasAdm.css">
  <!-- favIcon -->
  <link rel="icon" type="image/x-icon" href="../../../media/images/oso-de-peluche.png" />
</head>

<body>
  <?php require_once '../navbar.php'; ?>
  <div class="container d-flex justify-content-center mt-5">
    <table class="table  table-striped table-hover tableF">
      <thead>
        <tr>
          <th scope="col" class="titulo">ID</th>
          <th scope="col" class="titulo">Categoria</th>
          <th scope="col" class="titulo">Nombre</th>
          <th scope="col" class="titulo">Descripcion</th>
          <th scope="col" class="titulo">Imagen</th>
          <th scope="col" class="titulo">Stock</th>
          <th scope="col" class="titulo">Precio</th>
          <th scope="col" class="titulo">Descuento</th>
          <th scope="col" class="titulo">Acciones</th>
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
      // Realiza la solicitud AJAX para obtener la información del producto
      $.ajax({
        type: "POST",
        url: "../../../model/DB/manejoProductos.php",
        data: {
          method: "getProduct",
          id: id
        },
        success: function(response) {
          var producto = JSON.parse(response); // Obteniendo información del producto
          var prodImg = producto.prod_imgPath.split("/");
          prodImg = prodImg[prodImg.length - 1];
          var url = "../../../media/images/productos/" + prodImg;
          //crear un elemento temporar tipo img para verificar si la imagen existe
          var img = $("<img src='" + url + "' alt='" + prodImg + "' width='100px'>");
          img.on("error", function() {
            url = "../../../media/images/imgRelleno.png";
          });
          // destruir el elemento temporal
          img.remove();
          // Construye el contenido del modal con los datos del producto
          var modalContent = `
            <div class="container">
              <div class="row">
                <div class="col-md-6">
                  <h5>${producto.prod_name}</h5>
                  <img src="${url}" alt="${producto.prod_imgPath}" class="img-fluid" style="max-width: 100%;">
                </div>
                <div class="col-md-6">
                  <h5>ID: ${id}</h5>
                  <p>Categoría: ${producto.categoria}</p>
                  <p>Descripción: ${producto.prod_description}</p>
                  <p>Stock: ${producto.prod_stock}</p>
                  <p>Precio: ${producto.prod_precio}</p>
                  <p>Descuento: ${producto.prod_descuento}</p>
                </div>
              </div>
            </div>
          `;

          // Muestra el modal de confirmación
          Swal.fire({
            title: "¿Estás seguro?",
            html: modalContent,
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
        },
        error: function(xhr, status, error) {
          console.error("Error en la solicitud AJAX:", status, error);
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
          old_productos = productos;
          rellenarTabla(productos);
        }
      });
      setTimeout(updateTable, 500); // Actualizar cada 500ms
    }

    // Función para comparar dos objetos
    function isEqual(obj1, obj2) {
      return JSON.stringify(obj1) === JSON.stringify(obj2);
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
        var prodImg = producto.prod_imgPath;
        console.log(prodImg);
        var url = "../../../media/images/productos/" + prodImg;
        var img = $("<img src='" + url + "' alt='" + prodImg + "' width='100px'>");
        img.on("error", function() {
          $(this).attr("src", "../../../media/images/imgRelleno.png");
        });
        tr.append("<td></td>").children().last().append(img);
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