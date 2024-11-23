<?php
require 'config.php';

try {
    $sql = "
    SELECT a.id, v.nombre AS vendedor, a.fecha, a.estado
    FROM asistencias a
    INNER JOIN vendedores v ON a.identificacion = v.identificacion
    ORDER BY a.fecha DESC, v.nombre
    ";
    $stmt = $pdo->query($sql);
    $asistencias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al cargar asistencias: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencias</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <h1>Reporte de Asistencias</h1>
    <table>
        <thead>
            <tr>
                <th>Vendedor</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($asistencias) > 0): ?>
                <?php foreach ($asistencias as $asistencia): ?>
                    <tr>
                        <td><?= htmlspecialchars($asistencia['vendedor']) ?></td>
                        <td><?= htmlspecialchars($asistencia['fecha']) ?></td>
                        <td><?= htmlspecialchars($asistencia['estado']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay asistencias registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
