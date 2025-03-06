<?php
require '../config.php';
session_start();

// Verificar si es administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.html");
    exit;
}

// Obtener la identificación del vendedor
$identificacion_vendedor = $_GET['identificacion'] ?? '';
if (empty($identificacion_vendedor)) {
    die("Identificación del vendedor no proporcionada.");
}

try {
    // Iniciar una transacción
    $pdo->beginTransaction();

    // 1. Eliminar registros relacionados en la tabla reportes_desempeno
    $sqlReportesDesempeno = "DELETE FROM reportes_desempeno WHERE identificacion = :identificacion_vendedor";
    $stmtReportesDesempeno = $pdo->prepare($sqlReportesDesempeno);
    $stmtReportesDesempeno->execute([':identificacion_vendedor' => $identificacion_vendedor]);

    // 2. Eliminar registros relacionados en la tabla asistencias
    $sqlAsistencias = "DELETE FROM asistencias WHERE identificacion = :identificacion_vendedor";
    $stmtAsistencias = $pdo->prepare($sqlAsistencias);
    $stmtAsistencias->execute([':identificacion_vendedor' => $identificacion_vendedor]);

    // 3. Eliminar registros relacionados en la tabla ventas
    $sqlVentas = "DELETE FROM ventas WHERE identificacion = :identificacion_vendedor";
    $stmtVentas = $pdo->prepare($sqlVentas);
    $stmtVentas->execute([':identificacion_vendedor' => $identificacion_vendedor]);

    // 4. Eliminar registros relacionados en la tabla metas_ventas
    $sqlMetas = "DELETE FROM metas_ventas WHERE identificacion = :identificacion_vendedor";
    $stmtMetas = $pdo->prepare($sqlMetas);
    $stmtMetas->execute([':identificacion_vendedor' => $identificacion_vendedor]);

    // 5. Eliminar registros relacionados en la tabla bonificaciones
    $sqlBonificaciones = "DELETE FROM bonificaciones WHERE identificacion = :identificacion_vendedor";
    $stmtBonificaciones = $pdo->prepare($sqlBonificaciones);
    $stmtBonificaciones->execute([':identificacion_vendedor' => $identificacion_vendedor]);

    // 6. Finalmente, eliminar al vendedor
    $sqlVendedor = "DELETE FROM vendedores WHERE identificacion = :identificacion_vendedor";
    $stmtVendedor = $pdo->prepare($sqlVendedor);
    $stmtVendedor->execute([':identificacion_vendedor' => $identificacion_vendedor]);

    // Confirmar la transacción
    $pdo->commit();

    // Redirigir al panel de administración de vendedores
    header("Location: admin_vendedores.php");
    exit;
} catch (PDOException $e) {
    // Revertir cambios en caso de error
    $pdo->rollBack();
    die("Error al eliminar al vendedor y sus datos asociados: " . $e->getMessage());
}
?>

