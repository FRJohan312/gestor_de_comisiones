<?php
session_start();

// Verificar si el usuario tiene rol de administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.html");
    exit;
}

echo "<h2>Bienvenido Administrador, " . htmlspecialchars($_SESSION['usuario_nombre']) . "</h2>";
?>

<a href="admin.html">Administrar Empleados</a><br>
<a href="logout.php">Cerrar Sesión</a>
