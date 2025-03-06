<?php
require '../config.php';
session_start();

// Verificar si es administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.html");
    exit;
}

// Obtener el ID de la venta
$id_venta = $_GET['id'] ?? '';
if (empty($id_venta)) {
    die("ID de venta no proporcionado.");
}

// Consultar los datos de la venta
try {
    $sql = "SELECT * FROM ventas WHERE id = :id_venta";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_venta' => $id_venta]);
    $venta = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$venta) {
        die("Venta no encontrada.");
    }
} catch (PDOException $e) {
    die("Error al obtener los datos de la venta: " . $e->getMessage());
}

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto = $_POST['producto'] ?? '';
    $cantidad = $_POST['cantidad'] ?? '';
    $total = $_POST['total'] ?? '';
    $fecha_venta = $_POST['fecha_venta'] ?? '';

    if (empty($producto) || empty($cantidad) || empty($total) || empty($fecha_venta)) {
        die("Por favor, completa todos los campos.");
    }

    try {
        $sql = "UPDATE ventas 
                SET producto = :producto, cantidad = :cantidad, total = :total, fecha_venta = :fecha_venta
                WHERE id = :id_venta";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':producto' => $producto,
            ':cantidad' => $cantidad,
            ':total' => $total,
            ':fecha_venta' => $fecha_venta,
            ':id_venta' => $id_venta
        ]);

        header("Location: admin_ventas.php");
        exit;
    } catch (PDOException $e) {
        die("Error al actualizar la venta: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Venta</title>
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body>
    
    <form method="POST">
        <h2>Editar Venta</h2>
        <label for="producto">Producto:</label>
        <input type="text" name="producto" id="producto" value="<?= htmlspecialchars($venta['producto']) ?>" required>
        <br>
        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" value="<?= htmlspecialchars($venta['cantidad']) ?>" required>
        <br>
        <label for="total">Total:</label>
        <input type="number" step="0.01" name="total" id="total" value="<?= htmlspecialchars($venta['total']) ?>" required>
        <br>
        <label for="fecha_venta">Fecha de Venta:</label>
        <input type="date" name="fecha_venta" id="fecha_venta" value="<?= htmlspecialchars($venta['fecha_venta']) ?>" required>
        <br>
        <button type="submit">Guardar Cambios</button>
    </form>
    <a href="admin_ventas.php">Cancelar</a>
</body>
</html>
