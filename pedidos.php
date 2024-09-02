<?php
session_start();
include 'conexionBD.php';

if (!isset($_SESSION['usuario'])) {
    echo '
    <script>
        alert("Por favor, inicie sesión");
        window.location = "login.php";
    </script>
    ';
    exit();
}

$usuario = $_SESSION['usuario'];

// Obtener el ID del usuario
$query_usuario = "SELECT id FROM usuarios WHERE usuario='$usuario'";
$result_usuario = mysqli_query($conexion, $query_usuario);

if ($result_usuario && mysqli_num_rows($result_usuario) > 0) {
    $row_usuario = mysqli_fetch_assoc($result_usuario);
    $id_usuario = $row_usuario['id'];
} else {
    echo '
    <script>
        alert("Usuario no encontrado");
        window.location = "login.php";
    </script>
    ';
    exit();
}

// Obtener el historial de pedidos del usuario
$query_pedidos = "SELECT * FROM pedidos WHERE id_usuario='$id_usuario' ORDER BY fecha DESC";
$result_pedidos = mysqli_query($conexion, $query_pedidos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Pedidos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Historial de Pedidos</h1>

    <?php if (mysqli_num_rows($result_pedidos) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Fecha</th>
                    <th>Productos</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row_pedido = mysqli_fetch_assoc($result_pedidos)): ?>
                    <tr>
                        <td><?php echo $row_pedido['id']; ?></td>
                        <td><?php echo $row_pedido['fecha']; ?></td>
                        <td>
                            <?php
                            $query_detalles = "SELECT p.nombre, dp.cantidad 
                                               FROM detalle_pedidos dp 
                                               INNER JOIN productos p ON dp.id_producto = p.id 
                                               WHERE dp.id_pedido = " . $row_pedido['id'];
                            $result_detalles = mysqli_query($conexion, $query_detalles);
                            if ($result_detalles && mysqli_num_rows($result_detalles) > 0) {
                                while ($row_detalle = mysqli_fetch_assoc($result_detalles)) {
                                    echo $row_detalle['nombre'] . " (" . $row_detalle['cantidad'] . ")<br>";
                                }
                            } else {
                                echo "No se encontraron detalles para este pedido.";
                            }
                            ?>
                        </td>
                        <td><?php echo $row_pedido['total']; ?></td>
                        <td><?php echo $row_pedido['estado']; ?></td>
                        <td>
                            <?php if ($row_pedido['estado'] == 'Pendiente'): ?>
                                <a href="cancelar_pedido.php?id_pedido=<?php echo $row_pedido['id']; ?>">Cancelar</a>
                            <?php else: ?>
                                No disponible
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No has realizado ningún pedido.</p>
    <?php endif; ?>
</body>
</html>

<?php
mysqli_close($conexion);
?>
