<?php
// Datos del formulario
// $folioFactura = $_POST['nombre_completo']
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreUsuario = $_POST['nombre-completo'];
    $correoUsuario = $_POST['email'];
    $direccion = $_POST['direccion'] . ', ' . $_POST['codigo-postal'] . ', ' . $_POST['ciudad'] . ', ' . $_POST['pais'];
    $metodoPago = $_POST['MetodoP'];
    $telefono = $_POST['telefono'];
}

// Datos de la factura 
$folioFactura = "123456";
$idUsuario = "78910";
$fechaFactura = date("Y-m-d"); // Fecha actual
$iva = 0.16; // 16% de IVA
$gastoEnvio = 50.00; // Costo de envío

// Lista de productos comprados (normalmente sería obtenida de una base de datos)
$productos = [
    ['nombre' => 'Producto 1', 'precio' => 200.00, 'cantidad' => 2],
    ['nombre' => 'Producto 2', 'precio' => 150.00, 'cantidad' => 1],
    ['nombre' => 'Producto 3', 'precio' => 300.00, 'cantidad' => 1]
];

// Calcular subtotal, IVA y total
$subtotal = array_sum(array_map(function ($producto) {
    return $producto['precio'] * $producto['cantidad'];
}, $productos));

$ModoPago = array('Tarjeta', 'Efectivo');

$totalIva = $subtotal * $iva;
$total = $subtotal + $totalIva + $gastoEnvio;
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../css/TicketEstilos.css">
    <title>Factura</title>
</head>

<body>

    <div class="factura-container">
        <table class="datos">
            <tr>
                <td class="linea_abajo" style="vertical-align: middle; text-align: right "><img src="../../media/images/LogoSF.png" alt="Logo" width="60px" height="60px"></td>
                <td class="linea_abajo" id="titulo_fac">Fluffy Hugs Factura</td>
                <td class="linea_abajo" style="vertical-align: middle;"><img src="../../media/images/LogoSF.png" alt="Logo" width="60px" height="60px"></td>
            </tr>
            <tr>
                <td class="linea_derecha">Folio Factura</td>
                <td class="linea_derecha">Fluffy Hugs</td>
                <td><?php echo $nombreUsuario ?></td>
            </tr>
            <tr>
                <td class="linea_derecha"><?php echo $folioFactura; ?></td>
                <td class="linea_derecha">fluffyhugs2023@gmail.com</td>
                <td><?php echo $correoUsuario ?></td>
            </tr>
            <tr>
                <td class="linea_derecha">Fecha</td>
                <td class="linea_derecha">449-123-4567</td>
                <td><?php echo $telefono ?></td>
            </tr>
            <tr>
                <td class="linea_derecha linea_abajo"><?php echo $fechaFactura; ?></td>
                <td class="linea_derecha linea_abajo">Avenida Universidad 940, Ciudad Universitaria, Universidad Autónoma de Aguascalientes, 20100 Aguascalientes, Ags.</td>
                <td class="linea_abajo"><?php echo $direccion ?></td>
            </tr>
        </table>


        <div class="factura-body">
            <table>
                <tr>
                    <th style="text-align: center;">Producto</th>
                    <th style="text-align: center;">Cantidad</th>
                    <th style="text-align: center;">Precio Unitario</th>
                    <th style="text-align: center;">Importe</th>
                </tr>
                <?php foreach ($productos as $producto) : ?>
                    <tr class="productos">
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td class="cantidad"><?php echo $producto['cantidad']; ?></td>
                        <td class="precioU">$<?php echo number_format($producto['precio'], 2); ?></td>
                        <td>$<?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>

                <div>
                    <tr>
                        <td colspan="2" rowspan="5" class="pago"><?php echo $metodoPago ?></td>
                    </tr>
                    <tr>
                        <td class="factura_totales">Subtotal</td>
                        <td>$<?php echo number_format($subtotal, 2); ?></td>
                    </tr>
                    <tr>
                        <td class="factura_totales">Gasto de Envío</td>
                        <td>$<?php echo number_format($gastoEnvio, 2); ?></td>
                    </tr>
                    <tr>
                        <td class="factura_totales">IVA</td>
                        <td>$<?php echo number_format($totalIva, 2); ?></td>
                    </tr>
                    <tr>
                        <td class="total"><strong>Total</strong></td>
                        <td class="total" style="text-align: left;"><strong>$<?php echo number_format($total, 2); ?></strong></td>
                    </tr>
                </div>

            </table>
        </div>


    </div>

</body>

</html>