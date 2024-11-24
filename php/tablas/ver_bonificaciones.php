<?php
require '../config.php';

try {
    $sql = "SELECT b.id, v.nombre AS vendedor, b.motivo, b.monto, b.fecha_asignacion
            FROM bonificaciones b
            INNER JOIN vendedores v ON b.identificacion = v.identificacion
            ORDER BY b.fecha_asignacion DESC";
    $stmt = $pdo->query($sql);
    $bonificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al cargar bonificaciones: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Bonificaciones</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Reporte de Bonificaciones</h1>
    <table>
        <thead>
            <tr>
                <th>Vendedor</th>
                <th>Motivo</th>
                <th>Monto</th>
                <th>Fecha de Asignación</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($bonificaciones) > 0): ?>
                <?php foreach ($bonificaciones as $bonificacion): ?>
                    <tr>
                        <td><?= htmlspecialchars($bonificacion['vendedor']) ?></td>
                        <td><?= htmlspecialchars($bonificacion['motivo']) ?></td>
                        <td><?= number_format($bonificacion['monto'], 2) ?></td>
                        <td><?= htmlspecialchars($bonificacion['fecha_asignacion']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay bonificaciones registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="http://localhost/gestor_comisiones/php/gestor_de_datos.php">Regresar</a>
</body>
</html>
