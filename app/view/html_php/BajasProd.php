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