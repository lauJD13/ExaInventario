<?php
include  '../includes/auth.php';
include '../includes/funtions.php';
 
// crear o editar los usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];
    $usuario = $_POST['usuario'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellido'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $tipo = $_POST['tipo'];
    $estado = $_POST['estado'];
 
    if ($accion === 'crear') {
        createUser($usuario, $nombre, $apellidos, $correo, $contrasena, $tipo, $estado);
    } elseif ($accion === 'editar' && isset($_POST['id'])) {
        updateUser($_POST['id'], $usuario, $nombre, $apellidos, $correo, $contrasena, $tipo, $estado);
    }
 
    header("Location: ../public/usuario.php");
    exit;
}
  //La cambiamos por el login ya que teniamos regisusuario.php
if (!isLoggedIn() || !isAdmin()) {
    header("Location: ../public/login.php");
    exit;
}

// Eliminacion del usuario
if (isset($_GET['eliminar'])) {
    deleteUser($_GET['eliminar']);
    header("Location: public/usuario.php");
    exit;
}
 
// Editar o consultar 
$usuarios = getAllUsers();
$usuarioEditar = null;
if (isset($_GET['editar'])) {
    $usuarioEditar = getUserById($_GET['editar']);
}
?>
// HTML
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración de Usuarios</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=2025">
</head>
<body>
    <h2><?= $usuarioEditar ? '✏️ Editar Usuario' : '➕ Agregar Usuario' ?></h2>
 
    <form method="POST">
        <input type="hidden" name="accion" value="<?= $usuarioEditar ? 'editar' : 'crear' ?>">
        <?php if ($usuarioEditar): ?>
            <input type="hidden" name="id" value="<?= $usuarioEditar['id'] ?>">
        <?php endif; ?>
 
        Usuario: <input type="text" name="usuario" value="<?= $usuarioEditar['usuario'] ?? '' ?>" required><br>
        Nombre: <input type="text" name="nombre" value="<?= $usuarioEditar['nombre'] ?? '' ?>" required><br>
        Apellido: <input type="text" name="apellido" value="<?= $usuarioEditar['apellido'] ?? '' ?>" required><br>
        Correo: <input type="email" name="correo" value="<?= $usuarioEditar['correo'] ?? '' ?>" required><br>
        Contraseña: <input type="password" name="contrasena" required><br>
 
        Tipo:
        <select name="tipo" required>
            <option value="admin" <?= ($usuarioEditar['tipo'] ?? '') === 'admin' ? 'selected' : '' ?>>Administrador</option>
            <option value="usuario" <?= ($usuarioEditar['tipo'] ?? '') === 'usuario' ? 'selected' : '' ?>>Usuario</option>
        </select><br>
 
        Estado:
        <select name="estado" required>
            <option value="1" <?= ($usuarioEditar['estado'] ?? '') == 1 ? 'selected' : '' ?>>Activo</option>
            <option value="0" <?= ($usuarioEditar['estado'] ?? '') == 0 ? 'selected' : '' ?>>Inactivo</option>
        </select><br><br>
 
        <input type="submit" value="<?= $usuarioEditar ? 'Actualizar' : 'Crear' ?>">
    </form>
    <hr>
    <h2>Usuarios Registrados</h2>

    <table border="1">
        <tr>
            <th>ID</th><th>Usuario</th><th>Correo</th><th>Tipo</th><th>Estado</th><th>Acciones</th>
        </tr>
        <?php foreach ($usuarios as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= $u['usuario'] ?></td>
            <td><?= $u['correo'] ?></td>
            <td><?= $u['tipo'] ?></td>
            <td><?= $u['estado'] == 1 ? 'Activo' : 'Inactivo' ?></td>
            <td>
                <a href="?editar=<?= $u['id'] ?>">✏️ Editar</a> |
                <a href="?eliminar=<?= $u['id'] ?>" onclick="return confirm('¿Eliminar este usuario?')">🗑️ Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
 
    <br>
    <a href="../public/dashboard.php">🏠 Volver </a> |
    <a href="../public/logout.php">🚪 Cerrar sesión</a>
</body>
</html>
