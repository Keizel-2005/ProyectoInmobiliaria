<?php
include 'funciones.php';
$config = obtener_config() ?? [];
$destacadas = obtener_propiedades(null, 1, 3);
$ventas = obtener_propiedades('venta', null, 3);
$alquileres = obtener_propiedades('alquiler', null, 3);

$propiedades_busqueda = [];
if (isset($_POST['buscar'])) {
    $busqueda = $_POST['busqueda'];
    $propiedades_busqueda = buscar_propiedades($busqueda);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>UTN Solutions Real State</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="icon" href="<?php echo $config['icono_principal'] ?? 'icono.png'; ?>">
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
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="#quienes-somos">Quienes Somos</a></li>
                    <li><a href="alquileres.php">Alquileres</a></li>
                    <li><a href="ventas.php">Ventas</a></li>
                    <li><a href="#contacto">Contactenos</a></li>
                </ul>
                <form class="busqueda-form" method="post">
                    <input type="text" name="busqueda" placeholder="Buscar propiedades..." required>
                    <button type="submit" name="buscar">Buscar</button>
                </form>
            </nav>
        </div>
    </header>
    <?php if (!empty($propiedades_busqueda)): ?>
        <section class="propiedades" style="margin-bottom: 0;">
            <h2>Resultados de Búsqueda</h2>
            <div class="propiedades-grid">
                <?php foreach ($propiedades_busqueda as $prop): ?>
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
        </section>
    <?php endif; ?>
    <section class="banner">
        <img src="<?php echo $config['imagen_banner'] ?? 'casaInicio.jpg'; ?>" alt="">
        <h1><?php echo $config['mensaje_banner'] ?? 'PERMITENOS AYUDARTE A CUMPLIR TUS SUEÑOS'; ?></h1>
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