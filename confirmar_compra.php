<?php
session_start();
include 'conexionBD.php';

$usuario_id = $_SESSION['usuario_id'];

$query = "UPDATE pedidos SET estado = 'confirmado' WHERE usuario_id = '$usuario_id' AND estado = 'pendiente'";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

mysqli_close($conexion);
?>
