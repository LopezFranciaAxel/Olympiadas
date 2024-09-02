<?php
include 'conexionBD.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM productos WHERE id = $id";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        echo '
        <script>
            alert("Producto eliminado exitosamente");
            window.location = "admin.php";
        </script>';
    } else {
        echo '
        <script>
            alert("Error al eliminar el producto. Inténtalo de nuevo.");
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
