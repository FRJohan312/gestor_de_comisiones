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

// Consultar los datos del vendedor
try {
    $sql = "SELECT nombre, identificacion, correo, activo FROM vendedores WHERE identificacion = :identificacion_vendedor";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':identificacion_vendedor' => $identificacion_vendedor]);
    $vendedor = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$vendedor) {
        die("Vendedor no encontrado.");
    }
} catch (PDOException $e) {
    die("Error al obtener los datos del vendedor: " . $e->getMessage());
}

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $activo = $_POST['activo'] ?? '0';

    if (empty($nombre) || empty($correo)) {
        die("Por favor, completa todos los campos.");
    }

    try {
        $sql = "UPDATE vendedores SET nombre = :nombre, correo = :correo, activo = :activo WHERE identificacion = :identificacion_vendedor";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':correo' => $correo,
            ':activo' => $activo,
            ':identificacion_vendedor' => $identificacion_vendedor
        ]);

        header("Location: admin_vendedores.php");
        exit;
    } catch (PDOException $e) {
        die("Error al actualizar los datos del vendedor: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vendedor</title>
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body>
    <h2>Editar Vendedor</h2>
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($vendedor['nombre']) ?>" required>
        <br>
        <label for="correo">Correo:</label>
        <input type="email" name="correo" id="correo" value="<?= htmlspecialchars($vendedor['correo']) ?>" required>
        <br>
        <label for="activo">Estado:</label>
        <select name="activo" id="activo">
            <option value="1" <?= $vendedor['activo'] ? 'selected' : '' ?>>Activo</option>
            <option value="0" <?= !$vendedor['activo'] ? 'selected' : '' ?>>Inactivo</option>
        </select>
        <br>
        <button type="submit">Guardar Cambios</button>
    </form>
    <a href="admin_vendedores.php">Cancelar</a>
</body>
</html>
