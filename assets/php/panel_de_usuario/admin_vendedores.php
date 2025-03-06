<?php
require '../config.php';
session_start();

// Verificar si es administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.html");
    exit;
}

try {
    // Obtener lista de vendedores
    $sql = "SELECT nombre, identificacion, correo, activo FROM vendedores";
    $stmt = $pdo->query($sql);
    $vendedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al consultar vendedores: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Vendedores</title>
    <!-- <link rel="stylesheet" href="../../css/styles.css"> -->
</head>
<body>
    <h2>Administrar Vendedores</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Identificación</th>
                <th>Correo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vendedores as $vendedor): ?>
                <tr>
                    <td><?= htmlspecialchars($vendedor['nombre']) ?></td>
                    <td><?= htmlspecialchars($vendedor['identificacion']) ?></td>
                    <td><?= htmlspecialchars($vendedor['correo']) ?></td>
                    <td><?= $vendedor['activo'] ? 'Activo' : 'Inactivo' ?></td>
                    <td>
                        <a href="editar_vendedor.php?identificacion=<?= $vendedor['identificacion'] ?>">Editar</a>                    |
                        <a href="eliminar_vendedor.php?identificacion=<?= $vendedor['identificacion'] ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar a este vendedor?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="./dashboard/dashboard_admin.php">Volver al Panel</a>
</body>
</html>
