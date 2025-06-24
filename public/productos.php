<?php
require_once '../includes/auth.php';
require_once '../includes/funtions.php';
require_once '../sql/conexion.php';

if (!isLoggedIn() || !isUsuario()) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM productos");
$productos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Productos</title>
    
   <link rel="stylesheet" href="../assets/css/style.css?v=2025">

</head>
<body>
<div class="contenedor-product">
    <h2>Bienvenido, <?= htmlspecialchars($_SESSION['nombre']) ?></h2>

    <div class="acciones-producto">
        <form action="crear_produc.php" method="get">
            <button type="submit" class="button">➕ Agregar Nuevo Producto</button>
        </form>

        <form action="logout.php" method="get">
            <button type="submit" class="button">🔓 Cerrar sesión</button>
        </form>
    </div>

    <?php if (count($productos) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!--Se crea visualizacion del catalogo-->
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?= $producto['id']; ?></td>
                        <td><?= htmlspecialchars($producto['nombre']); ?></td>
                        <td><?= htmlspecialchars($producto['descripcion']); ?></td>
                        <td><?= $producto['cantidad']; ?></td>
                        <td>$<?= number_format($producto['precio'], 2); ?></td>
                        <td>
                            <?php if (!empty($producto['foto']) && file_exists("../image/" . $producto['foto'])): ?>
                                <img src="../image/<?= htmlspecialchars($producto['foto']) ?>" alt="Foto" width="100">
                            <?php else: ?>
                                No disponible
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edi_produc.php?id=<?= $producto['id']; ?>">✏️</a> |
                            <a href="delete_produc.php?id=<?= $producto['id']; ?>" onclick="return confirm('¿Seguro que deseas eliminar este producto?');">🗑️</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay productos registrados.</p>
    <?php endif; ?>
</div>
</body>
</html>
