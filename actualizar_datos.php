<?php
include 'funciones.php';
validar_sesion();
$id = $_SESSION['usuario_id'];

$user = $conexion->query("SELECT * FROM usuarios WHERE id = $id")->fetch_assoc();

$errores = [];
if (isset($_POST['actualizar'])) {
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $telefono = $conexion->real_escape_string($_POST['telefono']);
    $correo = $conexion->real_escape_string($_POST['correo']);
    $contrasena = !empty($_POST['contrasena']) ? encriptar_contrasena($_POST['contrasena']) : $user['contrasena'];

    if (empty($nombre) || empty($correo)) {
        $errores[] = 'Campos requeridos faltantes';
    }

    if (empty($errores)) {
        $query = "UPDATE usuarios SET nombre='$nombre', telefono='$telefono', correo='$correo', contrasena='$contrasena' WHERE id=$id";
        if ($conexion->query($query)) {
            header('Location: panel.php');
        } else {
            $errores[] = 'Error: ' . $conexion->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Actualizar Datos Personales</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <form method="post">
        <label>Nombre:</label><input type="text" name="nombre" value="<?php echo $user['nombre']; ?>" required>
        <label>Teléfono:</label><input type="text" name="telefono" value="<?php echo $user['telefono']; ?>">
        <label>Correo:</label><input type="email" name="correo" value="<?php echo $user['correo']; ?>" required>
        <label>Contraseña Nueva (opcional):</label><input type="password" name="contrasena">
        <?php foreach ($errores as $err): ?><p class="error"><?php echo $err; ?></p><?php endforeach; ?>
        <button type="submit" name="actualizar">Actualizar</button>
    </form>
</body>
</html>