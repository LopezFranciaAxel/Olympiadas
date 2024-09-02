<?php
session_start();
include 'conexionBD.php';

$producto_id = $_POST['id'];
$usuario = $_SESSION['usuario'];

// Verifica si el producto ya está en el carrito
$query = "SELECT * FROM carrito WHERE usuario='$usuario' AND producto_id='$producto_id'";
$result = mysqli_query($conexion, $query);

if (mysqli_num_rows($result) > 0) {
    // Si el producto ya está en el carrito, incrementar la cantidad
    $query = "UPDATE carrito SET cantidad = cantidad + 1 WHERE usuario='$usuario' AND producto_id='$producto_id'";
} else {
    // Si no está en el carrito, agregarlo con cantidad 1
    $query = "INSERT INTO carrito (usuario, producto_id, cantidad) VALUES ('$usuario', '$producto_id', 1)";
}

if (mysqli_query($conexion, $query)) {
    echo "Producto agregado al carrito.";
} else {
    echo "Error al agregar el producto al carrito.";
}

mysqli_close($conexion);
?>
