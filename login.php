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
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(120deg, #18183a 60%, #ffd600 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'Montserrat', Arial, sans-serif;
        }
        .login-container {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(24,24,58,0.13);
            padding: 38px 28px 28px 28px;
            min-width: 290px;
            max-width: 350px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-logo {
            font-size: 1.4rem;
            color: #ffd600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: bold;
        }
        .login-container h2 {
            color: #18183a;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 16px;
        }
        .login-form {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 6px;
        }
        .login-form .input-group {
            display: flex;
            flex-direction: column;
            gap: 2px;
            margin-bottom: 10px;
            align-items: stretch;
        }
        .login-form label {
            font-weight: 500;
            color: #18183a;
            margin-bottom: 2px;
            font-size: 1rem;
            align-self: flex-start;
        }
        .login-form input[type="text"],
        .login-form input[type="password"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            width: 100%;
            box-sizing: border-box;
            margin: 0;
            background: #f8f8fa;
        }
        .login-form button {
            margin-top: 10px;
            padding: 12px 0;
            background: #18183a;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 1.08rem;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(24,24,58,0.07);
        }
        .login-form button:hover {
            background: #ffd600;
            color: #18183a;
        }
        .login-form .error {
            color: #d32f2f;
            font-size: 0.97rem;
            margin: 0 0 8px 0;
            padding: 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-logo"><i class="fa-solid fa-building"></i> UTN Solutions</div>
        <h2>Iniciar Sesión</h2>
        <form class="login-form" method="post" autocomplete="off">
            <div class="input-group">
                <label for="usuario"><i class="fa-solid fa-user"></i> Usuario:</label>
                <input type="text" id="usuario" name="usuario" required autofocus>
            </div>
            <div class="input-group">
                <label for="contrasena"><i class="fa-solid fa-lock"></i> Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>
            </div>
            <?php if ($error): ?><p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?></p><?php endif; ?>
            <button type="submit" name="login"><i class="fa-solid fa-arrow-right-to-bracket"></i> Ingresar</button>
        </form>
    </div>
</body>
</html>