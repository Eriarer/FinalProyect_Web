<?php
session_start();
$lastUpdateDate = filemtime(__FILE__);
include_once __DIR__ . '/../../../model/DB/dataBaseCredentials.php';
include_once __DIR__ . '/../../../model/routes_files.php';
include_once __DIR__ . '/../../../model/DB/controllDB.php';

$db = new dataBase($credentials, $CONFIG);
$folio = '';
$result = [];
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha enviado un valor para el campo de correo electrónico
    if (isset($_POST["folio"])) {
        $folio = $_POST["folio"];

        $db = new dataBase($credentials, $CONFIG);

        $result = $db->getFactura($folio);

        $result = json_decode($result, true);
    } else {
        header('Location: ../../../../index.php');
        return;
    }
} else {
    header('Location: ../../../../index.php');
    return;
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap v4.6.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JsBarcode -->
    <script src="https://cdn.jsdelivr.net/jsbarcode/3.6.0/JsBarcode.all.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="../../css/TicketEstilos.css">
    <link href="../../css/main.css" rel="stylesheet">
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="../../../media/images/oso-de-peluche.png" />
    <title>Factura</title>
</head>

<body>
    <?php include_once '../navbar.php'; ?>
    <div class="factura-container mt-5">
        <table class="datos">
            <tr>
                <th class="linea_abajo" style="vertical-align: middle; "><img src="../../../media/images/LogoSF.png" alt="Logo" width="60px" height="60px"></td>
                <th class="linea_abajo" id="titulo_fac" style="text-align: center;">Fluffy Hugs Factura</td>
                <th class="linea_abajo" style="vertical-align: middle;"><img src="../../../media/images/LogoSF.png" alt="Logo" width="60px" height="60px"></td>
            </tr>
            <tr>
                <td class="linea_derecha">Folio Factura</td>
                <td class="linea_derecha">Fluffy Hugs</td>
                <td><?= $result["nombre"] ?></td>
            </tr>
            <tr>
                <td class="linea_derecha"><?= $folio ?></td>
                <td class="linea_derecha">fluffyhugs2023@gmail.com</td>
                <td><?= $result["correo"] ?></td>
            </tr>
            <tr>
                <td class="linea_derecha">Fecha</td>
                <td class="linea_derecha">449-338-8009</td>
                <td><?= $result["telefono"] ?></td>
            </tr>
            <tr>
                <td class="linea_derecha linea_abajo"><?= $result['fecha_factura']; ?></td>
                <td class="linea_derecha linea_abajo">Avenida Universidad 940, Ciudad Universitaria, Universidad Autónoma de Aguascalientes, 20100 Aguascalientes, Ags, MX.</td>
                <td class="linea_abajo"><?= $result["direccion"] ?></td>
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
                <?php
                foreach ($result['detalles'] as $producto) {
                    echo '<tr class="productos">';
                    echo '<td>' . $producto['prod_name'] . '</td>';
                    echo '<td>' . $producto['cantidad'] . '</td>';
                    echo '<td>$' . $producto['precio'] . '</td>';
                    echo '<td>$' . $producto['precio'] * $producto['cantidad'] . '</td>';
                    echo '</tr>';
                }
                ?>

                <div>
                    <tr>
                        <td colspan="2" rowspan="5" class="pago">
                            <p><?= $result['metodo_pago'] ?></p>
                            <svg id="barcode"></svg>
                        </td>
                    </tr>
                    <tr>
                        <td class="factura_totales">Subtotal</td>
                        <td>$<?= $result['subtotal'] ?></td>
                    </tr>
                    <tr>
                        <td class="factura_totales">Gasto de Envío</td>
                        <td>$<?= $result['gastos_envio'] ?></td>
                    </tr>
                    <tr>
                        <td class="factura_totales">IVA</td>
                        <td>$<?= $result['total_iva'] ?></td>
                    </tr>
                    <tr>
                        <td class="total"><strong>Total</strong></td>
                        <td class="total" style="text-align: left;"><strong>$<?= $result['total'] ?></strong></td>
                    </tr>
                </div>

            </table>
        </div>


    </div>

    <!-- Boton que mande a ejecutar código de otro archivo -->
    <!-- <button id="botonpdf" onclick="window.open('TicketPDF.php', '_blank')">Ver PDF</button> -->

    <!-- Boton que mande a ejecutar código de otro archivo -->
    <div class="botonpdf mt-3 mb-5">
        <!-- Formulario que abre una nueva pestaña -->
        <form action="TicketPDF.php" method="POST" target="_blank">
            <input type="hidden" name="folio" value="<?= $folio ?>" style="display: none;">
            <button class="btn btn-primary btn-lg h1">Imprimir Factura</button>
        </form>
    </div>
    <!--  $nombreUsuario = $_POST['nombre-completo'];
    $correoUsuario = $_POST['email'];
    $direccion = $_POST['direccion'] . ', ' . $_POST['codigo-postal'] . ', ' . $_POST['ciudad'] . ', ' . $_POST['pais'];
    $metodoPago = $_POST['MetodoP'];
    $telefono = $_POST['telefono']; -->
    <?php include_once '../footer.php'; ?>
    <script>
        $(document).ready(function() {
            // Generar código de barras aleatorio  
            JsBarcode("#barcode", generateRandomBarcode(), {
                format: "CODE128",
                displayValue: true,
                fontSize: 20,
                lineColor: "#000000",
                background: "transparent",
                width: 3,
                height: 100,
                margin: 10,
                render: "svg"
            });

            // Función para generar un número aleatorio como código de barras
            function generateRandomBarcode() {
                var numeroFactura = <?php echo json_encode($folio); ?>;
                // Verificar si el valor es numérico y no está vacío
                // Convertir a número entero
                var numeroDecimal = parseInt(numeroFactura, 10);
                var numeroDecimal = numeroDecimal * 524876502786;
                //reducir el tamaño a 12 caracteres
                var numeroDecimal = numeroDecimal.toString().substring(0, 12);
                // Asegurar que siempre tenga al menos 12 dígitos
                var resultado = numeroDecimal;
                return resultado;
            }
        });



        function generarPDF() {
            // Redirigir a TicketPDF.php con los parámetros
            // Abrir una nueva pestaña con TicketPDF.php y parámetros
            window.open('TicketPDF.php' +
                '?nombre=' + encodeURIComponent(nombre) +
                '&email=' + encodeURIComponent(email) +
                '&direccion=' + encodeURIComponent(direccion) +
                '&metodoPago=' + encodeURIComponent(metodoPago) +
                '&telefono=' + encodeURIComponent(telefono), '_blank');
        }
    </script>

</body>

</html>