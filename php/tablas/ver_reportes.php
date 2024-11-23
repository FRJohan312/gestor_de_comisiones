<?php
require '../config.php';

try {
    $sql = "
    SELECT r.id, v.nombre AS vendedor, r.periodo, r.ventas_totales, r.metas_cumplidas, r.bonificaciones_totales, 
           r.porcentaje_cumplimiento, r.dias_trabajados, r.ausencias
    FROM reportes_desempeno r
    INNER JOIN vendedores v ON r.identificacion = v.identificacion
    ORDER BY r.periodo, v.nombre
    ";
    $stmt = $pdo->query($sql);
    $reportes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al cargar los reportes: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes de Desempeño</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <h1>Reportes de Desempeño</h1>
    <table>
        <thead>
            <tr>
                <th>Vendedor</th>
                <th>Periodo</th>
                <th>Ventas Totales</th>
                <th>Metas Cumplidas</th>
                <th>Bonificaciones Totales</th>
                <th>Porcentaje de Cumplimiento</th>
                <th>Días Trabajados</th>
                <th>Ausencias</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($reportes) > 0): ?>
                <?php foreach ($reportes as $reporte): ?>
                    <tr>
                        <td><?= htmlspecialchars($reporte['vendedor']) ?></td>
                        <td><?= htmlspecialchars($reporte['periodo']) ?></td>
                        <td><?= number_format($reporte['ventas_totales'], 2) ?></td>
                        <td><?= htmlspecialchars($reporte['metas_cumplidas']) ?></td>
                        <td><?= number_format($reporte['bonificaciones_totales'], 2) ?></td>
                        <td><?= number_format($reporte['porcentaje_cumplimiento'], 2) ?>%</td>
                        <td><?= htmlspecialchars($reporte['dias_trabajados']) ?></td>
                        <td><?= htmlspecialchars($reporte['ausencias']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No hay reportes disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
