<?php
include 'funciones.php';
validar_sesion();
if (es_admin()) header('Location: panel.php');

$errores = [];
if (isset($_POST['agregar'])) {
    $tipo = $conexion->real_escape_string($_POST['tipo']);
    $destacada = isset($_POST['destacada']) ? 1 : 0;
    $titulo = $conexion->real_escape_string($_POST['titulo']);
    $desc_breve = $conexion->real_escape_string($_POST['desc_breve']);
    $precio = floatval($_POST['precio']);
    $desc_larga = $conexion->real_escape_string($_POST['desc_larga']);
    $mapa = $conexion->real_escape_string($_POST['mapa']);
    $ubicacion = $conexion->real_escape_string($_POST['ubicacion']);
    $agente_id = $_SESSION['usuario_id'];

    $imagen_destacada = '';

    if (isset($_FILES['imagen_destacada']) && $_FILES['imagen_destacada']['error'] == 0) {
        $imagen_destacada = subir_imagen($_FILES['imagen_destacada']);
        if ($imagen_destacada === false) {
            $errores[] = 'La imagen debe ser JPG, PNG, GIF o WEBP y menor a 2MB.';
        }
    }

    if (empty($titulo) || empty($desc_breve) || $precio <= 0 || empty($imagen_destacada)) {
        $errores[] = 'Campos requeridos faltantes o inválidos';
    }

    if (empty($errores)) {
        $query = "INSERT INTO propiedades (tipo, destacada, titulo, desc_breve, precio, agente_id, imagen_destacada, desc_larga, mapa, ubicacion) 
                  VALUES ('$tipo', $destacada, '$titulo', '$desc_breve', $precio, $agente_id, '$imagen_destacada', '$desc_larga', '$mapa', '$ubicacion')";
        if ($conexion->query($query)) {
            header('Location: mis_propiedades.php');
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
    <title>Agregar Propiedad</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="icon" href="<?php echo $config['icono_principal'] ?? 'icono.png'; ?>">
</head>
<body>
    <header>
        <div class="logo">UTN Solutions Real State</div>
        <div class="header-menu-wrap">
            <a href="panel.php" class="login-btn">Volver</a>
            
    </header>
    <main>
        <section class="form-section">
            <h2>Agregar Propiedad</h2>
            <form class="form-propiedad" method="post" enctype="multipart/form-data">
                <label>Tipo:</label>
                <select name="tipo" required>
                    <option value="alquiler">Alquiler</option>
                    <option value="venta">Venta</option>
                </select>
                <label><input type="checkbox" name="destacada"> Destacada</label>
                <label>Título:</label><input type="text" name="titulo" required>
                <label>Descripción Breve:</label><textarea name="desc_breve" required></textarea>
                <label>Precio:</label><input type="number" name="precio" step="0.01" required>
                <label>Imagen Destacada:</label><input type="file" name="imagen_destacada" required>
                <label>Descripción Larga:</label><textarea name="desc_larga" required></textarea>
                <label>Mapa (embed):</label><textarea name="mapa"></textarea>
                <label>Ubicación:</label><input type="text" name="ubicacion" required>
                <?php foreach ($errores as $err): ?><p class="error"><?php echo $err; ?></p><?php endforeach; ?>
                <button type="submit" name="agregar">Agregar</button>
            </form>
        </section>
    </main>
    <footer class="footer-copy">
        <p>Derechos reservados &copy; <?php echo date('Y'); ?> UTN Solutions Real State</p>
    </footer>
</body>
</html>