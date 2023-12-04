<?php
include_once __DIR__ . '/../app/model/dataBaseCredentials.php';
include_once __DIR__ . '/../app/model/routes_files.php';
include_once __DIR__ . '/../app/model/controllDB.php';

// Establecer la conexión a la base de datos
$conn = new mysqli($credentials['host'], $credentials['user'], $credentials['pass'], $credentials['db']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Desactivar restricciones de clave externa
$sql_disable_fk = "SET foreign_key_checks = 0";
$conn->query($sql_disable_fk);

// Acer admin (poniendo 1 a la columna usr_admin) a un usuario en especifico
$sql_alta_admin = "UPDATE usuarios SET usr_admin = 1 WHERE usr_id = 1";
if ($conn->query($sql_alta_admin) === TRUE) {
    echo "Se ha dado de alta al usuario con id 1 como administrador";
} else {
    echo "Error al dar de alta al usuario con id 1 como administrador: " . $conn->error;
}

// Reactivar restricciones de clave externa
$sql_enable_fk = "SET foreign_key_checks = 1";
$conn->query($sql_enable_fk);

$conn->close();
