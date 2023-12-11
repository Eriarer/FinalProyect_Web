<?php
include_once __DIR__ . '/../app/model/DB/dataBaseCredentials.php';
include_once __DIR__ . '/../app/model/routes_files.php';
include_once __DIR__ . '/../app/model/DB/controllDB.php';


$conn = new mysqli($credentials['host'], $credentials['user'], $credentials['pass'], $credentials['db']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$usuario = 6;
$sql = "UPDATE usuarios SET NEWFLUFFY15 = 0 WHERE usr_id = $usuario";
echo "<br><br>";
if ($conn->query($sql) === TRUE) {
    echo "NEWFLUFFY15 updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
$sql = "UPDATE usuarios SET FLUFFY10 = 0 WHERE usr_id = $usuario";
echo "<br><br>";
if ($conn->query($sql) === TRUE) {
    echo "FLUFFY10 updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
$sql = "UPDATE usuarios SET FLUFFY5 = 0 WHERE usr_id = $usuario";
echo "<br><br>";
if ($conn->query($sql) === TRUE) {
    echo "FLUFFY5 updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
$conn->close();
return;
// Establecer la conexión a la base de datos
$db = new dataBase($credentials, $CONFIG);

echo "<br><br>";
$result = $db->usarCupon(12, "NEWFLUFFY15");
echo $result ? "true" : "false";

echo "<br><br>";
$result = $db->usarCupon(12, "NEWFLUFFY15");
echo $result ? "true" : "false";