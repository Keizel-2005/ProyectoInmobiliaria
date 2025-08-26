<?php
include 'funciones.php';
validar_sesion();
if (!es_admin()) header('Location: index.php');

$config = obtener_config() ?? [];
$errores = [];

if (isset($_POST['actualizar'])) {
    $color_primario = $conexion->real_escape_string($_POST['color_primario']);
    $color_secundario = $conexion->real_escape_string($_POST['color_secundario']);
    $color_fondo = $conexion->real_escape_string($_POST['color_fondo']);
    
    if (strpos($color_primario, '#') !== 0) $color_primario = '#18183a';
    if (strpos($color_secundario, '#') !== 0) $color_secundario = '#ffd600';
    if (strpos($color_fondo, '#') !== 0) $color_fondo = '#f8f8fa';
    $colores = $color_primario . ',' . $color_secundario . ',' . $color_fondo;
    $mensaje_banner = $conexion->real_escape_string($_POST['mensaje_banner']);
    $info_quienes_somos = $conexion->real_escape_string($_POST['info_quienes_somos']);
    $direccion = $conexion->real_escape_string($_POST['direccion']);
    $telefono = $conexion->real_escape_string($_POST['telefono']);
    $email = $conexion->real_escape_string($_POST['email']);
    $enlaces_facebook = $conexion->real_escape_string($_POST['enlaces_facebook']);
    $enlaces_twitter = $conexion->real_escape_string($_POST['enlaces_twitter']);
    $enlaces_instagram = $conexion->real_escape_string($_POST['enlaces_instagram']);

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
            header('Location: personalizar.php?success=1'); 
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
    <link rel="stylesheet" href="styles/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php
    
    $colores = $config['colores'] ?? 'azul,amarillo,gris';
    $css_vars = '';
    if ($colores === 'azul,amarillo,gris') {
        $css_vars = ':root { --color-primario: #18183a; --color-secundario: #ffd600; --color-fondo: #f8f8fa; --color-texto: #22223b; --color-blanco: #fff; --color-gris: #e0e0e0; }';
    } elseif ($colores === 'blanco,gris') {
        $css_vars = ':root { --color-primario: #22223b; --color-secundario: #e0e0e0; --color-fondo: #fff; --color-texto: #18183a; --color-blanco: #fff; --color-gris: #e0e0e0; }';
    }
    if ($css_vars) {
        echo '<style>' . $css_vars . '</style>';
    }
    ?>
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
            <label>Colores personalizados:</label>
            <?php
                $colores_actuales = explode(',', $config['colores'] ?? '#18183a,#ffd600,#f8f8fa');
                $color_primario = $colores_actuales[0] ?? '#18183a';
                $color_secundario = $colores_actuales[1] ?? '#ffd600';
                $color_fondo = $colores_actuales[2] ?? '#f8f8fa';
            ?>
            <div style="display:flex;gap:18px;align-items:center;margin-bottom:12px;">
                <div>
                    <label for="color_primario" style="font-weight:500;">Primario:</label>
                    <input type="color" id="color_primario" name="color_primario" value="<?php echo htmlspecialchars($color_primario); ?>">
                </div>
                <div>
                    <label for="color_secundario" style="font-weight:500;">Secundario:</label>
                    <input type="color" id="color_secundario" name="color_secundario" value="<?php echo htmlspecialchars($color_secundario); ?>">
                </div>
                <div>
                    <label for="color_fondo" style="font-weight:500;">Fondo:</label>
                    <input type="color" id="color_fondo" name="color_fondo" value="<?php echo htmlspecialchars($color_fondo); ?>">
                </div>
            </div>
<head>
    <title>Personalizar Página</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php
    // Definir variables CSS según la selección de colores personalizados
    $colores_actuales = explode(',', $config['colores'] ?? '#18183a,#ffd600,#f8f8fa');
    $color_primario = $colores_actuales[0] ?? '#18183a';
    $color_secundario = $colores_actuales[1] ?? '#ffd600';
    $color_fondo = $colores_actuales[2] ?? '#f8f8fa';
    echo '<style>:root {';
    echo '--color-primario: ' . htmlspecialchars($color_primario) . ';';
    echo '--color-secundario: ' . htmlspecialchars($color_secundario) . ';';
    echo '--color-fondo: ' . htmlspecialchars($color_fondo) . ';';
    echo '--color-texto: #22223b; --color-blanco: #fff; --color-gris: #e0e0e0;';
    echo '}</style>';
    ?>
</head>

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