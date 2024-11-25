<?php
require 'config.php';

try {
    // Actualizar ventas_actuales y el estado de cumplimiento de las metas
    $sqlMetas = "
    UPDATE metas_ventas m
    SET ventas_actuales = (
        SELECT COALESCE(SUM(v.total), 0)
        FROM ventas v
        WHERE v.identificacion = m.identificacion
        AND DATE_FORMAT(v.fecha_venta, '%Y-%m') = m.periodo
    ),
    cumplida = ventas_actuales >= meta;
    ";
    $stmtMetas = $pdo->prepare($sqlMetas);
    $stmtMetas->execute();

    // Asignar bonificaciones automáticamente a empleados que cumplieron su meta
    $sqlBonificaciones = "
    INSERT INTO bonificaciones (identificacion, motivo, monto, fecha_asignacion)
    SELECT 
        m.identificacion,
        CONCAT('Bonificación por cumplimiento de meta en ', m.periodo),
        300000,
        CURDATE()
    FROM metas_ventas m
    WHERE m.cumplida = 1 -- Solo metas cumplidas
    AND NOT EXISTS (
        SELECT 1 
        FROM bonificaciones b
        WHERE b.identificacion = m.identificacion
        AND b.motivo = CONCAT('Bonificación por cumplimiento de meta en ', m.periodo)
    )
    ";
    $stmtBonificaciones = $pdo->prepare($sqlBonificaciones);
    $stmtBonificaciones->execute();

    echo "Metas actualizadas y bonificaciones asignadas correctamente.";
    echo '<br><a href="http://localhost/gestor_comisiones/php/tablas/generar_reportes.php">Ver reportes de desempeño</a>';
    echo '<br><a href="http://localhost/gestor_comisiones/php/tablas/tabla_metas.php">Ver tabla de metas</a>';
    echo '<br><a href="http://localhost/gestor_comisiones/php/tablas/ver_bonificaciones.php">Tabla bonificaciones</a>';
    echo '<br><a href="./panel_de_usuario/admin.html">Regresar</a>';
} catch (PDOException $e) {
    die("Error al actualizar las metas: " . $e->getMessage());
}
?>
