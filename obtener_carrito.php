<?php
session_start();
include 'conexionBD.php';

$usuario = $_SESSION['usuario'];
$query = "SELECT c.cantidad, p.nombre, p.precio, p.imagen 
          FROM carrito c 
          JOIN productos p ON c.producto_id = p.id 
          WHERE c.usuario = '$usuario'";
$result = mysqli_query($conexion, $query);

$carrito = array();

while ($row = mysqli_fetch_assoc($result)) {
    $carrito[] = array(
        'nombre' => $row['nombre'],
        'cantidad' => $row['cantidad'],
        'precio' => $row['precio'] * $row['cantidad'],
        'imagen' => $row['imagen']
    );
}

echo json_encode($carrito);

mysqli_close($conexion);
?>
