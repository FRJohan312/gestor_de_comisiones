<?php
require '../config.php';
session_start();

// Verificar si es administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.html");
    exit;
}

try {
    $sql = "SELECT v.id, v.producto, v.cantidad, v.total, v.comision, v.fecha_venta, v.activo, ve.nombre AS vendedor
            FROM ventas v
            INNER JOIN vendedores ve ON v.identificacion = ve.identificacion";
    $stmt = $pdo->query($sql);
    $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al consultar las ventas: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Ventas</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <h1>Administrar Ventas</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Comisión</th>
                <th>Fecha</th>
                <th>Vendedor</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($ventas) > 0): ?>
                <?php foreach ($ventas as $venta): ?>
                    <tr>
                        <td><?= htmlspecialchars($venta['id']) ?></td>
                        <td><?= htmlspecialchars($venta['producto']) ?></td>
                        <td><?= htmlspecialchars($venta['cantidad']) ?></td>
                        <td><?= htmlspecialchars($venta['total']) ?></td>
                        <td><?= htmlspecialchars($venta['comision']) ?></td>
                        <td><?= htmlspecialchars($venta['fecha_venta']) ?></td>
                        <td><?= htmlspecialchars($venta['vendedor']) ?></td>
                        <td><?= $venta['activo'] ? 'Activa' : 'Inactiva' ?></td>
                        <td>
                            <a href="eliminar_venta.php?id=<?= $venta['id'] ?>&estado=<?= $venta['activo'] ? 0 : 1 ?>">
                                <?= $venta['activo'] ? 'Inhabilitar' : 'Habilitar' ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No hay ventas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="dashboard_admin.php">Volver al Panel</a>
</body>
</html>
