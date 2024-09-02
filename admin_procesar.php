<?php
session_start();
if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header('Location: index.php');
    exit;
}
include 'conexionBD.php';

if ($_POST['accion'] === 'agregar') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $imagen = $_FILES['imagen']['name'];
    
    // Subir imagen y guardar en la base de datos
    move_uploaded_file($_FILES['imagen']['tmp_name'], "imagenes/$imagen");
    
    $query = "INSERT INTO productos (nombre, precio, imagen) VALUES ('$nombre', '$precio', '$imagen')";
    mysqli_query($conexion, $query);
    header('Location: admin.php');
}
?>
