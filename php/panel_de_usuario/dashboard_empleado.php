<?php
session_start();

// Verificar que el usuario haya iniciado sesión y sea vendedor
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'empleado') {
    header("Location: ../login.html");
    exit;
}

// Contenido del panel de vendedor
echo "Bienvenido, " . htmlspecialchars($_SESSION['usuario_nombre']) . ".";
?>


<a href="venta_vendedor.html">Registrar Ventas</a><br>
<a href="logout.php">Cerrar Sesión</a>
