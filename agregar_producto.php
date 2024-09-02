<?php
include 'conexionBD.php';

if (isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['imagen'])) {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $imagen = $_POST['imagen'];

    $query = "INSERT INTO productos (nombre, precio, imagen) VALUES ('$nombre', '$precio', '$imagen')";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        echo '
        <script>
            alert("Producto agregado exitosamente");
            window.location = "admin.php";
        </script>';
    } else {
        echo '
        <script>
            alert("Error al agregar el producto. Inténtalo de nuevo.");
            window.location = "admin.php";
        </script>';
    }
} else {
    echo '
    <script>
        alert("Por favor completa todos los campos.");
        window.location = "admin.php";
    </script>';
}
?>
