<?php
include 'conexion_bd.php';
function encriptar_contrasena($contrasena) {
    return md5($contrasena);
}

function validar_sesion() {
    session_start();
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
    exit();
    }
}

function es_admin() {
    return isset($_SESSION['privilegio']) && $_SESSION['privilegio'] === 'administrador';
}

function obtener_config() {
    global $conexion;
    $query = "SELECT * FROM configuracion LIMIT 1";
    $result = $conexion->query($query);
    return $result->fetch_assoc();
}

function obtener_propiedades($tipo = null, $destacada = null, $limit = null) {
    global $conexion;
    $query = "SELECT p.*, u.nombre AS agente_nombre FROM propiedades p LEFT JOIN usuarios u ON p.agente_id = u.id";
    $where = [];
    if ($tipo) $where[] = "tipo = '$tipo'";
    if ($destacada !== null) $where[] = "destacada = $destacada";
    if (!empty($where)) $query .= " WHERE " . implode(' AND ', $where);
    $query .= " ORDER BY id DESC";
    if ($limit) $query .= " LIMIT $limit";
    $result = $conexion->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function buscar_propiedades($busqueda) {
    global $conexion;
    $busqueda = $conexion->real_escape_string($busqueda);
    $query = "SELECT * FROM propiedades WHERE desc_breve LIKE '%$busqueda%' OR desc_larga LIKE '%$busqueda%' OR titulo LIKE '%$busqueda%' ORDER BY id DESC";
    $result = $conexion->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function subir_imagen($archivo, $destino = 'imagenes/') {
    $permitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $max_tamano = 2 * 1024 * 1024; 
    if (!in_array($archivo['type'], $permitidos)) {
        return false;
    }
    if ($archivo['size'] > $max_tamano) {
        return false;
    }
    if (!file_exists($destino)) mkdir($destino, 0777, true);
    $nombre = uniqid() . '_' . basename($archivo['name']);
    $ruta = $destino . $nombre;
    if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
        return $ruta;
    }
    return false;
}
?>