<?php
include 'funciones.php';
validar_sesion();
if (!es_admin()) header('Location: index.php');

$config = obtener_config() ?? [];
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
    $icono_principal = $config['icono_principal'] ?? '';
    if (isset($_FILES['icono_principal']) && $_FILES['icono_principal']['error'] == 0) {
        $nuevo_icono = subir_imagen($_FILES['icono_principal']);
        if ($nuevo_icono) $icono_principal = $nuevo_icono;
    }
    $icono_blanco = $config['icono_blanco'] ?? '';
    if (isset($_FILES['icono_blanco']) && $_FILES['icono_blanco']['error'] == 0) {
        $nuevo_icono = subir_imagen($_FILES['icono_blanco']);
        if ($nuevo_icono) $icono_blanco = $nuevo_icono;
    }
    $imagen_banner = $config['imagen_banner'] ?? '';
    if (isset($_FILES['imagen_banner']) && $_FILES['imagen_banner']['error'] == 0) {
        $nueva_imagen = subir_imagen($_FILES['imagen_banner']);
        if ($nueva_imagen) $imagen_banner = $nueva_imagen;
    }
    $imagen_quienes_somos = $config['imagen_quienes_somos'] ?? '';
    if (isset($_FILES['imagen_quienes_somos']) && $_FILES['imagen_quienes_somos']['error'] == 0) {
        $nueva_imagen = subir_imagen($_FILES['imagen_quienes_somos']);
        if ($nueva_imagen) $imagen_quienes_somos = $nueva_imagen;
    }

    if (empty($errores)) {
        $query = "REPLACE INTO configuracion (id, colores, icono_principal, icono_blanco, imagen_banner, mensaje_banner, info_quienes_somos, imagen_quienes_somos, enlaces_facebook, enlaces_twitter, enlaces_instagram, direccion, telefono, email)
                  VALUES (1, '$colores', '$icono_principal', '$icono_blanco', '$imagen_banner', '$mensaje_banner', '$info_quienes_somos', '$imagen_quienes_somos', '$enlaces_facebook', '$enlaces_twitter', '$enlaces_instagram', '$direccion', '$telefono', '$email')";
        if ($conexion->query($query)) {
            header('Location: personalizar.php?success=1'); // Recarga con mensaje de éxito
        } else {
            $errores[] = 'Error al actualizar: ' . $conexion->error;
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
      <div class="logo">
            <img src="imagenes/<?php echo $config['icono_principal'] ?? 'logo.png'; ?>" alt="Logo UTN Solutions" style="width: 50px; height: 50px; vertical-align: middle; margin-right: 10px;">
            UTN Solutions Real State
        </div>        
        <div class="header-menu-wrap">
            <a href="panel.php" class="login-btn">Volver</a>
        </div>
    </header>
    <section class="form-section">
        <h2>Personalizar Página</h2>
        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <p class="success"><i class="fa-solid fa-check"></i> Cambios guardados con éxito.</p>
        <?php endif; ?>
        <form class="form-propiedad" method="post" enctype="multipart/form-data" autocomplete="off">
            <label for="colores">Colores:</label>
            <select id="colores" name="colores">
                <option value="azul,amarillo,gris" <?php echo ($config['colores'] ?? 'azul,amarillo,gris') === 'azul,amarillo,gris' ? 'selected' : ''; ?>>Azul, Amarillo, Gris</option>
                <option value="blanco,gris" <?php echo ($config['colores'] ?? 'azul,amarillo,gris') === 'blanco,gris' ? 'selected' : ''; ?>>Blanco, Gris</option>
            </select>
            <label for="icono_principal"><i class="fa-solid fa-image"></i> Ícono Principal:</label>
            <input type="file" id="icono_principal" name="icono_principal">
            <?php if (!empty($config['icono_principal'])): ?>
                <p>Imagen actual: <img src="imagenes/<?php echo htmlspecialchars($config['icono_principal']); ?>" alt="Ícono Principal" style="max-width: 100px;"></p>
            <?php endif; ?>
            <label for="icono_blanco"><i class="fa-solid fa-image"></i> Ícono Blanco:</label>
            <input type="file" id="icono_blanco" name="icono_blanco">
            <?php if (!empty($config['icono_blanco'])): ?>
                <p>Imagen actual: <img src="imagenes/<?php echo htmlspecialchars($config['icono_blanco']); ?>" alt="Ícono Blanco" style="max-width: 100px;"></p>
            <?php endif; ?>
            <label for="imagen_banner"><i class="fa-solid fa-image"></i> Imagen Banner:</label>
            <input type="file" id="imagen_banner" name="imagen_banner">
            <?php if (!empty($config['imagen_banner'])): ?>
                <p>Imagen actual: <img src="imagenes/<?php echo htmlspecialchars($config['imagen_banner']); ?>" alt="Banner" style="max-width: 200px;"></p>
            <?php endif; ?>
            <label for="mensaje_banner">Mensaje Banner:</label>
            <input type="text" id="mensaje_banner" name="mensaje_banner" value="<?php echo htmlspecialchars($config['mensaje_banner'] ?? ''); ?>" required>
            <label for="info_quienes_somos">Info Quienes Somos:</label>
            <textarea id="info_quienes_somos" name="info_quienes_somos" required><?php echo htmlspecialchars($config['info_quienes_somos'] ?? ''); ?></textarea>
            <label for="imagen_quienes_somos"><i class="fa-solid fa-image"></i> Imagen Quienes Somos:</label>
            <input type="file" id="imagen_quienes_somos" name="imagen_quienes_somos">
            <?php if (!empty($config['imagen_quienes_somos'])): ?>
                <p>Imagen actual: <img src="imagenes/<?php echo htmlspecialchars($config['imagen_quienes_somos']); ?>" alt="Quienes Somos" style="max-width: 200px;"></p>
            <?php endif; ?>
            <label for="enlaces_facebook"><i class="fa-brands fa-facebook"></i> Facebook:</label>
            <input type="url" id="enlaces_facebook" name="enlaces_facebook" value="<?php echo htmlspecialchars($config['enlaces_facebook'] ?? ''); ?>">
            <label for="enlaces_twitter"><i class="fa-brands fa-x-twitter"></i> Twitter:</label>
            <input type="url" id="enlaces_twitter" name="enlaces_twitter" value="<?php echo htmlspecialchars($config['enlaces_twitter'] ?? ''); ?>">
            <label for="enlaces_instagram"><i class="fa-brands fa-instagram"></i> Instagram:</label>
            <input type="url" id="enlaces_instagram" name="enlaces_instagram" value="<?php echo htmlspecialchars($config['enlaces_instagram'] ?? ''); ?>">
            <label for="direccion"><i class="fa-solid fa-location-dot"></i> Dirección:</label>
            <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($config['direccion'] ?? ''); ?>" required>
            <label for="telefono"><i class="fa-solid fa-phone"></i> Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($config['telefono'] ?? ''); ?>" required>
            <label for="email"><i class="fa-solid fa-envelope"></i> Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($config['email'] ?? ''); ?>" required>
            <?php foreach ($errores as $err): ?><p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $err; ?></p><?php endforeach; ?>
            <button type="submit" name="actualizar"><i class="fa-solid fa-floppy-disk"></i> Actualizar</button>
        </form>
    </section>
</body>
</html>