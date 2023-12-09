<?php
include_once __DIR__ . '/../app/model/DB/dataBaseCredentials.php';
include_once __DIR__ . '/../app/model/routes_files.php';
include_once __DIR__ . '/../app/model/DB/controllDB.php';

// Establecer la conexión a la base de datos
$conn = new mysqli($credentials['host'], $credentials['user'], $credentials['pass'], $credentials['db']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Desactivar restricciones de clave externa
$sql_disable_fk = "SET foreign_key_checks = 0";
$conn->query($sql_disable_fk);

// eliminar los datos de la tabla facturas y detalles_factura
$sql = "DELETE FROM facturas";
$conn->query($sql);
$sql = "DELETE FROM detalles_factura";
$conn->query($sql);

// Reactivar restricciones de clave externa
$sql_enable_fk = "SET foreign_key_checks = 1";
$conn->query($sql_enable_fk);

$conn->close();
