<?php
include 'conexionBD.php';

if (isset($_GET['id_pedido'])) {
    $id_pedido = $_GET['id_pedido'];

    $query = "DELETE FROM pedidos WHERE id = $id_pedido";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        echo '
        <script>
            alert("Pedido eliminado exitosamente");
            window.location = "admin.php";
        </script>';
    } else {
        echo '
        <script>
            alert("Error al eliminar el pedido. Inténtalo de nuevo.");
            window.location = "admin.php";
        </script>';
    }
} else {
    echo '
    <script>
        alert("ID de pedido no proporcionado.");
        window.location = "admin.php";
    </script>';
}
?>
