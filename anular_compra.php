<?php
session_start();
include 'conexionBD.php';

$usuario_id = $_SESSION['usuario_id'];

$query = "DELETE FROM pedidos WHERE usuario_id = '$usuario_id' AND estado = 'pendiente'";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

mysqli_close($conexion);
?>
