<?php
$productos = [
    ['nombre' => 'Producto 1', 'precio' => 200.00, 'cantidad' => 2],
    ['nombre' => 'Producto 2', 'precio' => 150.00, 'cantidad' => 1],
    ['nombre' => 'Producto 3', 'precio' => 300.00, 'cantidad' => 1]
];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #plantilla {
            width: 100%;
            border-collapse: collapse;
            color: #fff;
            font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif;
        }

        #logo {
            width: 8rem;
            height: 8rem;
            padding-top: 2rem;
        }

        .texto {
            font-size: 1.2rem;
        }

        .left {
            width: 5%;
            background-color: #143877;
        }

        .center {
            width: 90%;
            background-color: #143877;
            text-align: center;
        }

        .right {
            width: 5%;
            background-color: #143877;
        }

        .copy {
            background-color: #fff;
            color: black;
            font-family: "Courier New", Courier, monospace;
            text-align: justify;
            padding: 0.5rem;
            padding-left: 1rem;
            padding-right: 1rem;
            border-radius: 1rem;
        }

        .datos td {
            width: 33%;
            vertical-align: top;
        }

        .linea_abajo {
            border-bottom: 2px dotted black;
        }

        .linea_derecha {
            border-right: 2px dotted black;

        }

        .factura-body {
            margin-bottom: 20px;
        }

        .factura-body {
            margin-bottom: 20px;
        }
        .factura-body table {
            width: 100%;
            border-collapse: collapse;
        }
        .factura-body table, .factura-body th, .factura-body td {
            border: 1px rgb(9, 9, 9);
            padding: 5px;
            
        }
        .productos td {
            text-align: center;
        }
        .pago {
            text-align: center;
            vertical-align: middle;
        }

        .factura_totales {
            text-align: right;
            font-weight: bold; 
        }
        .total{
            color: red;
            font-weight: bold;
            text-align: right;
        }
        
    </style>
</head>

<body>
    <table id="plantilla">
        <tr>
            <td class="left"></td>
            <td class="center">
                <img src="cid:Logo" alt="Logo" id="logo">
            </td>
            <td class="right"></td>
        </tr>
        <tr>
            <td class="left"></td>
            <td class="center">
                <h1>Gracias por tu compra en FluffyHugs.</h1>
            </td>
            <td class="right"></td>
        </tr>
        <tr>
            <td class="left"></td>
            <td class="center">
                <p class="texto">Estamos procesando tu pedido y pronto nos pondremos en contacto contigo para proporcionarte tu número de rastreo.</p>
                <p class="texto">Valoramos tu elección y paciencia mientras trabajamos para brindarte el mejor servicio posible.</p>
            </td>
            <td class="right"></td>
        </tr>
        <tr>
            <td class="left"></td>
            <td class="center">
                <div class="copy">
                    <table class="datos">
                        <tr>
                            <td class="linea_abajo" style="vertical-align: middle; text-align: right "></td>
                            <td class="linea_abajo" id="titulo_fac">Fluffy Hugs Factura</td>
                            <td class="linea_abajo" style="vertical-align: middle;"></td>
                        </tr>
                        <tr>
                            <td class="linea_derecha">Folio Factura</td>
                            <td class="linea_derecha">Fluffy Hugs</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="linea_derecha"></td>
                            <td class="linea_derecha">fluffyhugs2023@gmail.com</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="linea_derecha">Fecha</td>
                            <td class="linea_derecha">449-123-4567</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="linea_derecha linea_abajo"></td>
                            <td class="linea_derecha linea_abajo">Avenida Universidad 940, Ciudad Universitaria, Universidad Autónoma de Aguascalientes, 20100 Aguascalientes, Ags, MX.</td>
                            <td class="linea_abajo"></td>
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
            </td>
            <td class="right"></td>
        </tr>

        <tr>
            <td class="left"></td>
            <td class="center">
                <p class="texto">Con cariño, el equipo de FluffyHugs.</p>
            </td>
            <td class="right"></td>
        </tr>
        <tr>
            <td class="left"></td>
            <td class="center">
                <p></p>
            </td>
            <td class="right"></td>
        </tr>

        </tr>
    </table>
</body>

</html>