<?php
// Clases de PHPMailer 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Bibliotecas de PHPMailer
require '../../lib/PHPMailer/src/Exception.php';
require '../../lib/PHPMailer/src/PHPMailer.php';
require '../../lib/PHPMailer/src/SMTP.php';

// Instancia de PHPMailer
$mail = new PHPMailer(true);

// Credenciales de la cuenta de correo utilizada para enviar correos
$config = require 'PHPMailerCredentials.php';

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
    $mail->Body = $recipientMessage;    // Cuerpo del mensaje en HTML

    $mail->send();
    
    // Redireccionar al footer despues de 5 segundos
    echo 'Mensaje enviado correctamente';
    echo '<br>Redireccionando al footer en 5 segundos...';
    header("refresh:5; url=../footer.php");

} catch (Exception $e) {
    echo "No se pudo enviar el mensaje. Error de envío: {$mail->ErrorInfo}";
}
