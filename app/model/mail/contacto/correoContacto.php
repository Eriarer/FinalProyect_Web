<?php
include_once __DIR__ . '/../../routes_files.php';
// Correo y nombre del destinatario
$recipientEmail = '';
$recipientName = '';

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha enviado un valor para el campo de nombre, correo electrónico y
    if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["message"])) {
        // 
        $recipientName = $_POST["name"];
        $recipientEmail = $_POST["email"];
        $formMessage = $_POST["message"];
    }
}

// Asunto y mensaje
$recipientSubject = mb_encode_mimeheader('Correo de contacto', 'UTF-8', 'Q');
$recipientMessage = '
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            color: #fff;
            font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif;
        }

        img {
            width: 8rem;
            height: 8rem;
            padding-top: 2rem;
        }

        p {
            font-size: 1.2rem;
        }

        .left {
            width: 15%;
            background-color: #143877;
        }

        .center {
            width: 70%;
            background-color: #143877;
            text-align: center;
        }

        .right {
            width: 15%;
            background-color: #143877;
        }

        .copy {
            background-color: #fff;
            color: #143877;
            font-family: "Courier New", Courier, monospace;
            text-align: justify;
            padding: 1rem;
            padding-left: 2rem;
            padding-right: 2rem;
            border-radius: 1rem;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td class="left"></td>
            <td class="center">
                <img src="cid:Logo" alt="Gato">
            </td>
            <td class="right"></td>
        </tr>
        <tr>
            <td class="left"></td>
            <td class="center">
                <h1>Gracias por ponerte en contacto con nosotros</h1>
            </td>
            <td class="right"></td>
        </tr>
        <tr>
            <td class="left"></td>
            <td class="center">
                <p>Estamos procesando tu solicitud, en breve nos pondremos en contacto contigo.</p>
                <p>Valoramos tu interés y paciencia mientras trabajamos para brindarte el mejor servicio posible.</p>
            </td>
            <td class="right"></td>
        </tr>
        <tr>
            <td class="left"></td>
            <td class="center">
                <div class="copy">
                    <p>Copia de tu mensaje:</p>
                    <p>' . $formMessage . '</p>
            </td>
            <td class="right"></td>
        </tr>

        <tr>
            <td class="left"></td>
            <td class="center">
                <p>Con cariño, el equipo de FluffyHugs.</p>
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


// Incluir el archivo correo.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Bibliotecas de PHPMailer
require __DIR__ . '/../../../model/lib/PHPMailer/src/Exception.php';
require __DIR__ . '/../../../model/lib/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../../../model/lib/PHPMailer/src/SMTP.php';

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
    $imagen_url = file_get_contents($CONFIG['P_model'] . 'mail/contacto/gato.jpg');
    $mail->CharSet = 'UTF-8';
    $mail->AddEmbeddedImage('LogoSF.png', 'Logo');
    $mail->Body = $recipientMessage; // Contenido del correo


    $mail->send();

    // Redireccionar al footer despues de 5 segundos
    echo 'Mensaje enviado correctamente';
    return;
} catch (Exception $e) {
    echo "No se pudo enviar el mensaje. Error de envío: {$mail->ErrorInfo}";
    return;
}
