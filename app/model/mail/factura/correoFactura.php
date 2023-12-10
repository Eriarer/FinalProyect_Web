<?php
include_once __DIR__ . '/../../routes_files.php';
include_once __DIR__ . '/../../DB/controllDB.php';
include_once __DIR__ . '/../../DB/dataBaseCredentials.php';

$db = new dataBase($credentials, $CONFIG);
// Correo y nombre del destinatario
$recipientEmail = '';
$recipientName = '';
$result = [];

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha enviado un valor para el campo de correo electrónico
    if (isset($_POST["email"]) && $isset($_POST["folio"])) {
        // 
        $recipientEmail = $_POST["email"];
        $result = $db->getFactura($_POST["folio"]);
    }
}

// Asunto y mensaje
$recipientSubject = mb_encode_mimeheader('Gracias por tu compra', 'UTF-8', 'Q');
$recipientMessage = '

';

// Clases de PHPMailer 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Bibliotecas de PHPMailer
require __DIR__ . '/../../../view/lib/PHPMailer/src/Exception.php';
require __DIR__ . '/../../../view/lib/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../../../view/lib/PHPMailer/src/SMTP.php';

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
    $mail->AddEmbeddedImage('LogoSF.png', 'Logo');
    $mail->Body = $recipientMessage; // Contenido del correo
    
    
    $mail->send();

    // Redireccionar al footer despues de 5 segundos
    echo 'Mensaje enviado correctamente';
} catch (Exception $e) {
    echo "No se pudo enviar el mensaje. Error de envío: {$mail->ErrorInfo}";
}
