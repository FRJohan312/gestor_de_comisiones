<?php
require '../config.php';
session_start();

// Verificar si es administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.html");
    exit;
}

// Validar el ID del usuario
$id_usuario = $_GET['id'] ?? null;
if (empty($id_usuario)) {
    die("ID de usuario no proporcionado.");
}

// Obtener la información del usuario
$sql = "SELECT id, nombre, correo, activo FROM usuarios WHERE id = :id_usuario";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_usuario' => $id_usuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Usuario no encontrado.");
}

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $activo = isset($_POST['activo']) ? 1 : 0;

    // Validar campos obligatorios
    if (empty($nombre) || empty($correo)) {
        die("Por favor, complete los campos obligatorios.");
    }

    try {
        // Actualizar los datos básicos del usuario
        $sql = "UPDATE usuarios SET nombre = :nombre, correo = :correo, activo = :activo WHERE id = :id_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':correo' => $correo,
            ':activo' => $activo,
            ':id_usuario' => $id_usuario,
        ]);

        echo "Usuario actualizado exitosamente.";
        header("Location: admin_empleados.php");
        exit;
    } catch (PDOException $e) {
        die("Error al actualizar el usuario: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body>
    <h2>Editar Usuario</h2>

    <form action="editar_usuario.php?id=<?= htmlspecialchars($usuario['id']) ?>" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($usuario['correo']) ?>" required>

        <label for="activo">Activo:</label>
        <input type="checkbox" id="activo" name="activo" <?= $usuario['activo'] ? 'checked' : '' ?>>

        <button type="submit">Actualizar</button>
    </form>

    <a href="admin_empleados.php">Volver al Panel</a>
</body>
</html>
