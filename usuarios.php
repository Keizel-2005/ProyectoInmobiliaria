<?php
include 'funciones.php';
validar_sesion();
if (!es_admin()) header('Location: index.php');

$accion = $_GET['accion'] ?? '';
$id = $_GET['id'] ?? 0;
$errores = [];

if ($accion == 'eliminar' && $id) {
    $query = "DELETE FROM usuarios WHERE id = $id AND privilegio != 'administrador'"; // No eliminar admin principal
    $conexion->query($query);
    header('Location: usuarios.php');
}

$user = [];
if ($id) {
    $query = "SELECT * FROM usuarios WHERE id = $id";
    $user = $conexion->query($query)->fetch_assoc();
}

if (isset($_POST['guardar'])) {
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $telefono = $conexion->real_escape_string($_POST['telefono']);
    $correo = $conexion->real_escape_string($_POST['correo']);
    $usuario = $conexion->real_escape_string($_POST['usuario']);
    $privilegio = $conexion->real_escape_string($_POST['privilegio']);

    if (!empty($_POST['contrasena'])) {
        $contrasena = encriptar_contrasena($_POST['contrasena']);
    } else {
        $contrasena = $user['contrasena'];
    }

    if (empty($nombre) || empty($correo) || empty($usuario) || empty($privilegio)) {
        $errores[] = 'Campos requeridos faltantes';
    }

    if (empty($errores)) {
        if ($id) {
            $query = "UPDATE usuarios SET nombre='$nombre', telefono='$telefono', correo='$correo', usuario='$usuario', contrasena='$contrasena', privilegio='$privilegio' WHERE id=$id";
        } else {
            $query = "INSERT INTO usuarios (nombre, telefono, correo, usuario, contrasena, privilegio) VALUES ('$nombre', '$telefono', '$correo', '$usuario', '$contrasena', '$privilegio')";
        }
        if ($conexion->query($query)) {
            header('Location: usuarios.php');
        } else {
            $errores[] = 'Error: ' . $conexion->error;
        }
    }
}

$usuarios = $conexion->query("SELECT * FROM usuarios")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Gestionar Usuarios</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h2>Usuarios</h2>
    <table>
        <tr><th>ID</th><th>Nombre</th><th>Usuario</th><th>Privilegio</th><th>Acciones</th></tr>
        <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?php echo $u['id']; ?></td>
                <td><?php echo $u['nombre']; ?></td>
                <td><?php echo $u['usuario']; ?></td>
                <td><?php echo $u['privilegio']; ?></td>
                <td><a href="usuarios.php?id=<?php echo $u['id']; ?>">Editar</a> | <a href="usuarios.php?accion=eliminar&id=<?php echo $u['id']; ?>" onclick="return confirm('¿Seguro?');">Eliminar</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <h2><?php echo $id ? 'Editar' : 'Crear'; ?> Usuario</h2>
    <form method="post">
        <label>Nombre:</label><input type="text" name="nombre" value="<?php echo $user['nombre'] ?? ''; ?>" required>
        <label>Teléfono:</label><input type="text" name="telefono" value="<?php echo $user['telefono'] ?? ''; ?>">
        <label>Correo:</label><input type="email" name="correo" value="<?php echo $user['correo'] ?? ''; ?>" required>
        <label>Usuario:</label><input type="text" name="usuario" value="<?php echo $user['usuario'] ?? ''; ?>" required>
        <label>Contraseña:</label><input type="password" name="contrasena" <?php if (!$id) echo 'required'; ?>>
        <label>Privilegio:</label>
        <select name="privilegio">
            <option value="administrador" <?php if (isset($user['privilegio']) && $user['privilegio'] == 'administrador') echo 'selected'; ?>>Administrador</option>
            <option value="agente_ventas" <?php if (isset($user['privilegio']) && $user['privilegio'] == 'agente_ventas') echo 'selected'; ?>>Agente de Ventas</option>
        </select>
        <?php foreach ($errores as $err): ?><p class="error"><?php echo $err; ?></p><?php endforeach; ?>
        <button type="submit" name="guardar">Guardar</button>
    </form>
</body>
</html>