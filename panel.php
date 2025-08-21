<?php
include 'funciones.php';
validar_sesion();
$config = obtener_config() ?? [];
$usuario_id = $_SESSION['usuario_id'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="icon" href="<?php echo $config['icono_principal'] ?? 'icono.png'; ?>">
</head>
<body>
    <header>
        <div class="logo">UTN Solutions Real State</div>
        <div class="header-menu-wrap">
            <a href="cerrar_sesion.php" class="login-btn">Cerrar Sesión</a>
            <nav class="main-nav">
                <ul>
                    <?php if (es_admin()): ?>
                        <li><a href="panel.php">Panel</a></li>
                        <li><a href="personalizar.php">Personalizar Página</a></li>
                        <li><a href="usuarios.php">Gestionar Usuarios</a></li>
                    <?php else: ?>
                        <li><a href="panel.php">Panel</a></li>
                        <li><a href="agregar_propiedad.php">Agregar Propiedad</a></li>
                        <li><a href="mis_propiedades.php">Mis Propiedades</a></li>
                    <?php endif; ?>
                    <li><a href="actualizar_datos.php">Actualizar Datos</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <section class="banner">
        <img src="<?php echo $config['imagen_banner'] ?? 'banner.jpg'; ?>" alt="Banner">
        <h1>Bienvenido al Panel</h1>
    </section>
    <main>
    </main>
    <footer class="footer-copy">
        <p>Derechos reservados &copy; <?php echo date('Y'); ?> UTN Solutions Real State</p>
    </footer>
</body>
</html>