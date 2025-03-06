<?php
require '../config.php';
session_start();

// Verificar si es administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.html");
    exit;
}

$id_venta = $_GET['id'] ?? '';

if (empty($id_venta)) {
    die("Datos inválidos.");
}

try {
    // Obtener la identificación y el periodo de la venta antes de eliminarla
    $ventaSql = "
        SELECT identificacion, DATE_FORMAT(fecha_venta, '%Y-%m') AS periodo
        FROM ventas
        WHERE id = :id_venta
    ";
    $ventaStmt = $pdo->prepare($ventaSql);
    $ventaStmt->execute([':id_venta' => $id_venta]);
    $venta = $ventaStmt->fetch(PDO::FETCH_ASSOC);

    if ($venta) {
        $identificacion = $venta['identificacion'];
        $periodo = $venta['periodo'];

        // Eliminar la venta de la base de datos
        $deleteSql = "DELETE FROM ventas WHERE id = :id_venta";
        $deleteStmt = $pdo->prepare($deleteSql);
        $deleteStmt->execute([':id_venta' => $id_venta]);

        // Actualizar el estado de la meta relacionada (recalcular si se cumplió o no)
        $updateMetaSql = "
        UPDATE metas_ventas m
        SET m.cumplida = (
            SELECT CASE 
                WHEN COALESCE(SUM(v.total), 0) >= m.meta THEN 1
                ELSE 0
            END
            FROM ventas v
            WHERE v.identificacion = m.identificacion
            AND DATE_FORMAT(v.fecha_venta, '%Y-%m') = m.periodo
        )
        WHERE m.identificacion = :identificacion
        AND m.periodo = :periodo
        ";
        $updateMetaStmt = $pdo->prepare($updateMetaSql);
        $updateMetaStmt->execute([
            ':identificacion' => $identificacion,
            ':periodo' => $periodo
        ]);
    }

    // Redirigir de vuelta a la lista de ventas
    header("Location: admin_ventas.php");
    exit;
} catch (PDOException $e) {
    die("Error al eliminar la venta o actualizar la meta: " . $e->getMessage());
}
?>
