
<?php
include '../includes/auth.php';
include '../includes/funtions.php';

/*Si no ha iniciado sesión, redirige al login
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}
// Redirige según el tipo de usuario
if (isAdmin()) {
// Continúa con el panel de administración
    $users = getAllUsers();
} elseif (isUsuario()) {
    header('Location: crear_produc.php');
    exit;
} */

// 1. Verificar sesión
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}
// 2. Redirección según el rol
if (isUsuario()) {
    header('Location: crear_produc.php');
    exit;
}
if (!isAdmin()) {
    // Si no es admin ni usuario, tal vez un rol no válido
    header('Location: login.php');
    exit;
}
// 3. Solo si es admin, continuamos
$users = getAllUsers();
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=2025">
</head>
<body>

<div class="contenedor-usuarios">
    <h1>Bienvenido Administrador</h1>

    <div class="acciones-usuarios">
        <form action="regisusuario.php" method="get">
            <button type="submit" class="button">➕ Crear nuevo usuario</button>
        </form>

        <form action="logout.php" method="get">
            <button type="submit" class="button">🔓 Cerrar sesión</button>
        </form>
    </div>

    <h2>Los Usuarios en Tabla:</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['usuario']) ?></td>
                    <td><?= htmlspecialchars($user['nombre']) ?></td>
                    <td><?= htmlspecialchars($user['apellidos']) ?></td>
                    <td><?= htmlspecialchars($user['correo']) ?></td>
                    <td><?= htmlspecialchars($user['tipo']) ?></td>
                    <td><?= $user['estado'] == 1 ? 'Activo' : 'Inactivo' ?></td>
                    <td>
                        <a href="edit_usuario.php?id=<?= (int)$user['id'] ?>">✏️ Editar</a> |
                        <a href="elim_usuario.php?id=<?= (int)$user['id'] ?>" onclick="return confirm('¿Eliminar este usuario?');">🗑️ Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>