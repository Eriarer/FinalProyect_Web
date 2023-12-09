<?php
include_once __DIR__ . '/../app/model/DB/dataBaseCredentials.php';
include_once __DIR__ . '/../app/model/routes_files.php';
include_once __DIR__ . '/../app/model/DB/controllDB.php';

$conn = new mysqli($credentials['host'], $credentials['user'], $credentials['pass'], $credentials['db']);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// describir las tablas
$sql = "DESCRIBE facturas";
$result = $conn->query($sql);

echo "<br><h2>Tabla facturas</h2><br>";
if ($result->num_rows > 0) {
  echo "<table>";
  echo "<tr>";
  echo "<th>Field</th>";
  echo "<th>Type</th>";
  echo "<th>Null</th>";
  echo "<th>Key</th>";
  echo "<th>Default</th>";
  echo "<th>Extra</th>";
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

$sql = "DESCRIBE detalles_factura";
$result = $conn->query($sql);

echo "<br><h2>Tabla detalles_factura</h2><br>";
if ($result->num_rows > 0) {
  echo "<table>";
  echo "<tr>";
  echo "<th>Field</th>";
  echo "<th>Type</th>";
  echo "<th>Null</th>";
  echo "<th>Key</th>";
  echo "<th>Default</th>";
  echo "<th>Extra</th>";
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

$sql = "SELECT * FROM facturas";
$result = $conn->query($sql);

echo "<br><h2>Tabla facturas</h2><br>";
if ($result->num_rows > 0) {
  echo "<table>";
  echo "<tr>";
  echo "<th>folio_factura</th>";
  echo "<th>usr_id</th>";
  echo "<th>fecha_factura</th>";
  echo "<th>iva</th>";
  echo "<th>subt_total</th>";
  echo "<th>gastos_envio</th>";
  echo "<th>total</th>";
  echo "<th>pais</th>";
  echo "<th>direccion</th>";
  echo "<th>metodo_pago</th>";
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

$sql = "SELECT * FROM detalles_factura";
$result = $conn->query($sql);

echo "<br><h2>Tabla detalles_factura</h2><br>";
if ($result->num_rows > 0) {
  echo "<table>";
  echo "<tr>";
  echo "<th>folio_factura</th>";
  echo "<th>producto_id</th>";
  echo "<th>cantidad</th>";
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