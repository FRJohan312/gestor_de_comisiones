<?php
// Habilitar CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");

require 'config.php';

try {
    $vendedores = $pdo->query("SELECT identificacion, nombre FROM vendedores")->fetchAll(PDO::FETCH_ASSOC);

    foreach ($vendedores as $vendedor) {
        echo "<option value='{$vendedor['identificacion']}'>{$vendedor['nombre']}</option>\n";
    }
} catch (PDOException $e) {
    echo "<option value=''>Error al cargar vendedores</option>";
}
?>
