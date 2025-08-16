<?php
// index.php - Página principal
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
        <div class="logo">UTN Solutions Real State</div>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="#quienes-somos">Quienes Somos</a></li>
                <li><a href="alquileres.php">Alquileres</a></li>
                <li><a href="ventas.php">Ventas</a></li>
                <li><a href="#contacto">Contactenos</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>
    <section class="banner">
        <img src="<?php echo $config['imagen_banner'] ?? 'banner.jpg'; ?>" alt="Banner">
        <h1><?php echo $config['mensaje_banner'] ?? 'PERMITENOS AYUDARTE A CUMPLIR TUS SUEÑOS'; ?></h1>
    </section>
    <section id="quienes-somos" class="quienes-somos">
        <div>
            <h2>Quienes Somos</h2>
            <p><?php echo $config['info_quienes_somos'] ?? 'Somos una empresa dedicada a...'; ?></p>
        </div>
        <img src="<?php echo $config['imagen_quienes_somos'] ?? 'equipo.jpg'; ?>" alt="Equipo">
    </section>
    <form class="busqueda-form" method="post">
        <input type="text" name="busqueda" placeholder="Buscar propiedades..." required>
        <button type="submit" name="buscar">Buscar</button>
    </form>
    <?php if (!empty($propiedades_busqueda)): ?>
    <section class="propiedades">
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
                        <a href="propiedad.php?id=<?php echo $prop['id']; ?>">Ver más</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="ventas.php" class="ver-mas">Ver más</a>
    </section>
    <section class="propiedades">
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
        <p>Dirección: <?php echo $config['direccion'] ?? 'Dirección Ejemplo'; ?> | Teléfono: <?php echo $config['telefono'] ?? '8888-8888'; ?> | Email: <?php echo $config['email'] ?? 'info@utnsolutions.com'; ?></p>
        <form action="enviar_contacto.php" method="post">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="email" name="email" placeholder="Email" required>
            <textarea name="mensaje" placeholder="Mensaje" required></textarea>
            <button type="submit">Enviar</button>
        </form>
        <div class="redes">
            <a href="<?php echo $config['enlaces_facebook'] ?? '#'; ?>"><img src="facebook.png" alt="Facebook"></a>
            <a href="<?php echo $config['enlaces_twitter'] ?? '#'; ?>"><img src="twitter.png" alt="Twitter"></a>
            <a href="<?php echo $config['enlaces_instagram'] ?? '#'; ?>"><img src="instagram.png" alt="Instagram"></a>
        </div>
    </footer>
</body>
</html>