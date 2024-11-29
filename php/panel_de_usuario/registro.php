<?php
require '../config.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $identificacion = $_POST['identificacion'] ?? '';
    $contrasena = $_POST['password'] ?? '';

    if (empty($nombre) || empty($correo) || empty($identificacion) || empty($contrasena)) {
        die("Por favor, completa todos los campos.");
    }

    // Encriptar la contraseña
    $contraseña_encriptada = password_hash($contrasena, PASSWORD_BCRYPT);

    try {
        // Insertar el usuario en la base de datos
        $sql = "INSERT INTO usuarios (nombre, correo, identificacion, contraseña) 
                VALUES (:nombre, :correo, :identificacion, :contrasena)";
        $stmt = $pdo->prepare($sql);
        $resultado = $stmt->execute([
            ':nombre' => $nombre,
            ':correo' => $correo,
            ':identificacion' => $identificacion,
            ':contrasena' => $contraseña_encriptada,
        ]);
        
        if (!$resultado) {
            print_r($stmt->errorInfo());
            exit;
        }

        echo "Usuario registrado exitosamente.";
        echo '<br><a href="http://localhost/gestor_comisiones/php/panel_de_usuario/login.html">Iniciar Sesión</a>';
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Código para duplicados
            die("El correo o la identificación ya están registrados.");
        }
        die("Error: " . $e->getMessage());
    }
}
?>
