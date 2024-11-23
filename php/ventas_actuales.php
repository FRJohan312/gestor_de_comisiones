<?php
require 'config.php';

try {
    // Actualizar ventas_actuales y cumplida en todas las metas
    $sql = "
    UPDATE metas_ventas m
    SET ventas_actuales = (
        SELECT COALESCE(SUM(v.total), 0)
        FROM ventas v
        WHERE v.identificacion = m.identificacion
        AND DATE_FORMAT(v.fecha_venta, '%Y-%m') = m.periodo
    ),
    cumplida = ventas_actuales >= meta;
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Asignar bonificaciones automáticas si una meta fue cumplida
    $bonificacionSql = "
    INSERT INTO bonificaciones (identificacion, motivo, monto, fecha_asignacion)
    SELECT m.identificacion, CONCAT('Bonificación por cumplimiento de meta en ', m.periodo), 500.00, CURDATE()
    FROM metas_ventas m
    WHERE m.cumplida = 1 -- Cambiado a 1 para bases de datos que manejan TRUE como entero
    AND NOT EXISTS (
        SELECT 1 FROM bonificaciones b
        WHERE b.identificacion = m.identificacion
        AND b.motivo LIKE CONCAT('%', m.periodo, '%')
    );
    ";
    $stmt = $pdo->prepare($bonificacionSql);
    $stmt->execute();

    echo "Metas actualizadas correctamente y bonificaciones asignadas.";
    echo '<a href="ver_metas.php">Volver al reporte</a>';
} catch (PDOException $e) {
    die("Error al actualizar las metas: " . $e->getMessage());
}
?>
