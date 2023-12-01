<?php
$credntials = array(
  'host' => '162.241.62.48', // ip de hostgator
  'user' => 'gbfrallc_admin', // usuario de accseso
  'pass' => 'losmejorespeluches:3', // contraseña
  'db' => 'gbfrallc_fluffyhugs' // base de datos
);

$conn = new mysqli($credntials['host'], $credntials['user'], $credntials['pass'], $credntials['db']);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// eliminar los registros de la tabla
$sql = "DELETE FROM usuarios";
if ($conn->query($sql) === TRUE) {
  echo "Registros eliminados";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
echo "<br>";
// resetear el autoincremental usr_id
$sql = "ALTER TABLE usuarios AUTO_INCREMENT = 1";
if ($conn->query($sql) === TRUE) {
  echo "Autoincremental reseteado";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
echo "<br>";
$sql = "DELETE FROM preguntas_seguridad";
if ($conn->query($sql) === TRUE) {
  echo "Registros eliminados";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}