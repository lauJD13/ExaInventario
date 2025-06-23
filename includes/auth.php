<?php        
require_once __DIR__ . '/conexion.php';

session_start();

// Verifica si hay sesión iniciada
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Verifica si el usuario es administrador
function isAdmin() {
    return isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'admin';
}

// Verifica si es usuario común
function isUsuario() {
    return isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'usuario';
}

// Función para iniciar sesión
function login($usuario, $contrasena) {
    global $pdo; // conexión PDO

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario AND estado = 1");
    $stmt->execute(['usuario' => $usuario]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($contrasena, $user['contrasena'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['tipo'] = $user['tipo'];
        $_SESSION['nombre'] = $user['nombre'];
        return true;
    }
    return false;
}

// Cerrar sesión
function logout() {
    session_unset();
    session_destroy();
}
?>