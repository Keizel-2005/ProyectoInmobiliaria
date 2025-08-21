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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo">UTN Solutions Real State</div>
        <div class="header-menu-wrap">
            <a href="panel.php" class="login-btn">Volver</a>
        </div>
    </header>
    <section class="form-section">
        <h2>Personalizar Página</h2>
        <form class="form-propiedad" method="post" enctype="multipart/form-data" autocomplete="off">
            <label for="colores">Colores:</label>
            <select id="colores" name="colores">
                <option value="azul,amarillo,gris" <?php if ($config['colores'] == 'azul,amarillo,gris') echo 'selected'; ?>>Azul, Amarillo, Gris</option>
                <option value="blanco,gris" <?php if ($config['colores'] == 'blanco,gris') echo 'selected'; ?>>Blanco, Gris</option>
            </select>
            <label for="icono_principal"><i class="fa-solid fa-image"></i> Ícono Principal:</label>
            <input type="file" id="icono_principal" name="icono_principal">
            <label for="icono_blanco"><i class="fa-solid fa-image"></i> Ícono Blanco:</label>
            <input type="file" id="icono_blanco" name="icono_blanco">
            <label for="imagen_banner"><i class="fa-solid fa-image"></i> Imagen Banner:</label>
            <input type="file" id="imagen_banner" name="imagen_banner">
            <label for="mensaje_banner">Mensaje Banner:</label>
            <input type="text" id="mensaje_banner" name="mensaje_banner" value="<?php echo $config['mensaje_banner']; ?>" required>
            <label for="info_quienes_somos">Info Quienes Somos:</label>
            <textarea id="info_quienes_somos" name="info_quienes_somos" required><?php echo $config['info_quienes_somos']; ?></textarea>
            <label for="imagen_quienes_somos"><i class="fa-solid fa-image"></i> Imagen Quienes Somos:</label>
            <input type="file" id="imagen_quienes_somos" name="imagen_quienes_somos">
            <label for="enlaces_facebook"><i class="fa-brands fa-facebook"></i> Facebook:</label>
            <input type="url" id="enlaces_facebook" name="enlaces_facebook" value="<?php echo $config['enlaces_facebook']; ?>">
            <label for="enlaces_twitter"><i class="fa-brands fa-x-twitter"></i> Twitter:</label>
            <input type="url" id="enlaces_twitter" name="enlaces_twitter" value="<?php echo $config['enlaces_twitter']; ?>">
            <label for="enlaces_instagram"><i class="fa-brands fa-instagram"></i> Instagram:</label>
            <input type="url" id="enlaces_instagram" name="enlaces_instagram" value="<?php echo $config['enlaces_instagram']; ?>">
            <label for="direccion"><i class="fa-solid fa-location-dot"></i> Dirección:</label>
            <input type="text" id="direccion" name="direccion" value="<?php echo $config['direccion']; ?>" required>
            <label for="telefono"><i class="fa-solid fa-phone"></i> Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo $config['telefono']; ?>" required>
            <label for="email"><i class="fa-solid fa-envelope"></i> Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $config['email']; ?>" required>
            <?php foreach ($errores as $err): ?><p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $err; ?></p><?php endforeach; ?>
            <button type="submit" name="actualizar"><i class="fa-solid fa-floppy-disk"></i> Actualizar</button>
        </form>
    </section>
</body>
</html>