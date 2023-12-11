<?php
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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Boostrap v4.6.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- agregando link para darle estilos a la alerta -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- css -->
    <link rel="stylesheet" href="../../css/TicketEstilos.css">
    <link href="../../css/main.css" rel="stylesheet">
    <!-- favIcon -->
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
                        <td colspan="2" rowspan="5" class="pago"><?= $result['metodo_pago'] ?></td>
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
        // Obtener los valores del formulario
        var nombre = '<?php echo $nombreUsuario ?>';
        var email = '<?php echo $correoUsuario ?>';
        var direccion = '<?php echo $direccion ?>';
        var metodoPago = '<?php echo $metodoPago ?>';
        var telefono = '<?php echo $telefono ?>';

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