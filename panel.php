<?php
// panel.php - Panel según rol
include 'funciones.php';
validar_sesion();

$usuario_id = $_SESSION['usuario_id'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Panel de Control</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Bienvenido al Panel</h1>
    <?php if (es_admin()): ?>
        <a href="personalizar.php">Personalizar Página</a><br>
        <a href="usuarios.php">Gestionar Usuarios</a><br>
    <?php else: ?>
        <a href="agregar_propiedad.php">Agregar Propiedad</a><br>
        <a href="mis_propiedades.php">Mis Propiedades</a><br>
    <?php endif; ?>
    <a href="actualizar_datos.php">Actualizar Datos Personales</a><br>
    <a href="cerrar_sesion.php">Cerrar Sesión</a>
</body>
</html>