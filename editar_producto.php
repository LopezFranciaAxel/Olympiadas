<?php
include 'conexionBD.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $imagen = $_POST['imagen'];

    $query = "UPDATE productos SET nombre = '$nombre', precio = '$precio', imagen = '$imagen' WHERE id = $id";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        echo '
        <script>
            alert("Producto actualizado exitosamente");
            window.location = "admin.php";
        </script>';
    } else {
        echo '
        <script>
            alert("Error al actualizar el producto. Inténtalo de nuevo.");
            window.location = "admin.php";
        </script>';
    }
} else {
    echo '
    <script>
        alert("ID de producto no proporcionado.");
        window.location = "admin.php";
    </script>';
}
?>
