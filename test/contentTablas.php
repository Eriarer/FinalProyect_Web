<?php
include_once __DIR__ . '/../app/model/DB/dataBaseCredentials.php';
include_once __DIR__ . '/../app/model/routes_files.php';
include_once __DIR__ . '/../app/model/DB/controllDB.php';

$conn = new mysqli(
    $credentials['host'],
    $credentials['user'],
    $credentials['pass'],
    $credentials['db']
);
//mostrar el contedido de la tabla productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
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
    echo "</tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $key => $value) {
            echo "<td>" . $value . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

echo "<br>";

//mostrar el contedido de la tabla de usuarios
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>";
    echo "<th>id</th>";
    echo "<th>email</th>";
    echo "<th>nombre</th>";
    echo "<th>cuenta</th>";
    echo "<th>intentos</th>";
    echo "<th>password</th>";
    echo "<th>admin</th>";
    echo "<th>NEWFLUFFY15</th>";
    echo "<th>FLUFFY10</th>";
    echo "<th>FLUFFY5</th>";
    echo "</tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $key => $value) {
            echo "<td>" . $value . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

echo "<br>";

$sql = "SELECT * FROM preguntas_seguridad";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>";
    echo "<th>id</th>";
    echo "<th>pregunta</th>";
    echo "<th>respuesta</th>";
    echo "</tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $key => $value) {
            echo "<td>" . $value . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}


?>

<!-- //Mostrar la tabla de carrito -->
<?php
$sql = "SELECT * FROM carrito";
$result = $conn->query($sql);
echo "<br>";
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>";
    echo "<th>ID usuario</th>";
    echo "<th>ID Producto</th>";
    echo "<th>Cantidad</th>";
    echo "</tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $key => $value) {
            echo "<td>" . $value . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Sin productos en el carrito";
}

?>

<style>
    table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #101010;
    }

    th,
    td {
        text-align: left;
        padding: 8px;
        border: 1px solid #101010;
    }

    tr {
        border: 1px solid #101010;
        background-color: #cccccc;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>