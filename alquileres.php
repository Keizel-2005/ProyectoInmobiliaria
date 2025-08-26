<?php
include 'funciones.php';
$config = obtener_config() ?? [];
$alquileres = obtener_propiedades('alquiler');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Propiedades en Alquiler</title>
    <link rel="stylesheet" href="styles/estilos.css">
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
    <?php session_start(); ?>
    <header>
       <div class="logo">
            <img src="imagenes/<?php echo $config['icono_principal'] ?? 'logo.png'; ?>" alt="Logo UTN Solutions" style="width: 50px; height: 50px; vertical-align: middle; margin-right: 10px;">
            UTN Solutions Real State
        </div>
        <div class="header-menu-wrap">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <a href="panel.php" class="login-btn">Volver</a>
            <?php else: ?>
                <a href="index.php" class="login-btn">Inicio</a>
            <?php endif; ?>
        </div>
    </header>
  
    <main>
        <section class="propiedades">
            <h2>Propiedades en Alquiler</h2>
            <div class="propiedades-grid">
                <?php if (empty($alquileres)): ?>
                    <p style="width:100%;text-align:center;color:var(--color-gris, #888);font-size:1.1rem;">No hay propiedades en alquiler disponibles en este momento.</p>
                <?php else: ?>
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
                <?php endif; ?>
            </div>
        </section>
    </main>
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