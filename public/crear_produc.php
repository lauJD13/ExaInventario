<?php
require_once '../includes/auth.php';
require_once '../includes/funtions.php';
require_once '../sql/conexion.php';


if (!isLoggedIn() || !isUsuario()) {
    header("Location: login.php");
    exit;
}

$mensaje = "";
//Se obtienen datos enviados a traves del POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $cantidad = (int) $_POST['cantidad'];
    $precio = (float) $_POST['precio'];
    $foto = $_POST['foto'] ?? '';
   //validacion de los campos 
    if (!$nombre || !$descripcion || $cantidad <= 0 || $precio <= 0 || !$foto) {
        $mensaje = "❌ Todos los campos son obligatorios y deben ser válidos.";
    } else {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO productos (nombre, descripcion, cantidad, precio, foto)
                        VALUES (:nombre, :descripcion, :cantidad, :precio, :foto)
            ");
            $stmt->execute([
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'cantidad' => $cantidad,
                'precio' => $precio,
                'foto' => $foto
            ]);
            header("Location: productos.php");
            exit;
        } catch (PDOException $e) {
            $mensaje = "❌ Error al guardar: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=2025">
</head>
<body>
<div class="contenedor-productos">
    <h2>Agregar Producto</h2>

    <?php if (!empty($mensaje)): ?>
        <p style="color:red;"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= $_POST['nombre'] ?? '' ?>" required>

        <label>Descripción:</label>
        <textarea name="descripcion" required><?= $_POST['descripcion'] ?? '' ?></textarea>

        <label>Cantidad:</label>
        <input type="number" name="cantidad" min="1" value="<?= $_POST['cantidad'] ?? '' ?>" required>

        <label>Precio:</label>
        <input type="number" name="precio" step="0.01" min="0.01" value="<?= $_POST['precio'] ?? '' ?>" required>

        <h4>Selecciona una imagen:</h4>
        <!--Busca las imagenes y lista archivos de imagen-->
        <div class="galeria">
            <?php
            $imagenes = glob("../image/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
            foreach ($imagenes as $img) {
                $archivo = basename($img);
                echo "<label>";
                echo "<input type='radio' name='foto' value='$archivo' style='display:none;' required>";
                echo "<img src='$img' alt='$archivo'><br>$archivo";
                echo "</label>";
            }
            ?>
        </div>

        <input type="submit" value="Guardar">
    </form>

    <br>
<form action="productos.php" method="get">
    <button type="submit" class="button">← Volver a productos</button>
</form>
</div>
</body>
</html>
