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
</head>
<body>
    <header>
       <div class="logo">
            <img src="imagenes/logo.png" alt="" style="width: 50px; height: 50px; vertical-align: middle; margin-right: 10px;">
            UTN Solutions Real State
        </div>
        <div class="header-menu-wrap">
            <a href="login.php" class="login-btn">
                <img src="imagenes/login.png" alt="Login" style="width: 32px; height: 32px; vertical-align: middle;">
            </a>
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
                    <li><a href="cerrar_sesion.php" class="logout-btn" style="color:var(--color-eliminar, #d32f2f);font-weight:bold;">Cerrar sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>
</body>
</html>
    <section class="banner">
        <img src="imagenes/<?php echo $config['imagen_banner'] ?? 'casaInicio.jpg'; ?>" alt="">
        <h1><?php echo $config['mensaje_banner'] ?? 'BIENVENIDO AL PANEL'; ?></h1>
    </section>
    <section id="quienes-somos" class="quienes-somos">
        <div>
            <h2>Quienes Somos</h2>
            <p><?php echo $config['info_quienes_somos'] ?? 'Somos un equipo apasionado por el sector inmobiliario, comprometido en ayudarte a encontrar la 
            propiedad ideal para ti y tu familia. Nos destacamos por nuestro profesionalismo, atención personalizada y conocimiento del mercado, brindando soluciones confiables y acompañamiento en cada paso del proceso. ¡Permítenos ayudarte a cumplir tus sueños!'; ?></p>
        </div>
        <div class="quienes-img">
            <img src="imagenes/quienesSomos.jpg" alt="Equipo">
        </div>
    </section>
    <?php
   
    if (es_admin()) {
        $destacadas = obtener_propiedades(null, 1, 3);
        $ventas = obtener_propiedades('venta', null, 3);
        $alquileres = obtener_propiedades('alquiler', null, 3);
    } else {
     
        global $conexion;
        $usuario_id = $_SESSION['usuario_id'];
        $destacadas = $conexion->query("SELECT p.*, u.nombre AS agente_nombre FROM propiedades p LEFT JOIN usuarios u ON p.agente_id = u.id WHERE p.agente_id = $usuario_id AND destacada = 1 ORDER BY p.id DESC LIMIT 3")->fetch_all(MYSQLI_ASSOC);
        $ventas = $conexion->query("SELECT p.*, u.nombre AS agente_nombre FROM propiedades p LEFT JOIN usuarios u ON p.agente_id = u.id WHERE p.agente_id = $usuario_id AND tipo = 'venta' ORDER BY p.id DESC LIMIT 3")->fetch_all(MYSQLI_ASSOC);
        $alquileres = $conexion->query("SELECT p.*, u.nombre AS agente_nombre FROM propiedades p LEFT JOIN usuarios u ON p.agente_id = u.id WHERE p.agente_id = $usuario_id AND tipo = 'alquiler' ORDER BY p.id DESC LIMIT 3")->fetch_all(MYSQLI_ASSOC);
    }
    ?>
    <section class="propiedades">
        <h2>Propiedades Destacadas</h2>
        <div class="propiedades-grid">
            <?php foreach ($destacadas as $prop): ?>
                <div class="propiedad-card">
                    <img src="<?php echo $prop['imagen_destacada']; ?>" alt="<?php echo $prop['titulo']; ?>">
                    <div>
                        <h3><?php echo $prop['titulo']; ?></h3>
                        <p><?php echo $prop['desc_breve']; ?></p>
                        <p>Precio: $<?php echo number_format($prop['precio'], 2); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="propiedades ventas-blanco">
        <h2>Propiedades en Venta</h2>
        <div class="propiedades-grid">
            <?php foreach ($ventas as $prop): ?>
                <div class="propiedad-card">
                    <img src="<?php echo $prop['imagen_destacada']; ?>" alt="<?php echo $prop['titulo']; ?>">
                    <div>
                        <h3><?php echo $prop['titulo']; ?></h3>
                        <p><?php echo $prop['desc_breve']; ?></p>
                        <p>Precio: $<?php echo number_format($prop['precio'], 2); ?></p>
                        <a href="propiedad.php?id=<?php echo $prop['id']; ?>">Ver más</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="ventas.php" class="ver-mas">Ver más</a>
    </section>
    <section class="propiedades">
        <h2>Propiedades en Alquiler</h2>
        <div class="propiedades-grid">
            <?php foreach ($alquileres as $prop): ?>
                <div class="propiedad-card">
                    <img src="<?php echo $prop['imagen_destacada']; ?>" alt="<?php echo $prop['titulo']; ?>">
                    <div>
                        <h3><?php echo $prop['titulo']; ?></h3>
                        <p><?php echo $prop['desc_breve']; ?></p>
                        <p>Precio: $<?php echo number_format($prop['precio'], 2); ?></p>
                        <a href="propiedad.php?id=<?php echo $prop['id']; ?>">Ver más</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="alquileres.php" class="ver-mas">Ver más</a>
    </section>
    <footer id="contacto">
        <div class="footer-info">
            <p><img src="imagenes/marcador.png" alt="Dirección" class="footer-icon"> <span class="footer-label">Dirección:</span> <?php echo $config['direccion'] ?? 'Dirección Ejemplo'; ?></p>
            <p><img src="imagenes/telefono.png" alt="Teléfono" class="footer-icon"> <span class="footer-label">Teléfono:</span> <?php echo $config['telefono'] ?? '8888-8888'; ?></p>
            <p><img src="imagenes/email.png" alt="Email" class="footer-icon"> <span class="footer-label">Email:</span> <?php echo $config['email'] ?? 'info@utnsolutions.com'; ?></p>
        </div>
        <form class="footer-form" action="enviar_contacto.php" method="post">
            <h3>Contactanos</h3>
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="telefono" placeholder="Teléfono" required>
            <textarea name="mensaje" placeholder="Mensaje" required></textarea>
            <button type="submit">Enviar</button>
        </form>
        <div class="footer-redes-wrap">
            <div class="redes">
                <a href="<?php echo $config['enlaces_facebook'] ?? '#'; ?>"><img src="imagenes/facebook.png" alt="Facebook"></a>
                <a href="<?php echo $config['enlaces_twitter'] ?? '#'; ?>"><img src="imagenes/youtube.png" alt="Youtube"></a>
                <a href="<?php echo $config['enlaces_instagram'] ?? '#'; ?>"><img src="imagenes/instagram.png" alt="Instagram"></a>
            </div>
        </div>
    </footer>
    <footer class="footer-copy">
        <p>Derechos reservados &copy; <?php echo date('Y'); ?> UTN Solutions Real State</p>
    </footer>
</body>
</html>