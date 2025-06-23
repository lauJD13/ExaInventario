<?php
include '../includes/auth.php';
include '../includes/funtions.php';
 
if (!isLoggedIn() || !isAdmin()) {
    header('Location: login.php');
    exit;
}
$user = getUserById($id);
if ($user) {
    deleteUser($id);
}
 
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    deleteUser($id);
}
 
header('Location: dashboard.php');
exit;

?>