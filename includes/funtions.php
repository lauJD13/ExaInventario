<?php
require '../sql/conexion.php';

 //funcion de los usuarios
function getAllUsers()
{
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM usuarios");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
 
function getUserById($id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
 
function usuarioExiste($usuario)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario");
    $stmt->execute(['usuario' => $usuario]);
    return $stmt->fetchColumn() > 0;
}
 
function createUser($usuario, $nombre, $apellidos, $correo, $contrasena, $tipo, $estado)
{
    global $pdo;
 
    if (usuarioExiste($usuario)) {
        throw new Exception("⚠️ El usuario ya existe.");
    }
 
    $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, nombre, apellidos, correo, contrasena, tipo, estado)
                            VALUES (:usuario, :nombre, :apellidos, :correo, :contrasena, :tipo, :estado)");
    $stmt->execute([
        'usuario' => $usuario,
        'nombre' => $nombre,
        'apellidos' => $apellidos,
        'correo' => $correo,
        'contrasena' => password_hash($contrasena, PASSWORD_DEFAULT),
        'tipo' => $tipo,
        'estado' => $estado
    ]);
}
 
function updateUser($id, $usuario, $nombre, $apellidos, $correo, $contrasena, $tipo, $estado)
{
    global $pdo;
 
    $stmt = $pdo->prepare("UPDATE usuarios SET 
        usuario = :usuario, 
        nombre = :nombre, 
        apellidos = :apellidos,
        correo = :correo, 
        contrasena = :contrasena, 
        tipo = :tipo, 
        estado = :estado 
        WHERE id = :id");
    $stmt->execute([
        'id' => $id,
        'usuario' => $usuario,
        'nombre' => $nombre,
        'apellidos' => $apellidos,
        'correo' => $correo,
        'contrasena' => password_hash($contrasena, PASSWORD_DEFAULT),
        'tipo' => $tipo,
        'estado' => $estado
    ]);
}
 
function deleteUser($id)
{
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
    $stmt->execute(['id' => $id]);
}
 
 //--------------Funcion de los productos-------------------// 
function getAllProducto()
{
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM productos");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
 
function getProductoById($id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
 
function createProducto($nombre, $descripcion, $cantidad, $precio, $foto)
{
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO productos (nombre, descripcion, cantidad, precio, foto) 
                            VALUES (:nombre, :descripcion, :cantidad, :precio, :foto)");
    $stmt->execute([
        'nombre' => $nombre,
        'descripcion' => $descripcion,
        'cantidad' => $cantidad,
        'precio' => $precio,
        'foto' => $foto
    ]);
}
 
function updateProducto($id, $nombre, $descripcion, $cantidad, $precio, $foto)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE productos SET 
        nombre = :nombre, 
        descripcion = :descripcion, 
        cantidad = :cantidad, 
        precio = :precio, 
        foto = :foto 
        WHERE id = :id");
    $stmt->execute([
        'id' => $id,
        'nombre' => $nombre,
        'descripcion' => $descripcion,
        'cantidad' => $cantidad,
        'precio' => $precio,
        'foto' => $foto
    ]);
}
 
function deleteProducto($id)
{
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = :id");
    $stmt->execute(['id' => $id]);
}