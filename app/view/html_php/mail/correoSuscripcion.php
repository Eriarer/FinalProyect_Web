<?php
// Correo y nombre del destinatario
$recipientEmail = '';
$recipientName = '';

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha enviado un valor para el campo de correo electrónico
    if (isset($_POST["email"])) {
        // 
        $recipientEmail = $_POST["email"];
    }
}

// Asunto y mensaje
$recipientSubject = 'Suscripción a la lista de correo';
$recipientMessage = '
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div>
        <h1>Gracias por suscribirte a FluffyHugs</h1>
        <p>Nos emociona tenerte a bordo, pronto recibirás las últimas actualizaciones directamente en tu bandeja de
            entrada. Queremos asegurarnos de que siempre estés al tanto de los nuevos peluches, promociones
            exclusivas y eventos emocionantes.</p>
        <p>No dudes en ponerte en contacto con nosotros si tienes alguna pregunta o sugerencia. </p>
        <p>Con cariño,</p>
        <p>El equipo de FluffyHugs.</p>
    </div>
</body>

</html>
';

// Incluir el archivo correo.php
include_once 'correo.php';
