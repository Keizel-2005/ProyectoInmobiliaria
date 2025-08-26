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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
    <header>
       <div class="logo">
            <img src="imagenes/<?php echo $config['icono_principal'] ?? 'logo.png'; ?>" alt="Logo UTN Solutions" style="width: 50px; height: 50px; vertical-align: middle; margin-right: 10px;">
            UTN Solutions Real State
        </div>
        <div class="header-menu-wrap">
            <a href="index.php" class="login-btn">Volver</a>
        </div>
    </header>
    <div class="prop-container">
        <div class="prop-img">
            <img src="<?php echo $prop['imagen_destacada']; ?>" alt="<?php echo $prop['titulo']; ?>">
        </div>
        <div class="prop-info">
            <h1><?php echo $prop['titulo']; ?></h1>
            <div class="desc"><?php echo $prop['desc_larga']; ?></div>
            <div class="precio"><i class="fa-solid fa-tag"></i> $<?php echo number_format($prop['precio'], 2); ?></div>
            <div class="ubicacion"><i class="fa-solid fa-location-dot"></i> <?php echo $prop['ubicacion']; ?></div>
            <div class="agente"><i class="fa-solid fa-user-tie"></i> Agente: <?php echo $prop['agente_nombre']; ?></div>
            <div class="mapa"> <?php echo $prop['mapa']; ?> </div>
            <?php if ($es_propietario || $es_admin): ?>
            <div class="prop-actions">
                <a href="editar_propiedad.php?id=<?php echo $id; ?>" class="prop-btn"><i class="fa-solid fa-pen-to-square"></i> Editar</a>
                <a href="mis_propiedades.php?eliminar=<?php echo $id; ?>" class="prop-btn" style="background:var(--color-eliminar, #d32f2f); color:var(--color-blanco, #fff);" onclick="return confirm('¿Seguro?');"><i class="fa-solid fa-trash"></i> Eliminar</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
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