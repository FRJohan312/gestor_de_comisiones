<?php
session_start();

// Verificar si el usuario tiene rol de empleado
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'empleado') {
    header("Location: login.html");
    exit;
}

echo "<h2>Bienvenido, " . htmlspecialchars($_SESSION['usuario_nombre']) . "</h2>";
?>

<a href="venta_vendedor.html">Registrar Ventas</a><br>
<a href="logout.php">Cerrar Sesión</a>
