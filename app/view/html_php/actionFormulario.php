<?php
session_start();

require_once __DIR__ . '/../../model/DB/controlDB.php';
require_once __DIR__ . '/../../model/route_files.php';
require_once __DIR__ . '/../../model/DB/dataBaseCredentials.php';

$db = new dataBase($credentials, $CONFIG);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['nombre-completo']) || !isset($_POST['email']) || !isset($_POST['direccion']) || !isset($_POST['codigo-postal']) || !isset($_POST['ciudad']) || !isset($_POST['pais']) || !isset($_POST['MetodoP']) || !isset($_POST['telefono'])) {
        echo "Error al recibir los datos";
        exit();
    }
    $nombreUsuario = $_POST['nombre-completo'];
    $correoUsuario = $_POST['email'];
    $direccion = $_POST['direccion'] . ', ' . $_POST['codigo-postal'] . ', ' . $_POST['ciudad'];
    $pais = $_POST['pais'];
    $metodoPago = $_POST['MetodoP'];
    $telefono = $_POST['telefono'];
    $fecha = $_POST['fecha'];
    
// Datos de la factura 
// la fecha ocupa el formato YYYY-MM-DD
$fechaFactura = date('Y-m-d', strtotime($fecha));
$iva = 16; // 16% de IVA
$gastoEnvio = 50.00; // Costo de envío


// Lista de productos comprados (normalmente sería obtenida de una base de datos)
//$producto['prod_id'], $producto['cantidad'], $producto['precio'], $producto['descuento']
$productos = array(
    array('prod_id' => 40, 'cantidad' => 1, 'precio' => 100.00, 'descuento' => 0),
    array('prod_id' => 45, 'cantidad' => 1, 'precio' => 130.00, 'descuento' => 0),
    array('prod_id' => 46, 'cantidad' => 1, 'precio' => 140.00, 'descuento' => 25)
);

//            email para el id, es el email de la sesion
//altaFactura($email, $productos, $fecha, $iva, $gastos_envio, $pais, $direccion, $metodo_pago, $nombre, $correo, $telefono)
$folio = $db->altaFactura($_SESSION['email'], $productos, $fechaFactura, $iva, $gastoEnvio, $pais, $direccion, $metodoPago, $nombreUsuario, $correoUsuario, $telefono);
if($folio === false){
    echo "Error al generar la factura";
    exit();
}
echo "Folio de la factura: " . $folio;

}

//include_once 'TicketCorreo.php'
include_once 'Ticket.php';
?>


