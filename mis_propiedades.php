<?php
include 'funciones.php';
validar_sesion();
if (es_admin()) header('Location: panel.php');

$agente_id = $_SESSION['usuario_id'];
$propiedades = $conexion->query("SELECT * FROM propiedades WHERE agente_id = $agente_id ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);

if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $query = "DELETE FROM propiedades WHERE id = $id AND agente_id = $agente_id";
    $conexion->query($query);
    header('Location: mis_propiedades.php');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Mis Propiedades</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h2>Mis Propiedades</h2>
    <table>
        <tr><th>ID</th><th>Título</th><th>Tipo</th><th>Precio</th><th>Acciones</th></tr>
        <?php foreach ($propiedades as $prop): ?>
            <tr>
                <td><?php echo $prop['id']; ?></td>
                <td><?php echo $prop['titulo']; ?></td>
                <td><?php echo ucfirst($prop['tipo']); ?></td>
                <td>$<?php echo number_format($prop['precio'], 2); ?></td>
                <td><a href="editar_propiedad.php?id=<?php echo $prop['id']; ?>">Editar</a> | <a href="mis_propiedades.php?eliminar=<?php echo $prop['id']; ?>" onclick="return confirm('¿Seguro?');">Eliminar</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>