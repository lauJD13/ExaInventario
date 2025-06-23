<?php
include '../includes/auth.php';
include '../includes/funtions.php';
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['usuario']);
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $correo = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];
    $tipo = $_POST['tipo'];
    $estado = $_POST['estado'];
 
    // Validación simple
    if (!$usuario || !$nombre || !$apellidos || !$correo || !$contrasena) {
        echo "❌ Por favor llena todos los campos.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo "❌ Correo electrónico no válido.";
    } else {
        try {
            createUser($usuario, $nombre, $apellidos, $correo, $contrasena, $tipo, $estado);
            header('Location: dashboard.php');
            exit;
        } catch (PDOException $e) {
            echo "❌ Error al registrar: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=2025">
    
<body>
    <div class="contenedor">
       <h2>Registro de Usuario</h2>

     <form method="POST">

      Usuario: <input type="text" name="usuario" required><br>
      Nombre: <input type="text" name="nombre" required><br>
      Apellidos: <input type="text" name="apellidos" required><br>
      Correo: <input type="email" name="correo" required><br>
      Contraseña: <input type="password" name="contrasena" required><br>

         Selecciona Tipo: <select name="tipo">
          <option value="admin">Administrador</option>
          <option value="usuario">Usuario</option>
          </select><br><br>

         Estado: <select name="estado">
         <option value="0">Inactivo</option>
         <option value="1">Activo</option>
         </select><br><br>
        
          <input type="submit" value="Registrar">
     </form>
     <br>
    <form action="login.php" method="get">
        <button type="submit" class="button">Volver a Iniciar Sesión</button>
    </form>
    </div>
</body>
</html>