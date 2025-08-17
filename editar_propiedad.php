<?php
include 'funciones.php';
validar_sesion();
if (es_admin()) header('Location: panel.php');

$id = intval($_GET['id']);
$agente_id = $_SESSION['usuario_id'];
$query = "SELECT * FROM propiedades WHERE id = $id AND agente_id = $agente_id";
$prop = $conexion->query($query)->fetch_assoc();
if (!$prop) header('Location: mis_propiedades.php');

$errores = [];
if (isset($_POST['actualizar'])) {
    $tipo = $conexion->real_escape_string($_POST['tipo']);
    $destacada = isset($_POST['destacada']) ? 1 : 0;
    $titulo = $conexion->real_escape_string($_POST['titulo']);
    $desc_breve = $conexion->real_escape_string($_POST['desc_breve']);
    $precio = floatval($_POST['precio']);
    $desc_larga = $conexion->real_escape_string($_POST['desc_larga']);
    $mapa = $conexion->real_escape_string($_POST['mapa']);
    $ubicacion = $conexion->real_escape_string($_POST['ubicacion']);

    $imagen_destacada = $prop['imagen_destacada'];

    if (isset($_FILES['imagen_destacada']) && $_FILES['imagen_destacada']['error'] == 0) {
        $tmp_img = subir_imagen($_FILES['imagen_destacada']);
        if ($tmp_img === false) {
            $errores[] = 'La imagen debe ser JPG, PNG, GIF o WEBP y menor a 2MB.';
        } else {
            $imagen_destacada = $tmp_img;
        }
    }

    if (empty($titulo) || empty($desc_breve) || $precio <= 0) {
        $errores[] = 'Campos requeridos faltantes o inválidos';
    }

    if (empty($errores)) {
        $query = "UPDATE propiedades SET 
            tipo='$tipo', destacada=$destacada, titulo='$titulo', desc_breve='$desc_breve', precio=$precio, 
            imagen_destacada='$imagen_destacada', desc_larga='$desc_larga', mapa='$mapa', ubicacion='$ubicacion' 
            WHERE id=$id";
        if ($conexion->query($query)) {
            header('Location: mis_propiedades.php');
        } else {
            $errores[] = 'Error: ' . $conexion->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Editar Propiedad</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <label>Tipo:</label>
        <select name="tipo" required>
            <option value="alquiler" <?php if ($prop['tipo'] == 'alquiler') echo 'selected'; ?>>Alquiler</option>
            <option value="venta" <?php if ($prop['tipo'] == 'venta') echo 'selected'; ?>>Venta</option>
        </select>
        <label>Destacada:</label><input type="checkbox" name="destacada" <?php if ($prop['destacada']) echo 'checked'; ?>>
        <label>Título:</label><input type="text" name="titulo" value="<?php echo $prop['titulo']; ?>" required>
        <label>Descripción Breve:</label><textarea name="desc_breve" required><?php echo $prop['desc_breve']; ?></textarea>
        <label>Precio:</label><input type="number" name="precio" step="0.01" value="<?php echo $prop['precio']; ?>" required>
        <label>Imagen Destacada:</label><input type="file" name="imagen_destacada"> (Actual: <?php echo $prop['imagen_destacada']; ?>)
        <label>Descripción Larga:</label><textarea name="desc_larga" required><?php echo $prop['desc_larga']; ?></textarea>
        <label>Mapa (embed):</label><textarea name="mapa"><?php echo $prop['mapa']; ?></textarea>
        <label>Ubicación:</label><input type="text" name="ubicacion" value="<?php echo $prop['ubicacion']; ?>" required>
        <?php foreach ($errores as $err): ?><p class="error"><?php echo $err; ?></p><?php endforeach; ?>
        <button type="submit" name="actualizar">Actualizar</button>
    </form>
</body>
</html>