<?php
include 'funciones.php';
$id = intval($_GET['id']);
$query = "SELECT p.*, u.nombre AS agente_nombre FROM propiedades p LEFT JOIN usuarios u ON p.agente_id = u.id WHERE p.id = $id";
$prop = $conexion->query($query)->fetch_assoc();
if (!$prop) header('Location: index.php');

session_start();
$es_propietario = isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $prop['agente_id'];
$es_admin = es_admin();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title><?php echo $prop['titulo']; ?></title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1><?php echo $prop['titulo']; ?></h1>
    <img src="<?php echo $prop['imagen_destacada']; ?>" alt="<?php echo $prop['titulo']; ?>">
    <p><?php echo $prop['desc_larga']; ?></p>
    <p>Precio: $<?php echo number_format($prop['precio'], 2); ?></p>
    <p>Ubicación: <?php echo $prop['ubicacion']; ?></p>
    <p>Agente: <?php echo $prop['agente_nombre']; ?></p>
    <div><?php echo $prop['mapa']; ?></div>
    <?php if ($es_propietario || $es_admin): ?>
        <a href="editar_propiedad.php?id=<?php echo $id; ?>">Editar</a>
        <a href="mis_propiedades.php?eliminar=<?php echo $id; ?>" onclick="return confirm('¿Seguro?');">Eliminar</a>
    <?php endif; ?>
</body>
</html>