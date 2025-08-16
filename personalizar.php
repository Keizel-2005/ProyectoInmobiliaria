<?php
include 'funciones.php';
validar_sesion();
if (!es_admin()) header('Location: index.php');

$config = obtener_config();
$errores = [];

if (isset($_POST['actualizar'])) {
    $colores = $conexion->real_escape_string($_POST['colores']);
    $mensaje_banner = $conexion->real_escape_string($_POST['mensaje_banner']);
    $info_quienes_somos = $conexion->real_escape_string($_POST['info_quienes_somos']);
    $direccion = $conexion->real_escape_string($_POST['direccion']);
    $telefono = $conexion->real_escape_string($_POST['telefono']);
    $email = $conexion->real_escape_string($_POST['email']);
    $enlaces_facebook = $conexion->real_escape_string($_POST['enlaces_facebook']);
    $enlaces_twitter = $conexion->real_escape_string($_POST['enlaces_twitter']);
    $enlaces_instagram = $conexion->real_escape_string($_POST['enlaces_instagram']);

    // Manejar uploads
    $icono_principal = $config['icono_principal'];
    if (isset($_FILES['icono_principal']) && $_FILES['icono_principal']['error'] == 0) {
        $icono_principal = subir_imagen($_FILES['icono_principal']);
    }
    $icono_blanco = $config['icono_blanco'];
    if (isset($_FILES['icono_blanco']) && $_FILES['icono_blanco']['error'] == 0) {
        $icono_blanco = subir_imagen($_FILES['icono_blanco']);
    }
    $imagen_banner = $config['imagen_banner'];
    if (isset($_FILES['imagen_banner']) && $_FILES['imagen_banner']['error'] == 0) {
        $imagen_banner = subir_imagen($_FILES['imagen_banner']);
    }
    $imagen_quienes_somos = $config['imagen_quienes_somos'];
    if (isset($_FILES['imagen_quienes_somos']) && $_FILES['imagen_quienes_somos']['error'] == 0) {
        $imagen_quienes_somos = subir_imagen($_FILES['imagen_quienes_somos']);
    }

    if (empty($errores)) {
        $query = "UPDATE configuracion SET 
            colores = '$colores', 
            icono_principal = '$icono_principal', 
            icono_blanco = '$icono_blanco', 
            imagen_banner = '$imagen_banner', 
            mensaje_banner = '$mensaje_banner', 
            info_quienes_somos = '$info_quienes_somos', 
            imagen_quienes_somos = '$imagen_quienes_somos', 
            enlaces_facebook = '$enlaces_facebook', 
            enlaces_twitter = '$enlaces_twitter', 
            enlaces_instagram = '$enlaces_instagram', 
            direccion = '$direccion', 
            telefono = '$telefono', 
            email = '$email' 
            WHERE id = {$config['id']}";
        if ($conexion->query($query)) {
            header('Location: panel.php');
        } else {
            $errores[] = 'Error al actualizar';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Personalizar Página</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <label>Colores:</label>
        <select name="colores">
            <option value="azul,amarillo,gris" <?php if ($config['colores'] == 'azul,amarillo,gris') echo 'selected'; ?>>Azul, Amarillo, Gris</option>
            <option value="blanco,gris" <?php if ($config['colores'] == 'blanco,gris') echo 'selected'; ?>>Blanco, Gris</option>
        </select>
        <label>Ícono Principal:</label><input type="file" name="icono_principal">
        <label>Ícono Blanco:</label><input type="file" name="icono_blanco">
        <label>Imagen Banner:</label><input type="file" name="imagen_banner">
        <label>Mensaje Banner:</label><input type="text" name="mensaje_banner" value="<?php echo $config['mensaje_banner']; ?>" required>
        <label>Info Quienes Somos:</label><textarea name="info_quienes_somos" required><?php echo $config['info_quienes_somos']; ?></textarea>
        <label>Imagen Quienes Somos:</label><input type="file" name="imagen_quienes_somos">
        <label>Facebook:</label><input type="url" name="enlaces_facebook" value="<?php echo $config['enlaces_facebook']; ?>">
        <label>Twitter:</label><input type="url" name="enlaces_twitter" value="<?php echo $config['enlaces_twitter']; ?>">
        <label>Instagram:</label><input type="url" name="enlaces_instagram" value="<?php echo $config['enlaces_instagram']; ?>">
        <label>Dirección:</label><input type="text" name="direccion" value="<?php echo $config['direccion']; ?>" required>
        <label>Teléfono:</label><input type="text" name="telefono" value="<?php echo $config['telefono']; ?>" required>
        <label>Email:</label><input type="email" name="email" value="<?php echo $config['email']; ?>" required>
        <?php foreach ($errores as $err): ?><p class="error"><?php echo $err; ?></p><?php endforeach; ?>
        <button type="submit" name="actualizar">Actualizar</button>
    </form>
</body>
</html>