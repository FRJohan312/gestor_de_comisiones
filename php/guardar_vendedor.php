<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identificacion = $_POST['identificacion'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    // Validar los datos
    if (empty($identificacion) || empty($nombre) || empty($correo)) {
        die("Por favor, completa todos los campos obligatorios.");
    }

    try {
        // Consulta para insertar un nuevo vendedor
        $sql = "INSERT INTO vendedores (identificacion, nombre, correo, telefono) 
                VALUES (:identificacion, :nombre, :correo, :telefono)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':identificacion' => $identificacion,
            ':nombre' => $nombre,
            ':correo' => $correo,
            ':telefono' => $telefono
        ]);

        echo "Vendedor agregado exitosamente.";
    } catch (PDOException $e) {
        // Manejar errores, como claves duplicadas
        if ($e->getCode() == 23000) {
            die("El número de identificación o correo ya existe.");
        }
        die("Error al guardar el vendedor: " . $e->getMessage());
    }
} else {
    die("Acceso no permitido.");
}
?>
