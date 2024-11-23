<?php
require '../config.php'; // Conexión a la base de datos
session_start(); // Iniciar la sesión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'] ?? '';
    $contraseña = $_POST['password'] ?? '';

    if (empty($correo) || empty($contraseña)) {
        die("Por favor, completa todos los campos.");
    }

    try {
        // Buscar el usuario por correo
        $sql = "SELECT id, nombre, contraseña FROM usuarios WHERE correo = :correo";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':correo' => $correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
            // Guardar datos del usuario en la sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];

            echo "Inicio de sesión exitoso.";
            echo '<br><a href="dashboard.php">Ir al panel</a>';
        } else {
            echo "Correo o contraseña incorrectos.";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
