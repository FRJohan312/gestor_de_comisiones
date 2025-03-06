<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identificacion = $_POST['id_vendedor'] ?? null;
    $periodo = $_POST['periodo'] ?? null;
    $meta = $_POST['meta'] ?? null;

    // Validar los datos
    if (empty($identificacion) || empty($periodo) || empty($meta)) {
        die("Por favor, completa todos los campos.");
    }

    try {
        // Insertar la meta en la tabla metas_ventas
        $sql = "INSERT INTO metas_ventas (identificacion, periodo, meta)
                VALUES (:identificacion, :periodo, :meta)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':identificacion' => $identificacion,
            ':periodo' => $periodo,
            ':meta' => $meta,
        ]);

        // Actualizar la columna 'cumplida' de acuerdo a las ventas activas
        $updateSql = "
        UPDATE metas_ventas m
        SET m.cumplida = (
            SELECT CASE 
                WHEN COALESCE(SUM(v.total), 0) >= m.meta THEN 1
                ELSE 0
            END
            FROM ventas v
            WHERE v.identificacion = m.identificacion
            AND DATE_FORMAT(v.fecha_venta, '%Y-%m') = m.periodo
            AND v.activo = 1 -- Solo ventas activas
        )
        WHERE m.identificacion = :identificacion
        AND m.periodo = :periodo
        ";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute([
            ':identificacion' => $identificacion,
            ':periodo' => $periodo,
        ]);

        echo "Meta registrada y estado de cumplimiento actualizado exitosamente.";
    } catch (PDOException $e) {
        die("Error al registrar la meta: " . $e->getMessage());
    }
} else {
    die("Acceso no permitido.");
}
?>
