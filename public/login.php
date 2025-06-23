<?php
require_once '../includes/auth.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $contrasena = $_POST['contrasena'];

    if (login($usuario, $contrasena)) {
        // Redirigir según el tipo de usuario
        if ($_SESSION['tipo'] === 'admin') {
            header("Location: dashboard.php");
        } elseif ($_SESSION['tipo'] === 'usuario') {
            header("Location: crear_produc.php");
        } else {
            $mensaje = "⚠️ Tipo de usuario no reconocido.";
        }
        exit;
    } else {
        $mensaje = "❌ Usuario o contraseña incorrectos o cuenta inactiva.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=2025">
</head>
<body>

<div class="contenedor-login">
    <h2>Iniciar Sesión</h2>

    <?php if (!empty($mensaje)): ?>
        <p style="color:red;"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Usuario:</label>
        <input type="text" name="usuario" required>

        <label>Contraseña:</label>
        <input type="password" name="contrasena" required>

        <div class="botones-login">
            <button type="submit" class="button">Ingresar</button>

            <!-- Botón separado para registrar usuario -->
            <a href="regisusuario.php" class="button">Registrar Nuevo Usuario</a>
        </div>
    </form>
</div>

</body>
</html>
