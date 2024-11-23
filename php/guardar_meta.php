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
        $sql = "INSERT INTO metas_ventas (identificacion, periodo, meta)
                VALUES (:identificacion, :periodo, :meta)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':identificacion' => $identificacion,
            ':periodo' => $periodo,
            ':meta' => $meta,
        ]);

        echo "Meta registrada exitosamente.";
    } catch (PDOException $e) {
        die("Error al registrar la meta: " . $e->getMessage());
    }
} else {
    die("Acceso no permitido.");
}
?>
