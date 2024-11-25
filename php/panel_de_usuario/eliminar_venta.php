<?php
require '../config.php';
session_start();

// Verificar si es administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.html");
    exit;
}

$id_venta = $_GET['id'] ?? '';
$nuevo_estado = $_GET['estado'] ?? '';

if (empty($id_venta) || !in_array($nuevo_estado, ['0', '1'])) {
    die("Datos inválidos.");
}

try {
    // Inhabilitar o habilitar la venta (actualizar el campo 'activo')
    $sql = "UPDATE ventas SET activo = :nuevo_estado WHERE id = :id_venta";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nuevo_estado' => $nuevo_estado,
        ':id_venta' => $id_venta
    ]);

    // Obtener la identificación y el periodo de la venta
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

        // Actualizar el estado de la meta relacionada (calcular si se cumplió o no)
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
            AND v.activo = 1 -- Solo contar ventas activas
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
    die("Error al actualizar el estado de la venta o la meta: " . $e->getMessage());
}
?>
