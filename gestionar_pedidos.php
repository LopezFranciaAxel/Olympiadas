<?php
session_start();
if ($_SESSION['usuario'] !== 'admin') {
    header("Location: index.php");
    exit();
}
include 'conexionBD.php';
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Gestionar Pedidos - TU SONIDO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página para gestionar pedidos">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Gestionar Pedidos</h1>
        <nav>
            <a href="admin.php">Administrador</a>
            <a href="index.php">Inicio</a>
            <a href="login.php">Cerrar Sesión</a>
        </nav>
    </header>

    <section class="admin-pedidos">
        <h2>Listado de Pedidos</h2>
        <table id="pedidos">
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Usuario</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT p.*, u.usuario, pr.nombre AS producto_nombre FROM pedidos p
                          JOIN usuarios u ON p.usuario_id = u.id
                          JOIN productos pr ON p.producto_id = pr.id";
                $result = mysqli_query($conexion, $query);

                while($row = mysqli_fetch_assoc($result)) {
                    echo '
                    <tr>
                        <td>'.$row['id'].'</td>
                        <td>'.$row['usuario'].'</td>
                        <td>'.$row['producto_nombre'].'</td>
                        <td>'.$row['cantidad'].'</td>
                        <td>'.$row['fecha'].'</td>
                        <td>'.$row['estado'].'</td>
                        <td>
                            <a href="cambiar_estado_pedido.php?id='.$row['id'].'">Cambiar Estado</a>
                            <a href="eliminar_pedido.php?id='.$row['id'].'">Eliminar</a>
                        </td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
    </section>

    <footer>
        <p>© 2024 TU SONIDO</p>
    </footer>
</body>
</html>
