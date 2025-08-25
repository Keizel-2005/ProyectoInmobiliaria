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
<?php $config = obtener_config() ?? []; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Propiedades</title>
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
        <section class="mis-prop-section">
            <h2>Mis Propiedades</h2>
            <div class="tabla-prop-wrap">
                <table class="tabla-propiedades">
                    <tr><th>ID</th><th>Título</th><th>Tipo</th><th>Precio</th><th>Acciones</th></tr>
                    <?php foreach ($propiedades as $prop): ?>
                        <tr>
                            <td><?php echo $prop['id']; ?></td>
                            <td><?php echo $prop['titulo']; ?></td>
                            <td><?php echo ucfirst($prop['tipo']); ?></td>
                            <td>$<?php echo number_format($prop['precio'], 2); ?></td>
                            <td>
                                <a href="editar_propiedad.php?id=<?php echo $prop['id']; ?>" class="tabla-btn editar">Editar</a>
                                <a href="mis_propiedades.php?eliminar=<?php echo $prop['id']; ?>" class="tabla-btn eliminar" onclick="return confirm('¿Seguro?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </section>
    </main>
    <footer class="footer-copy">
        <p>Derechos reservados &copy; <?php echo date('Y'); ?> UTN Solutions Real State</p>
    </footer>
</body>
</html>