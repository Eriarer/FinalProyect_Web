<?php
include_once __DIR__ . '/../app/model/DB/dataBaseCredentials.php';

// Establecer la conexión a la base de datos
$conn = new mysqli($credentials['host'], $credentials['user'], $credentials['pass'], $credentials['db']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Desactivar restricciones de clave externa
$sql_disable_fk = "SET foreign_key_checks = 0";
$conn->query($sql_disable_fk);

// Eliminar registros de la tabla preguntas_seguridad
$sql_preguntas_seguridad = "DELETE FROM preguntas_seguridad";
if ($conn->query($sql_preguntas_seguridad) === TRUE) {
    echo "El contenido de la tabla preguntas_seguridad se ha borrado correctamente.";
} else {
    echo "Error al borrar el contenido de la tabla preguntas_seguridad: " . $conn->error;
}

// Eliminar registros de la tabla usuarios
$sql_usuarios = "DELETE FROM usuarios";
if ($conn->query($sql_usuarios) === TRUE) {
    echo "El contenido de la tabla usuarios se ha borrado correctamente.";
} else {
    echo "Error al borrar el contenido de la tabla usuarios: " . $conn->error;
}

// resetear el id de la tabla productos AUTO_INCREMENT
$sql = "ALTER TABLE usuarios AUTO_INCREMENT = 1";
if ($conn->query($sql) === TRUE) {
    echo " Id de la tabla usuarios reseteado correctamente";
} else {
    echo "Error reseteando el id de la tabla usuarios: " . $conn->error;
}

// Reactivar restricciones de clave externa
$sql_enable_fk = "SET foreign_key_checks = 1";
$conn->query($sql_enable_fk);

$conn->close();
