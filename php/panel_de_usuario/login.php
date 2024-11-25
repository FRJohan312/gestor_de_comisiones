<?php
require '../config.php';
session_start();

// Verificar si se enviaron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $contraseña = trim($_POST['contraseña'] ?? '');

    // Validar que los campos no estén vacíos
    if (empty($correo) || empty($contraseña)) {
        die("Por favor, complete todos los campos.");
    }

    try {
        // Consultar la base de datos para verificar el usuario
        $sql = "SELECT id, nombre, contraseña, rol, activo FROM usuarios WHERE correo = :correo";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':correo' => $correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Verificar si el usuario está activo
            if ($usuario['activo'] == 0) {
                die("Tu cuenta está inhabilitada. Contacta al administrador.");
            }

            // Verificar la contraseña
            if (password_verify($contraseña, $usuario['contraseña'])) {
                // Establecer la sesión
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_rol'] = $usuario['rol'];

                // Redirigir al panel correspondiente según el rol
                if ($usuario['rol'] === 'admin') {
                    header("Location: ../panel_de_usuario/dashboard_admin.php");
                } else {
                    header("Location: ../panel_de_usuario/dashboard_empleado.php");
                }
                exit;
            } else {
                die("Correo o contraseña incorrectos.");
            }
        } else {
            die("Correo o contraseña incorrectos.");
        }
    } catch (PDOException $e) {
        die("Error en la conexión a la base de datos: " . $e->getMessage());
    }
} else {
    die("Acceso no autorizado.");
}
?>
