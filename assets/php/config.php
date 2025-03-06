<?php
$host = "localhost";
$dbname = "gestor_de_comisiones";
$username = "root";
$password = "Mvxf8BUuo9sq*bpQ";

try {
    // Crear la conexión
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Configurar el manejo de errores
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>
