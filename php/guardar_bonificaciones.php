<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identificacion = $_POST['id_vendedor'] ?? null;
    $motivo = $_POST['motivo'] ?? null;
    $monto = $_POST['monto'] ?? null;
    $fecha_asignacion = $_POST['fecha_asignacion'] ?? null;

    if (empty($identificacion) || empty($motivo) || empty($monto) || empty($fecha_asignacion)) {
        die("Por favor, completa todos los campos.");
    }

    try {
        $sql = "INSERT INTO bonificaciones (identificacion, motivo, monto, fecha_asignacion)
                VALUES (:identificacion, :motivo, :monto, :fecha_asignacion)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':identificacion' => $identificacion,
            ':motivo' => $motivo,
            ':monto' => $monto,
            ':fecha_asignacion' => $fecha_asignacion,
        ]);

        echo "Bonificación registrada exitosamente.";
    } catch (PDOException $e) {
        die("Error al registrar la bonificación: " . $e->getMessage());
    }
} else {
    die("Acceso no permitido.");
}
?>
