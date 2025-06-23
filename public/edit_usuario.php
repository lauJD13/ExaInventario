<?php
include '../includes/auth.php';
include '../includes/funtions.php';
 
if (!isLoggedIn() || !isAdmin()) {
    header('Location: login.php');
    exit;
}
 
$id = $_GET['id'];
$user = getUserById($id);
 
if (!$user) {
    echo "Usuario no encontrado.";
    exit;
}
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellido'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $estado = $_POST['estado'];
    $tipo = $_POST['tipo'];
 
    updateUser($id, $usuario, $nombre, $apellidos, $correo, $contrasena, $tipo, $estado);
 
    header('Location: dashboard.php');
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=2025">
</head>
<body>

 <div class="contenedor-editar">
    <h1>Editar Usuario</h1>
    <!--<a href="dashboard.php">⬅️ Volver al panel</a>-->
    <a href="dashboard.php" class="button">⬅ Volver al panel</a><br><br>

    <form method="POST">
        Usuario: <input type="text" name="usuario" value="<?= htmlspecialchars($user['usuario']) ?>" required><br>
        Nombre: <input type="text" name="nombre" value="<?= htmlspecialchars($user['nombre']) ?>" required><br>
        Apellido: <input type="text" name="apellidos" value="<?= htmlspecialchars($user['apellidos']) ?>" required><br>
        Correo: <input type="email" name="correo" value="<?= htmlspecialchars($user['correo']) ?>" required><br>
        Contraseña: <input type="password" name="contrasena" placeholder="Nueva contraseña" required><br>
       
        Tipo:
        <select name="tipo" required>
            <option value="admin" <?= $user['tipo'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
            <option value="usuario" <?= $user['tipo'] === 'usuario' ? 'selected' : '' ?>>Usuario</option>
        </select><br>
 
        Estado:
        <select name="estado" required>
            <option value="1" <?= $user['estado'] == 1 ? 'selected' : '' ?>>Activo</option>
            <option value="0" <?= $user['estado'] == 0 ? 'selected' : '' ?>>Inactivo</option>
        </select><br>
 
        <button type="submit">Actualizar usuario</button>
    </form>
 </div>
</body>
</html>