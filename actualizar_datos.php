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
    if (!empty($_POST['contrasena'])) {
        $contrasena = encriptar_contrasena($_POST['contrasena']);
    } else {
        $contrasena = $user['contrasena'];
    }

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
<?php $config = obtener_config() ?? []; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Datos Personales</title>
    <link rel="stylesheet" href="estilos.css">
    <?php
    if (!empty($config['colores'])) {
        $colores_actuales = explode(',', $config['colores']);
    $color_primario = $colores_actuales[0] ?? '#18183a';
    $color_secundario = $colores_actuales[1] ?? '#ffd600';
    $color_fondo = $colores_actuales[2] ?? '#f8f8fa';
    echo '<style>:root {';
    echo '--color-primario: ' . $color_primario . ';';
    echo '--color-secundario: ' . $color_secundario . ';';
    echo '--color-fondo: ' . $color_fondo . ';';
    echo '}</style>';
    }
    ?>
    <link rel="icon" href="<?php echo $config['icono_principal'] ?? 'icono.png'; ?>">
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
    <main>
        <section class="form-section">
            <h2>Actualizar Datos Personales</h2>
            <form class="form-propiedad" method="post">
                <label>Nombre:</label><input type="text" name="nombre" value="<?php echo $user['nombre']; ?>" required>
                <label>Teléfono:</label><input type="text" name="telefono" value="<?php echo $user['telefono']; ?>">
                <label>Correo:</label><input type="email" name="correo" value="<?php echo $user['correo']; ?>" required>
                <label>Contraseña Nueva (opcional):</label><input type="password" name="contrasena">
                <?php foreach ($errores as $err): ?><p class="error"><?php echo $err; ?></p><?php endforeach; ?>
                <button type="submit" name="actualizar">Actualizar</button>
            </form>
        </section>
    </main>
    <footer class="footer-copy">
        <p>Derechos reservados &copy; <?php echo date('Y'); ?> UTN Solutions Real State</p>
    </footer>
</body>
</html>