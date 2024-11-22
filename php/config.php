<?php
// Configuración de conexión a la base de datos
$host = "localhost"; // Cambiar si tu base está en un servidor remoto
$dbname = "gestor_de_comisiones"; // Nombre de tu base de datos
$username = "root"; // Usuario de la base de datos
$password = "Mvxf8BUuo9sq*bpQ"; // Contraseña de la base de datos

try {
    // Crear la conexión
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Configurar el manejo de errores
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>
