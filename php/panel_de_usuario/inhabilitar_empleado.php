<?php
require '../config.php';
session_start();

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.html");
    exit;
}

$id = $_GET['id'] ?? null;
$estado = $_GET['estado'] ?? null;

if ($id && ($estado === '0' || $estado === '1')) {
    $sql = "UPDATE usuarios SET activo = :estado WHERE id = :id AND rol = 'empleado'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':estado' => $estado, ':id' => $id]);

    header("Location: admin_empleados.php");
    exit;
}

die("Operación no válida.");
?>
