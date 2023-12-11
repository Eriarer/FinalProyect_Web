<?php
include_once __DIR__ . '/../../DB/dataBaseCredentials.php';
include_once __DIR__ . '/../../routes_files.php';
include_once __DIR__ . '/../../DB/controllDB.php';

// Correo y nombre del destinatario
$recipientEmail = '';
$recipientName = '';
$result = [];
$folio = '';

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha enviado un valor para el campo de correo electrónico
    if (isset($_POST["folio"])) {
        $folio = $_POST["folio"];

        $db = new dataBase($credentials, $CONFIG);

        $result = $db->getFactura($folio);

        $result = json_decode($result, true);
    } else {
        echo 'No se ha enviado el folio';
        return;
    }
} else {
    echo 'No se ha enviado el formulario';
    return;
}

$recipientEmail = $result['correo'];
// Asunto y mensaje
$recipientSubject = mb_encode_mimeheader('Gracias por tu compra', 'UTF-8', 'Q');
$recipientMessage = '
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

        .factura-body table,
        .factura-body th,
        .factura-body td {
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

        .total {
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
                            <td class="linea_abajo" style="vertical-align: middle;"><?php ?></td>
                        </tr>
                        <tr>
                            <td class="linea_derecha">Folio Factura</td>
                            <td class="linea_derecha">Fluffy Hugs</td>
                            <td>' . $result['nombre'] . '</td>
                        </tr>
                        <tr>
                            <td class="linea_derecha">' . $folio . '</td>
                            <td class="linea_derecha">fluffyhugs2023@gmail.com</td>
                            <td>' . $result['correo'] . '</td>
                        </tr>
                        <tr>
                            <td class="linea_derecha">Fecha</td>
                            <td class="linea_derecha">449XXXXXXX</td>
                            <td>' . $result['telefono'] . '</td>
                        </tr>
                        <tr>
                            <td class="linea_derecha linea_abajo">' . $result['fecha_factura'] . '</td>
                            <td class="linea_derecha linea_abajo">Avenida Universidad 940, Ciudad Universitaria, Universidad Autónoma de Aguascalientes, 20100 Aguascalientes, Ags, MX.</td>
                            <td class="linea_abajo">' . $result['direccion'] . '</td>
                        </tr>
                    </table>

                    <div class="factura-body">
                        <table>
                            <tr>
                                <th style="text-align: center;">Producto</th>
                                <th style="text-align: center;">Cantidad</th>
                                <th style="text-align: center;">Precio Unitario</th>
                                <th style="text-align: center;">Importe</th>
                            </tr>';
foreach ($result['detalles'] as $producto) {
    $recipientMessage .= '<tr class="productos">';
    $recipientMessage .= '<td>' . $producto['prod_name'] . '</td>';
    $recipientMessage .= '<td>' . $producto['cantidad'] . '</td>';
    $recipientMessage .= '<td>$' . $producto['precio'] . '</td>';
    $recipientMessage .= '<td>$' . $producto['precio'] * $producto['cantidad'] . '</td>';
    $recipientMessage .= '</tr>';
}
$recipientMessage .=  '
                                <tr>
                                    <td colspan="2" rowspan="5" class="pago">' . $result['metodo_pago'] . '</td>
                                </tr>
                                <tr>
                                    <td class="factura_totales">Subtotal</td>
                                    <td>' . $result['subtotal'] . '</td>
                                </tr>
                                <tr>
                                    <td class="factura_totales">Gasto de Envío</td>
                                    <td>' . $result['gastos_envio'] . '</td>
                                </tr>
                                <tr>
                                    <td class="factura_totales">IVA</td>
                                    <td>' . $result['total_iva'] . '</td>
                                </tr>
                                <tr>
                                    <td class="total"><strong>Total</strong></td>
                                    <td class="total" style="text-align: left;"><strong>' . $result['total'] . '</strong></td>
                                </tr>

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
';

// Clases de PHPMailer 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Bibliotecas de PHPMailer
require __DIR__ . '/../../lib/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../../lib/PHPMailer/src/Exception.php';
require __DIR__ . '/../../lib/PHPMailer/src/SMTP.php';

// Instancia de PHPMailer
$mail = new PHPMailer(true);

// Credenciales de la cuenta de correo utilizada para enviar correos
$config = require __DIR__ . '/../PHPMailerCredentials.php';

try {
    $mail->isSMTP();                                    // Configuración para usar SMTP para el envío del correo
    $mail->Host = $config['email']['host'];             // Configuración del servidor SMTP
    $mail->SMTPAuth = $config['email']['smtpauth'];     // Habilita la autenticación SMTP
    $mail->Username = $config['email']['username'];     // Nombre de usuario
    $mail->Password = $config['email']['password'];     // Contraseña
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;    // Habilita la encriptación
    $mail->Port = $config['email']['port'];             // Puerto para conectarse

    // Remitente y destinatario(s)
    $mail->setFrom($config['email']['username'], $config['email']['name']);     // Remitente
    $mail->addAddress($config['email']['username'], $config['email']['name']);  // Copia al remitente
    $mail->addAddress($recipientEmail, $recipientName);                         // Destinatario

    // Contenido
    $mail->isHTML(true);                // Establece el formato del correo electrónico en HTML
    $mail->Subject = $recipientSubject; // Asunto del correo  
    $mail->CharSet = 'UTF-8';
    $mail->AddEmbeddedImage('LogoSF.png', 'Logo');
    $mail->Body = $recipientMessage; // Contenido del correo


    $mail->send();

    // Redireccionar al footer despues de 5 segundos
    echo 'Mensaje enviado correctamente';
} catch (Exception $e) {
    echo "No se pudo enviar el mensaje. Error de envío: {$mail->ErrorInfo}";
}
