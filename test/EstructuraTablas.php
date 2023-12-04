<?php
$credntials = array(
    'host' => '162.241.62.48',
    'user' => 'gbfrallc_admin',
    'pass' => 'losmejorespeluches:3',
    'db' => 'gbfrallc_fluffyhugs'
);

$conn = new mysqli($credntials['host'], $credntials['user'], $credntials['pass'], $credntials['db']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// mostrar la estructura de la tabla
$sql = "DESCRIBE productos";
$result = $conn->query($sql);

echo "<h1>Tabla productos</h1>";
if ($result->num_rows > 0) {
    echo "<table><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["Field"] . "</td><td>" . $row["Type"] . "</td><td>" . $row["Null"] . "</td><td>" . $row["Key"] . "</td><td>" . $row["Default"] . "</td><td>" . $row["Extra"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
echo "<br><br>";

echo "<h1>Tabla usuarios</h1>";
$sql = "DESCRIBE usuarios";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["Field"] . "</td><td>" . $row["Type"] . "</td><td>" . $row["Null"] . "</td><td>" . $row["Key"] . "</td><td>" . $row["Default"] . "</td><td>" . $row["Extra"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
echo "<br><br>";


echo "<h1>Tabla de pregutnas de seguridad</h1>";
$sql = "DESCRIBE preguntas_seguridad";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["Field"] . "</td><td>" . $row["Type"] . "</td><td>" . $row["Null"] . "</td><td>" . $row["Key"] . "</td><td>" . $row["Default"] . "</td><td>" . $row["Extra"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
echo "<br><br>";

echo "<h1>Tabla facturas</h1>";
$sql = "DESCRIBE facturas";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["Field"] . "</td><td>" . $row["Type"] . "</td><td>" . $row["Null"] . "</td><td>" . $row["Key"] . "</td><td>" . $row["Default"] . "</td><td>" . $row["Extra"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
echo "<br><br>";

echo "<h1>Tabla detalles_factura</h1>";
$sql = "DESCRIBE detalles_factura";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["Field"] . "</td><td>" . $row["Type"] . "</td><td>" . $row["Null"] . "</td><td>" . $row["Key"] . "</td><td>" . $row["Default"] . "</td><td>" . $row["Extra"] . "</td></tr>";
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
    }

    th,
    td {
        text-align: left;
        padding: 8px;
    }

    tr {
        background-color: #cccccc;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>