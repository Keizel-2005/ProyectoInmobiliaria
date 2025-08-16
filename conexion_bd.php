<?php
$servidor = "localhost";
$usuario_bd = "root"; 
$contrasena_bd = ""; 
$nombre_bd = "proyecto";

$conexion = new mysqli($servidor, $usuario_bd, $contrasena_bd, $nombre_bd);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");
?>