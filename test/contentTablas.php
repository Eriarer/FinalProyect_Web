<?php
$credntials = array(
    'host' => '162.241.62.48',
    'user' => 'gbfrallc_admin',
    'pass' => 'losmejorespeluches:3',
    'db' => 'gbfrallc_fluffyhugs'
);

$conn = new mysqli(
    $credntials['host'],
    $credntials['user'],
    $credntials['pass'],
    $credntials['db']
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