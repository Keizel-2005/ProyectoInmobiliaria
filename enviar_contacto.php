<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['mensaje'])) {
    $nombre = filter_var(trim($_POST['nombre']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $mensaje = filter_var(trim($_POST['mensaje']), FILTER_SANITIZE_STRING);


    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($nombre) && !empty($mensaje)) {
        $to = "correoproyectoweb76@gmail.com"; 
        $subject = "Contacto desde el sitio web";
        $message = "Nombre: $nombre\nEmail: $email\nMensaje: $mensaje";
        $headers = "From: no-reply@utnsolutions.com\r\n"; 
        $headers .= "Reply-To: $email\r\n"; 

        if (mail($to, $subject, $message, $headers)) {
            header('Location: index.php?enviado=1');
        } else {
            header('Location: index.php?error=1');
        }
    } else {
        header('Location: index.php?error=1');
    }
} else {
    header('Location: index.php');
}
?>