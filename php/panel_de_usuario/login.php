<?php
require '../config.php'; // Conexión a la base de datos
session_start(); // Iniciar la sesión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contraseña'] ?? '';

    if (empty($correo) || empty($contrasena)) {
        die("Por favor, completa todos los campos.");
    }

    try {
        // Buscar el usuario por correo
        $sql = "SELECT id, nombre, contraseña, rol FROM usuarios WHERE correo = :correo";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':correo' => $correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            die("Correo no encontrado. Verifica tus datos.");
        }

        if (password_verify($contrasena, $usuario['contraseña'])) {
            // Guardar datos del usuario en la sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_rol'] = $usuario['rol'];

            // Redirigir según el rol
            if ($usuario['rol'] === 'admin') {
                header("Location: dashboard_admin.php");
            } else {
                header("Location: dashboard_empleado.php");
            }
            exit;
        } else {
            echo "Correo o contraseña incorrectos.";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
