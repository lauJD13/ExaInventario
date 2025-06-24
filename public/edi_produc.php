<?php
include '../includes/auth.php';
include '../includes/funtions.php';
require '../sql/conexion.php';

// Solo usuarios normales pueden acceder
if (!isLoggedIn() || !isUsuario()) {
    header('Location: productos.php');
    exit;
}

// Validar ID
$id = $_GET['id'] ?? null;
$productos = getProductoById($id);

if (!$productos) {
    echo "Producto no encontrado.";
    exit;
}

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre      = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $cantidad    = $_POST['cantidad'];
    $precio      = $_POST['precio'];
    $foto        = $_POST['foto'] ?? $productos['foto']; // ✅ Aquí aplicamos la corrección

    updateProducto($id, $nombre, $descripcion, $cantidad, $precio, $foto);
    $mensaje = "✅ Producto actualizado correctamente.";

    // Refrescar valores para mostrar en pantalla
    $productos['nombre'] = $nombre;
    $productos['descripcion'] = $descripcion;
    $productos['cantidad'] = $cantidad;
    $productos['precio'] = $precio;
    $productos['foto'] = $foto;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=2025">
</head>
<body>
<div class="contenedor-editar">
    <h2>Editar Producto</h2>

    <?php if (!empty($mensaje)): ?>
        <p style="color:green;"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($productos['nombre']) ?>" required>

        <label>Descripción:</label>
        <textarea name="descripcion" required><?= htmlspecialchars($productos['descripcion']) ?></textarea>

        <label>Cantidad:</label>
        <input type="number" name="cantidad" value="<?= $productos['cantidad'] ?>" required>

        <label>Precio:</label>
        <input type="number" name="precio" step="0.01" value="<?= $productos['precio'] ?>" required>
        <!--Cambia la imagen actual--> 
        <label>Imagen actual:</label><br>
        <?php if (!empty($productos['foto']) && file_exists("../image/" . $productos['foto'])): ?>
            <img src="../image/<?= htmlspecialchars($productos['foto']) ?>" alt="Foto actual" width="100"><br>
        <?php else: ?>
            <span style="color:#888;">No disponible</span><br>
        <?php endif; ?>

        <h4>Selecciona una nueva imagen:</h4>
        <div class="galeria">
            <?php
            $imagenes = glob("../image/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
            foreach ($imagenes as $img) {
                $archivo = basename($img);
                $seleccionado = ($archivo === $productos['foto']) ? "checked" : "";
                echo "<label>";
                echo "<input type='radio' name='foto' value='$archivo' style='display:none;' $seleccionado>";
                echo "<img src='$img' alt='$archivo'><br>$archivo";
                echo "</label>";
            }
            ?>
        </div>

        <button type="submit" class="button">Actualizar producto</button>
    </form>

    <form action="productos.php" method="get">
        <button type="submit" class="button">← Volver a productos</button>
    </form>
</div>
</body>
</html>
