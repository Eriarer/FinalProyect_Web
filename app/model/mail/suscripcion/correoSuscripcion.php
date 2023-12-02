<?php
include_once __DIR__ . '/../../../routes_files.php';
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
$recipientSubject = mb_encode_mimeheader('Suscripción a la lista de correo', 'UTF-8', 'Q');
$recipientMessage = __DIR__ . '/correoSuscripcion.html';

// Incluir el archivo correo.php
include_once __DIR__ . '/../correo.php';
