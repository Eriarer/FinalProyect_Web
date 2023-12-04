<?php
include_once __DIR__ . '/../app/model/dataBaseCredentials.php';
include_once __DIR__ . '/../app/model/routes_files.php';
include_once __DIR__ . '/../app/model/controllDB.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoria = $_POST['categoria'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $stock = $_POST['stock'];
    $precio = $_POST['precio'];
    $descuento = $_POST['descuento'];
    $imagen = $_FILES["imagen"]["name"];
    // guardar la imagen en el servidor
    $direccion = __DIR__ . '/../app/media/images/productos/';

    $db = new dataBase($credentials, $CONFIG);
    //obtener el ultimo id de la tabla productos
    $id = $db->getLastProductId() + 1;
    //              ruta            nombra       extension
    $Archivo = $direccion . $id . "." . pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
    // guardar la imagen en la ruta del servidor
    move_uploaded_file($_FILES["imagen"]["tmp_name"], $Archivo);

    $respose = $db->altaProducto($categoria, $nombre, $descripcion, $Archivo, $stock, $precio, $descuento);

    if ($respose) {
        echo "<h1>Producto registrado correctamente</h1>";
    } else {
        echo "<h1>Producto no registrado</h1>";
    }
    // usar el destructor para cerrar la conexion
    //$db->__destruct();
    // eliminar el metodo POST
    unset($_POST);
}

/*
Estructura de la tabla productos:

Field	            Type	         Null	  Key    Default Extra
prod_id	            int(6)	          NO	  PRI	          auto_increment
categoria	        varchar(255)	  YES			
prod_name	        varchar(255)	  NO			
prod_description    text	          YES			
prod_imgPath	    varchar(255)	  NO			
prod_stock	        int(11)           NO			
prod_precio	        float	          NO			
prod_descuento	    float	          NO	
*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Document</title>
    <style>
        td,
        th {
            padding: 10px;

        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-4">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method='post' enctype="multipart/form-data">
                    <h2>Registro de Productos</h2>
                    <div class="form-group">
                        <label for="id">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
                    </div>
                    <div class="form-group">
                        <label for="id">Categoria</label>
                        <input type="text" class="form-control" id="categoria" name="categoria" placeholder="Categoria">
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label><br>
                        <textarea name="descripcion" id="descripcion" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="imagen">Imagen</label>
                        <input type="file" class="form-control-file" id="imagen" name="imagen" placeholder="" accept=".jpg, .jpeg, .png, .webp, .svg, .webm">
                    </div>
                    <div class="form-group">
                        <label for="contra">Stock</label>
                        <input type="number" class="form-control" id="stok" name="stock" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="contra">Precio</label>
                        <input name="precio" class="form-control" id="precio" type="number" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="contra">Descuento</label>
                        <input type="number" class="form-control" id="descuento" name="descuento" placeholder="">
                    </div>
                    <button class="btn btn-success" type="submit" name="submit">Submit</button>
                </form>
            </div> <!-- fin col -->
        </div> <!-- fin row -->
    </div> <!-- fin container -->
    <br><br>
</body>

</html>