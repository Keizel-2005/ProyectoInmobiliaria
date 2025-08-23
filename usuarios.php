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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
     <div class="logo">
            <img src="imagenes/<?php echo $config['icono_principal'] ?? 'logo.png'; ?>" alt="Logo UTN Solutions" style="width: 50px; height: 50px; vertical-align: middle; margin-right: 10px;">
            UTN Solutions Real State
        </div>
        <div class="header-menu-wrap">
            <a href="panel.php" class="login-btn">Volver</a>
        </div>
    </header>
    <section class="mis-prop-section">
        <h2>Usuarios</h2>
        <div class="tabla-prop-wrap">
            <table class="tabla-propiedades">
                <tr><th>ID</th><th>Nombre</th><th>Usuario</th><th>Privilegio</th><th>Acciones</th></tr>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?php echo $u['id']; ?></td>
                        <td><?php echo $u['nombre']; ?></td>
                        <td><?php echo $u['usuario']; ?></td>
                        <td><?php echo $u['privilegio']; ?></td>
                        <td>
                            <a href="usuarios.php?id=<?php echo $u['id']; ?>" class="tabla-btn editar" title="Editar"><i class="fa-solid fa-pen-to-square"></i> Editar</a>
                            <a href="usuarios.php?accion=eliminar&id=<?php echo $u['id']; ?>" class="tabla-btn eliminar" onclick="return confirm('¿Seguro?');" title="Eliminar"><i class="fa-solid fa-trash"></i> Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </section>
    <section class="form-section">
        <h2><?php echo $id ? 'Editar' : 'Crear'; ?> Usuario</h2>
        <form class="form-propiedad" method="post" autocomplete="off">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $user['nombre'] ?? ''; ?>" required>
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo $user['telefono'] ?? ''; ?>">
            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" value="<?php echo $user['correo'] ?? ''; ?>" required>
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" value="<?php echo $user['usuario'] ?? ''; ?>" required>
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" <?php if (!$id) echo 'required'; ?> autocomplete="new-password">
            <label for="privilegio">Privilegio:</label>
            <select id="privilegio" name="privilegio">
                <option value="administrador" <?php if (isset($user['privilegio']) && $user['privilegio'] == 'administrador') echo 'selected'; ?>>Administrador</option>
                <option value="agente_ventas" <?php if (isset($user['privilegio']) && $user['privilegio'] == 'agente_ventas') echo 'selected'; ?>>Agente de Ventas</option>
            </select>
            <?php foreach ($errores as $err): ?><p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $err; ?></p><?php endforeach; ?>
            <button type="submit" name="guardar"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
        </form>
    </section>
</body>
</html>