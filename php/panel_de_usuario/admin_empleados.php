<?php
require '../config.php';
session_start();

// Verificar si es administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.html");
    exit;
}

// Obtener lista de empleados
$sql = "SELECT id, nombre, correo, contraseña, activo FROM usuarios WHERE rol = 'empleado'";
$stmt = $pdo->query($sql);
$empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Empleados</title>
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body>
    <h2>Administrar Empleados</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($empleados as $empleado): ?>
                <tr>
                    <td><?= htmlspecialchars($empleado['nombre']) ?></td>
                    <td><?= htmlspecialchars($empleado['correo']) ?></td>
                    <td><?= $empleado['activo'] ? 'Activo' : 'Inactivo' ?></td>
                    <td>
                        <a href="editar_usuario.php?id=<?= $empleado['id'] ?>">Editar</a>
                        <a href="inhabilitar_empleado.php?id=<?= $empleado['id'] ?>&estado=<?= $empleado['activo'] ? 0 : 1 ?>">
                            <?= $empleado['activo'] ? 'Inhabilitar' : 'Habilitar' ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="dashboard_admin.php">Volver al Panel</a>
</body>
</html>
