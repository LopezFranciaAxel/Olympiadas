<?php
include 'conexionBD.php';

if (isset($_POST['id_pedido']) && isset($_POST['estado'])) {
    $id_pedido = $_POST['id_pedido'];
    $estado = $_POST['estado'];

    $query = "UPDATE pedidos SET estado = '$estado' WHERE id = $id_pedido";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        echo '
        <script>
            alert("Estado del pedido actualizado exitosamente");
            window.location = "admin.php";
        </script>';
    } else {
        echo '
        <script>
            alert("Error al actualizar el estado del pedido. Inténtalo de nuevo.");
            window.location = "admin.php";
        </script>';
    }
} else {
    echo '
    <script>
        alert("ID de pedido o estado no proporcionado.");
        window.location = "admin.php";
    </script>';
}
?>
