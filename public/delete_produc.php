<?php
include '../includes/auth.php';
include '../includes/funtions.php';
 
if (!isLoggedIn() || !isUsuario()) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $producto = getProductoById($id);

    if ($producto) {
        deleteProducto($id);
    }
}

header('Location: productos.php');
exit;
?>