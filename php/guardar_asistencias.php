<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identificacion = $_POST['id_vendedor'] ?? null;
    $fecha = $_POST['fecha'] ?? null;
    $estado = $_POST['estado'] ?? null;

    if (empty($identificacion) || empty($fecha) || empty($estado)) {
        die("Por favor, completa todos los campos.");
    }

    try {
        $sql = "INSERT INTO asistencias (identificacion, fecha, estado)
                VALUES (:identificacion, :fecha, :estado)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':identificacion' => $identificacion,
            ':fecha' => $fecha,
            ':estado' => $estado,
        ]);

        echo "Asistencia registrada exitosamente.";
    } catch (PDOException $e) {
        die("Error al registrar la asistencia: " . $e->getMessage());
    }
} else {
    die("Acceso no permitido.");
}
?>
