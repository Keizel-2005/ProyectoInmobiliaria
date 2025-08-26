<?php
include 'funciones.php';

$error = '';
if (isset($_POST['login'])) {
    $usuario = $conexion->real_escape_string($_POST['usuario']);
    $contrasena = encriptar_contrasena($_POST['contrasena']);
    $query = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contrasena = '$contrasena'";
    $result = $conexion->query($query);
    if ($row = $result->fetch_assoc()) {
        session_start();
        $_SESSION['usuario_id'] = $row['id'];
        $_SESSION['privilegio'] = $row['privilegio'];
        header('Location: panel.php');
    exit();
    } else {
        $error = 'Credenciales incorrectas';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="styles/estilos.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'Montserrat', Arial, sans-serif;
            background: none;
        }
        .login-container {
            background: var(--color-blanco, #fff);
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(24,24,58,0.10);
            padding: 32px 22px 22px 22px;
            min-width: 260px;
            max-width: 320px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-container h2 {
            color: var(--color-texto, #22223b);
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 18px;
        }
        .login-form {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .login-form label {
            font-weight: 500;
            color: var(--color-texto, #22223b);
            margin-bottom: 2px;
            font-size: 0.98rem;
        }
        .login-form input[type="text"],
        .login-form input[type="password"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            width: 100%;
            background: var(--color-fondo, #f8f8fa);
        }
        .login-form button {
            margin-top: 10px;
            padding: 10px 0;
            background: var(--color-primario, #18183a);
            color: var(--color-blanco, #fff);
            border: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }
        .login-form button:hover {
            background: var(--color-secundario, #ffd600);
            color: var(--color-primario, #18183a);
        }
        .login-form .error {
            color: var(--color-eliminar, #d32f2f);
            font-size: 0.97rem;
            margin: 0 0 8px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <form class="login-form" method="post" autocomplete="off">
    <h2 style="text-align:center; margin-bottom:18px; color:var(--color-texto, #22223b); font-size:1.15rem; font-weight:700;">Iniciar sesión</h2>
        <label for="usuario">Usuario</label>
        <input type="text" id="usuario" name="usuario" required autofocus>
        <label for="contrasena">Contraseña</label>
        <input type="password" id="contrasena" name="contrasena" required>
        <?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
        <button type="submit" name="login">Ingresar</button>
    </form>
</body>
</html>