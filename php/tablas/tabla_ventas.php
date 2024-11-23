<?php
require '../config.php';

try {
    $sql = "SELECT m.identificacion, v.nombre, m.periodo, m.meta, m.ventas_actuales, m.cumplida
            FROM metas_ventas m
            INNER JOIN vendedores v ON m.identificacion = v.identificacion";
    $stmt = $pdo->query($sql);
    $metas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al cargar metas: " . $e->getMessage());
}

echo "<table border='1'>";
echo "<tr><th>Vendedor</th><th>Periodo</th><th>Meta</th><th>Ventas Actuales</th><th>Cumplida</th></tr>";
foreach ($metas as $meta) {
    echo "<tr>";
    echo "<td>{$meta['nombre']}</td>";
    echo "<td>{$meta['periodo']}</td>";
    echo "<td>{$meta['meta']}</td>";
    echo "<td>{$meta['ventas_actuales']}</td>";
    echo "<td>" . ($meta['cumplida'] ? 'Sí' : 'No') . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
