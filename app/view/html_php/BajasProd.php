<?php
include_once __DIR__ . '/../../model/DB/dataBaseCredentials.php';
include_once __DIR__ . '/../../model/routes_files.php';
include_once __DIR__ . '/../../model/DB/controllDB.php';

$db = new dataBase($credentials, $CONFIG);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST['id'];

  $db = new dataBase($credentials, $CONFIG);
  $response = $db->bajaProducto($id);

  if ($response) {
    echo "success";
  } else {
    echo "error";
  }
}

// Estructura de la tabla productos:

// Field Type Null Key Default Extra
// prod_id int(6) NO PRI auto_increment
// categoria varchar(255) YES
// prod_name varchar(255) NO
// prod_description text YES
// prod_imgPath varchar(255) NO
// prod_stock int(11) NO
// prod_precio float NO
// prod_descuento float NO

?>

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
  <!-- Estilos -->
  <link rel="stylesheet" href="../css/bajasEstilos.css">
</head>

<body>
  <?php require_once 'navbar.php'; ?>
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
        <?php
        $db = new dataBase($credentials, $CONFIG);
        // Mostrar el contenido de la tabla productos
        $result = json_decode($db->getAllProducts(), true);

        if (!empty($result)) {
          foreach ($result as $row) {
            echo "<tr class='text-center'>";
            echo "  <th>" . $row['prod_id'] . "</th>";
            echo "  <td>" . $row['categoria'] . "</td>";
            echo "  <td>" . $row['prod_name'] . "</td>";
            echo "  <td>" . $row['prod_description'] . "</td>";
            // mostrar imagen
            $imgName = explode("/", $row['prod_imgPath'])[count(explode("/", $row['prod_imgPath'])) - 1];
            $img = "<img src='" . $row['prod_imgPath'] . "' alt='" . $imgName . "' width='100px'>";
            echo "  <td>" . $img . "</td>";
            echo "  <td>" . $row['prod_stock'] . "</td>";
            echo "  <td>" . $row['prod_precio'] . "</td>";
            echo "  <td>" . $row['prod_descuento'] . "</td>";
            // Añadir botón de eliminación
            echo "  <td><button class='btn btn-danger' onclick='eliminarProducto(" . $row['prod_id'] . ")'>Eliminar</button></td>";
            echo "</tr>";
          }
        } else {
          echo "<tr>";
          echo "  <td colspan='9'>No hay productos registrados</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
  <?php require_once 'footer.php'; ?>
  <script>
    $(document).ready(function() {

      resizeTable();
      $(window).on("resize", function() {
        resizeTable();
      });
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

    function eliminarProducto(id) {
      Swal.fire({
        title: "¿Estas seguro?",
        text: "El producto con id " + id + " será eliminado permanentemente",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Borrar",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {
          // Realiza la solicitud AJAX para eliminar el producto
          $.ajax({
            type: "POST",
            url: "eliminar_producto.php",
            data: {
              id: id
            },
            success: function(response) {
              if (response == "success") {
                Swal.fire({
                  title: "Producto eliminado",
                  text: "El artículo ha sido eliminado correctamente",
                  icon: "success"
                }).then((result) => {
                  location.reload();
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
      });
    }
  </script>
</body>

</html>