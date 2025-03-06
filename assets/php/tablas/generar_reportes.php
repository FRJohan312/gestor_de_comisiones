<?php
require '../config.php';

try {
    // Vaciar la tabla para regenerar los reportes
    $pdo->exec("TRUNCATE TABLE reportes_desempeno");

    // Generar reportes consolidados, incluyendo el cálculo de comisiones totales
    $sql = "
    INSERT INTO reportes_desempeno (identificacion, periodo, ventas_totales, metas_cumplidas, bonificaciones_totales, porcentaje_cumplimiento, dias_trabajados, ausencias, comision_total)
    SELECT 
        v.identificacion,
        DATE_FORMAT(v.fecha_venta, '%Y-%m') AS periodo,
        SUM(v.total) AS ventas_totales,
        (SELECT COUNT(*) 
         FROM metas_ventas m 
         WHERE m.identificacion = v.identificacion 
         AND m.periodo = DATE_FORMAT(v.fecha_venta, '%Y-%m') 
         AND m.cumplida = 1) AS metas_cumplidas,
        (SELECT COALESCE(SUM(b.monto), 0) 
         FROM bonificaciones b 
         WHERE b.identificacion = v.identificacion 
         AND DATE_FORMAT(b.fecha_asignacion, '%Y-%m') = DATE_FORMAT(v.fecha_venta, '%Y-%m')) AS bonificaciones_totales,
        (
            SELECT 
                CASE 
                    WHEN COUNT(*) = 0 THEN 0 
                    ELSE (COUNT(*) / (SELECT COUNT(*) 
                                     FROM metas_ventas m 
                                     WHERE m.identificacion = v.identificacion 
                                     AND m.periodo = DATE_FORMAT(v.fecha_venta, '%Y-%m'))) * 100
                END
            FROM metas_ventas m
            WHERE m.identificacion = v.identificacion 
            AND m.periodo = DATE_FORMAT(v.fecha_venta, '%Y-%m') 
            AND m.cumplida = 1
        ) AS porcentaje_cumplimiento,
        (SELECT COUNT(*) 
         FROM asistencias a 
         WHERE a.identificacion = v.identificacion 
         AND a.estado = 'Presente' 
         AND DATE_FORMAT(a.fecha, '%Y-%m') = DATE_FORMAT(v.fecha_venta, '%Y-%m')) AS dias_trabajados,
        (SELECT COUNT(*) 
         FROM asistencias a 
         WHERE a.identificacion = v.identificacion 
         AND a.estado = 'Ausente' 
         AND DATE_FORMAT(a.fecha, '%Y-%m') = DATE_FORMAT(v.fecha_venta, '%Y-%m')) AS ausencias,
        SUM(v.comision) AS comision_total -- Sumar las comisiones directamente
    FROM ventas v
    GROUP BY v.identificacion, periodo;
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    echo "Reportes generados correctamente.";
    echo '<a href="ver_reportes.php">Ver Reportes</a>';
} catch (PDOException $e) {
    die("Error al generar los reportes: " . $e->getMessage());
}
?>
