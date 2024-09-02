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
    <title>Administrador - TU SONIDO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página de administración de productos">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Panel de Administración</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="pedidos.php">Historial de Compras</a>
            <a href="login.php">Cerrar Sesión</a>
        </nav>
    </header>

    <section class="admin-productos">
        <h2>Gestionar Productos</h2>
        <table id="productos">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM productos";
                $result = mysqli_query($conexion, $query);

                while($row = mysqli_fetch_assoc($result)) {
                    echo '
                    <tr>
                        <td><img src="'.$row['imagen'].'" alt="'.$row['nombre'].'" width="100"></td>
                        <td>'.$row['nombre'].'</td>
                        <td>'.$row['precio'].'</td>
                        <td>
                            <a href="editar_producto.php?id='.$row['id'].'">Editar</a>
                            <a href="eliminar_producto.php?id='.$row['id'].'">Eliminar</a>
                        </td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>

        <h3>Agregar Nuevo Producto</h3>
        <form action="agregar_producto.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="nombre" placeholder="Nombre del Producto" required>
            <input type="text" name="precio" placeholder="Precio" required>
            <input type="file" name="imagen" required>
            <button type="submit">Agregar Producto</button>
        </form>
    </section>

    <footer>
        <p>© 2024 TU SONIDO</p>
    </footer>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
