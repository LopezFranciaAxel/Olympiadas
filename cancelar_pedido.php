<?php
session_start();
include 'conexionBD.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "UPDATE pedidos SET estado='cancelado' WHERE id='$id'";
    mysqli_query($conexion, $query);
    header('Location: pedidos.php');
}
?>
