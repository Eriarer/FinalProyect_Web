<?php
$credntials = array(
  'host' => '162.241.62.48', // ip de hostgator
  'user' => 'gbfrallc_admin', // usuario de accseso
  'pass' => 'losmejorespeluches:3', // contraseña
  'db' => 'gbfrallc_fluffyhugs' // base de datos
);

$conexion = new mysqli($credntials['host'], $credntials['user'], $credntials['pass'], $credntials['db']);
if ($conexion->connect_errno) {
  echo "Error al conectarse con My SQL debido al error: " . $conexion->connect_error;
}

$sql = 'DESCRIBE usuarios';
$resultado = $conexion->query($sql);
echo "<h1>ESTRUCTURA DE LA BASE DE DATOS</h1>";
echo "<h2>Base de datos: " . $credntials['db'] . "</h2>";
echo "<h3>Tabla: usuarios</h3>";
//crear una tabla
echo "<table border='1'>";
echo "<tr><th>Columna/th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
while ($fila = $resultado->fetch_assoc()) {
  echo "<tr>";
  echo "<td>" . $fila['Field'] . "</td>";
  echo "<td>" . $fila['Type'] . "</td>";
  echo "<td>" . $fila['Null'] . "</td>";
  echo "<td>" . $fila['Key'] . "</td>";
  echo "<td>" . $fila['Default'] . "</td>";
  echo "<td>" . $fila['Extra'] . "</td>";
  echo "</tr>";
}
echo "</table>";

$sql = 'DESCRIBE preguntas_seguridad';
$resultado = $conexion->query($sql);
echo "<h3>Tabla: preguntas_seguridad</h3>";
//crear una tabla
echo "<table border='1'>";
echo "<tr><th>Columna</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
while ($fila = $resultado->fetch_assoc()) {
  echo "<tr>";
  echo "<td>" . $fila['Field'] . "</td>";
  echo "<td>" . $fila['Type'] . "</td>";
  echo "<td>" . $fila['Null'] . "</td>";
  echo "<td>" . $fila['Key'] . "</td>";
  echo "<td>" . $fila['Default'] . "</td>";
  echo "<td>" . $fila['Extra'] . "</td>";
  echo "</tr>";
}
echo "</table>";


$resultado->free();
$conexion->close();
?>
<style>
  table {
    border-collapse: collapse;
  }

  th,
  td {
    border: 1px solid black;
    padding: 5px;
  }
  tr{
    background-color: #cccccc;
  }
  tr:nth-child(even) {
    background-color: #f2f2f2;
  }
</style>