<?php
session_start();

// Redirigir según el estado de la sesión
if (isset($_SESSION["loggedin"])) {
    // Si el usuario ya ha iniciado sesión, redirigir según su rol
    if ($_SESSION["role"] === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: client/dashboard.php");
    }
} else {
    // Si no ha iniciado sesión, redirigir al login
    header("Location: login.php");
}
exit;
?>
