<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identificacion = $_POST['id_vendedor'] ?? null;
    $producto = $_POST['producto'] ?? null;
    $cantidad = $_POST['cantidad'] ?? null;
    $total = $_POST['total'] ?? null;
    $fecha_venta = $_POST['fecha_venta'] ?? null;

    // Validar los datos
    if (empty($identificacion) || empty($producto) || empty($cantidad) || empty($total) || empty($fecha_venta)) {
        die("Por favor, completa todos los campos.");
    }

    try {
        $tasa_comision = 0.1; // Comisión del 10%
        $comision = $total * $tasa_comision;

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

        echo "Venta registrada exitosamente.";
    } catch (PDOException $e) {
        die("Error al registrar la venta: " . $e->getMessage());
    }
} else {
    die("Acceso no permitido.");
}
?>

