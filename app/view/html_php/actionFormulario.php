<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreUsuario = $_POST['nombre-completo'];
    $correoUsuario = $_POST['email'];
    $direccion = $_POST['direccion'] . ', ' . $_POST['codigo-postal'] . ', ' . $_POST['ciudad'] . ', ' . $_POST['pais'];
    $metodoPago = $_POST['MetodoP'];
    $telefono = $_POST['telefono'];
}
//include_once 'TicketCorreo.php'
include_once 'Ticket.php';
?>
