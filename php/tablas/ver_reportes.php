<?php
require '../config.php';

try {
    // Consulta para cargar el reporte incluyendo la comisión total
    $sql = "
    SELECT 
        r.id, 
        v.nombre AS vendedor, 
        r.periodo, 
        r.metas_cumplidas, 
        r.porcentaje_cumplimiento, 
        r.dias_trabajados, 
        r.ausencias,
        r.comision_total, -- Mostrar la comisión total
        (
            SELECT COALESCE(SUM(ventas.total), 0) 
            FROM ventas 
            WHERE ventas.identificacion = r.identificacion 
            AND DATE_FORMAT(ventas.fecha_venta, '%Y-%m') = r.periodo
            AND ventas.activo = 1 -- Solo ventas habilitadas (activas)
        ) AS ventas_totales
    FROM reportes_desempeno r
    INNER JOIN vendedores v ON r.identificacion = v.identificacion
    ORDER BY r.periodo, v.nombre;
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
                <th>Porcentaje de Cumplimiento</th>
                <th>Días Trabajados</th>
                <th>Ausencias</th>
                <th>Comisión Total</th> <!-- Nueva columna para la comisión -->
            </tr>
        </thead>
        <tbody>
            <?php if (count($reportes) > 0): ?>
                <?php foreach ($reportes as $reporte): ?>
                    <tr>
                        <td><?= htmlspecialchars($reporte['vendedor']) ?></td>
                        <td><?= htmlspecialchars($reporte['periodo']) ?></td>
                        <td><?= number_format($reporte['ventas_totales'], 2) ?></td>
                        <td><?= htmlspecialchars($reporte['metas_cumplidas'] ? 'Sí' : 'No') ?></td>
                        <td><?= number_format($reporte['porcentaje_cumplimiento'], 2) ?>%</td>
                        <td><?= htmlspecialchars($reporte['dias_trabajados']) ?></td>
                        <td><?= htmlspecialchars($reporte['ausencias']) ?></td>
                        <td><?= number_format($reporte['comision_total'], 2) ?></td> <!-- Mostrar la comisión -->
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No hay reportes disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="http://localhost/gestor_comisiones/php/gestor_de_datos.php">Regresar</a>
</body>
</html>
