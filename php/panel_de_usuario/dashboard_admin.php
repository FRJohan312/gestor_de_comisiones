<?php
session_start();

// Verificar que el usuario haya iniciado sesión y sea administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: ../login.html");
    exit;
}

// Contenido del panel de administrador
echo "Bienvenido, " . htmlspecialchars($_SESSION['usuario_nombre']) . ".";
?>



<br><a href="admin.html">Administrar Empleados</a>
<br><a href="logout.php">Cerrar Sesión</a>
