<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identificacion = $_POST['id_vendedor'] ?? null;
    $producto = $_POST['producto'] ?? null;
    $cantidad = $_POST['cantidad'] ?? null;
    $total = $_POST['total'] ?? null;
    $fecha_venta = $_POST['fecha_venta'] ?? null;

    if (empty($identificacion) || empty($producto) || empty($cantidad) || empty($total) || empty($fecha_venta)) {
        die("Por favor, completa todos los campos.");
    }

    try {
        // Calcular la comisión
        $tasa_comision = 0.1;
        $comision = $total * $tasa_comision;

        // Insertar la venta
        $sql = "INSERT INTO ventas (identificacion, producto, cantidad, total, fecha_venta, comision)
                VALUES (:identificacion, :producto, :cantidad, :total, :fecha_venta, :comision)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':identificacion' => $identificacion,
            ':producto' => $producto,
            ':cantidad' => $cantidad,
            ':total' => $total,
            ':fecha_venta' => $fecha_venta,
            ':comision' => $comision,
        ]);

        // Actualizar las metas relacionadas con el vendedor y el periodo
        $updateSql = "
        UPDATE metas_ventas m
        SET ventas_actuales = (
            SELECT COALESCE(SUM(v.total), 0)
            FROM ventas v
            WHERE v.identificacion = m.identificacion
            AND DATE_FORMAT(v.fecha_venta, '%Y-%m') = m.periodo
        ),
        cumplida = ventas_actuales >= meta
        WHERE m.identificacion = :identificacion
        ";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute([
            ':identificacion' => $identificacion,
        ]);

        echo "Venta registrada y metas actualizadas correctamente.";
    } catch (PDOException $e) {
        die("Error al registrar la venta: " . $e->getMessage());
    }
} else {
    die("Acceso no permitido.");
}
?>
