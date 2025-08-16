<?php
// enviar_contacto.php - Enviar email desde footer
if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['mensaje'])) {
    $to = "info@utnsolutions.com"; // Cambia al email definido
    $subject = "Contacto desde el sitio web";
    $message = "Nombre: {$_POST['nombre']}\nEmail: {$_POST['email']}\nMensaje: {$_POST['mensaje']}";
    $headers = "From: {$_POST['email']}";
    mail($to, $subject, $message, $headers);
    header('Location: index.php?enviado=1');
} else {
    header('Location: index.php');
}
?>