<?php
include 'conexionBD.php';

$query = "SELECT * FROM productos";
$result = mysqli_query($conexion, $query);

$productos = array();

while ($row = mysqli_fetch_assoc($result)) {
    $productos[] = array(
        'id' => $row['id'],
        'nombre' => $row['nombre'],
        'precio' => $row['precio'],
        'imagen' => $row['imagen']
    );
}

echo json_encode($productos);

mysqli_close($conexion);
?>
