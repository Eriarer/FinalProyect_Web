<?php
$credntials = array(
  'host' => '162.241.62.48', // ip de hostgator
  'user' => 'gbfrallc_admin', // usuario de accseso
  'pass' => 'losmejorespeluches:3', // contraseña
  'db' => 'gbfrallc_fluffyhugs' // base de datos
);

$conexion = mysqli_connect(
  $credntials['host'],
  $credntials['user'],
  $credntials['pass'],
  $credntials['db']
);

if (!$conexion) {
  echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
  echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
  echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
  exit;
}

$sql = "SELECT * FROM `usuarios`";
$resultado = mysqli_query($conexion, $sql);

echo "<h2>Tabla: usuarios</h2>";
// creamos una tabla para mostrar los datos
echo "<table border='1'>";
echo "<tr>";
echo "<th>usr_id</th>";;
echo "<th>usr_email</th>";
echo "<th>usr_name</th>";
echo "<th>usr_pwd</th>";
echo "<th>usr_admin</th>";
echo "</tr>";
while ($fila = mysqli_fetch_array($resultado)) {
  echo "<tr>";
  echo "<td>" . $fila['usr_id'] . "</td>";
  echo "<td>" . $fila['usr_email'] . "</td>";
  echo "<td>" . $fila['usr_name'] . "</td>";
  echo "<td>" . $fila['usr_pwd'] . "</td>";
  echo "<td>" . $fila['usr_admin'] . "</td>";
  echo "</tr>";
}
echo "</table>";

$sql = "SELECT * FROM `preguntas_seguridad`";
$resultado = mysqli_query($conexion, $sql);

echo "<h2>Tabla: preguntas_seguridad</h2>";
// creamos una tabla para mostrar los datos
echo "<table border='1'>";
echo "<tr>";
echo "<th>usr_id</th>";
echo "<th>pregunta</th>";
echo "<th>respuesta</th>";
echo "</tr>";
while ($fila = mysqli_fetch_array($resultado)) {
  echo "<tr>";
  echo "<td>" . $fila['usr_id'] . "</td>";
  echo "<td>" . $fila['pregunta'] . "</td>";
  echo "<td>" . $fila['respuesta'] . "</td>";
  echo "</tr>";
}
echo "</table>";


mysqli_close($conexion);
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