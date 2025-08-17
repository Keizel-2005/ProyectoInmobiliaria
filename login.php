<?php
include 'funciones.php';

$error = '';
if (isset($_POST['login'])) {
    $usuario = $conexion->real_escape_string($_POST['usuario']);
    $contrasena = encriptar_contrasena($_POST['contrasena']);
    $query = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contrasena = '$contrasena'";
    $result = $conexion->query($query);
    if ($row = $result->fetch_assoc()) {
        session_start();
        $_SESSION['usuario_id'] = $row['id'];
        $_SESSION['privilegio'] = $row['privilegio'];
        header('Location: panel.php');
        exit();
    } else {
        $error = 'Credenciales incorrectas';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <form method="post">
        <label>Usuario:</label>
        <input type="text" name="usuario" required>
        <label>Contraseña:</label>
        <input type="password" name="contrasena" required>
        <?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
        <button type="submit" name="login">Ingresar</button>
    </form>
</body>
</html>