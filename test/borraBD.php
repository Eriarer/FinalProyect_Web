<?php
include_once __DIR__ . '/../app/model/DB/dataBaseCredentials.php';

//elimina el contenido de la tabla de productos de la base de datos
$conn = new mysqli($credentials['host'], $credentials['user'], $credentials['pass'], $credentials['db']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "DELETE FROM productos";
if ($conn->query($sql) === TRUE) {
    echo "Tabla productos borrada correctamente";
} else {
    echo "Error borrando la tabla productos: " . $conn->error;
}

// resetear el id de la tabla productos AUTO_INCREMENT
$sql = "ALTER TABLE productos AUTO_INCREMENT = 1";
if ($conn->query($sql) === TRUE) {
    echo " Id de la tabla productos reseteado correctamente";
} else {
    echo "Error reseteando el id de la tabla productos: " . $conn->error;
}

$conn->close();
