<?php
// ventas.php - Lista todas las ventas
include 'funciones.php';
$ventas = obtener_propiedades('venta');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Propiedades en Venta</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header><!-- Copiar header de index si se quiere --></header>
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
    </section>
    <footer><!-- Copiar footer si se quiere --></footer>
</body>
</html>