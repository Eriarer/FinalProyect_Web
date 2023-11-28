<?php
include_once __DIR__ . '/../../model/dataBaseCredentials.php';
include_once __DIR__ . '/../../model/routes_files.php';
include_once __DIR__ . '/../../model/controllDB.php';

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
    <!-- Boostrap v4.6.% -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- agregando link para darle estilos a la alerta -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn-danger {
            margin: 2px;
        }
    </style>


</head>

<body>
    <script>
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
    <div class="container mt-5 ml-5">
        <div class="card-container">
            <?php
            $db = new dataBase($credentials, $CONFIG);
            // Mostrar el contenido de la tabla productos
            $result = json_decode($db->getAllProducts(), true);

            if (!empty($result)) {
                echo "<table>";
                echo "<tr>";
                echo "<th>id</th>";
                echo "<th>Categoria</th>";
                echo "<th>nombre</th>";
                echo "<th>descripcion</th>";
                echo "<th>imagen</th>";
                echo "<th>stock</th>";
                echo "<th>precio</th>";
                echo "<th>descuento</th>";
                echo "<th>Acciones</th>"; // Agregamos una columna para las acciones
                echo "</tr>";

                foreach ($result as $row) {
                    echo "<tr>";
                    foreach ($row as $key => $value) {
                        echo "<td>" . $value . "</td>";
                    }

                    // Añadir botón de eliminación
                    echo "<td><button class='btn btn-danger' onclick='eliminarProducto(" . $row['prod_id'] . ")'>Eliminar</button></td>";

                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "0 results";
            }
            ?>
        </div>
    </div>

</body>

</html>