<?php
session_start();
$lastUpdateDate = filemtime(__FILE__);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FluffyHugs | Admin > Altas </title>
  <!-- Boostrap v4.6.% -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- agregando link para darle estilos a la alerta -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- CSS -->
  <link rel="stylesheet" href="../../css/main.css" />
  <link rel="stylesheet" href="../../css/formularios.css">
  <!-- favIcon -->
  <link rel="icon" type="image/x-icon" href="../../../media/images/oso-de-peluche.png" />
</head>

<body>
  <?php
  include_once __DIR__ . '/../../../model/DB/dataBaseCredentials.php';
  include_once __DIR__ . '/../../../model/routes_files.php';
  include_once __DIR__ . '/../../../model/DB/controllDB.php';


  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoria = $_POST['categoria'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $stock = $_POST['stock'];
    $precio = $_POST['precio'];
    $descuento = $_POST['descuento'];
    $imagen = $_FILES["imagen"]["name"];

    $db = new dataBase($credentials, $CONFIG);
    //obtener el ultimo id de la tabla productos
    $id = $db->getLastProductId() + 1;
    //              ruta            nombra       extension
    $Archivo = $id . "." . pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
    $base = '../../../media/images/productos/';
    // guardar la imagen en la ruta del servidor
    move_uploaded_file($_FILES["imagen"]["tmp_name"], $base . $Archivo);

    $respose = $db->altaProducto($categoria, $nombre, $descripcion, $Archivo, $stock, $precio, $descuento);

    if ($respose) {
      echo "<script>
      Swal.fire({
        icon: 'success',
        title: 'Producto agregado',
      });
      </script>";
    } else {
      echo "<script>
      Swal.fire({
        icon: 'error',
        title: 'Error al agregar el producto',
      });
      </script>";
    }
  }
  ?>
  <?php require_once '../navbar.php'; ?>
  <!-- Tarjeta de Alta de productos -->
  <div class="container mt-5">
    <div class="card-container">
      <div class="card text-center" id="altProd">
        <div class="card-body">
          <h5 class="card-title">Alta de producto</h5>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method='post' enctype="multipart/form-data">
            <div class="form-group mt-1 row">
              <div class="form-group mt-3 col-md-6 text-left">
                <label for="nombre">Nombre del producto</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
              </div>
              <div class="form-group mt-2 col-md-6 text-left">
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
              <div class="form-group mt-3 col-md-4 text-left">
                <label for="stock">Existencias #</label>
                <input type="number" class="form-control" id="stock" name="stock" required>
              </div>
              <div class="form-group mt-3 col-md-4 text-left">
                <label for="precio">Precio $</label>
                <input type="number" class="form-control" id="precio" name="precio" required>
              </div>
              <div class="form-group mt-3 col-md-4 text-left">
                <label for="descuento">Descuento %</label>
                <input type="number" class="form-control" id="descuento" name="descuento" required>
              </div>
            </div>
            <div class="row row-cols-2">
              <div class="form-col-1">
                <div class="form-group col-md-6 text-left mt-4">
                  <label for="imagen">Imagen del producto</label>
                  <input type="file" class="form-control-file" id="imagen" name="imagen" accept=".jpg, .jpeg, .png, .webp, .svg, .webm" required>
                  <!-- Agrega el elemento img para mostrar la vista previa -->
                  <img id="imagenPreview" src="../../../media/images/imgRelleno.png" alt="Vista previa de la imagen" style="max-width: 100%; max-height: 200px; margin-top: 10px;">
                </div>
              </div>
              <div class="form-group form-col-1 mt-3 text-left">
                <label for="descripcion">Descripción</label><br>
                <textarea name="descripcion" id="descripcion" class="form-control" cols="30" rows="10" required></textarea>
              </div>
            </div>
            <br>
            <button class="boton" type="submit" name="submit">Aceptar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php require_once '../footer.php'; ?>
  <script>
    $(document).ready(function() {
      // Llama a la función para mostrar la vista previa de la imagen por defecto
      mostrarVistaPrevia();

      // Asigna el evento change al input de imagen
      $("#imagen").change(function() {
        // Llama a la función para mostrar la vista previa
        mostrarVistaPrevia(this);
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

      // Asigna el evento submit al formulario
      $("#altaProductoForm").submit(function(e) {
        e.preventDefault(); // Evita la recarga de la página por defecto
        // Realiza la solicitud Ajax
        $.ajax({
          url: $(this).attr('action'),
          type: $(this).attr('method'),
          data: new FormData(this),
          processData: false,
          contentType: false,
          success: function(data) {
            // Maneja la respuesta del servidor (puede ser un mensaje de éxito o error)
            $("#respuestaServidor").html(data);
            // Oculta la vista previa después de enviar el formulario
            $("#imagenPreview").hide();
          }
        });
      });
    });
  </script>
</body>

</html>