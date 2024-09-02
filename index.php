<?php
session_start();
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Mi Página de Auriculares</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página de Auriculares">
    <meta name="keywords" content="Auriculares, Electrónica, Compras">
    <link rel="stylesheet" href="style.css">
    <style>
        .productos {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .producto {
            width: 300px;
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .producto img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .carrito {
            position: fixed;
            bottom: 0;
            right: 0;
            width: 300px;
            background-color: #333;
            color: #fff;
            padding: 20px;
            border-top-left-radius: 10px;
            display: none;
        }

        .carrito h2 {
            margin-top: 0;
        }

        .carrito-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .carrito-total {
            font-weight: bold;
            margin-top: 20px;
        }

        .btn-comprar {
            background-color: #28a745;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <h1>Bienvenido a TU SONIDO</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="pedidos.php">Historial de Pedidos</a>
            <a href="admin.php">Administrador</a>
            <a href="login.php">
                <?php echo isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Iniciar Sesión'; ?>
            </a>
        </nav>
    </header>

    <section class="productos">
        <?php
        include 'conexionBD.php';
        $query = "SELECT * FROM productos";
        $result = mysqli_query($conexion, $query);

        while($row = mysqli_fetch_assoc($result)) {
            echo '
            <div class="producto">
                <img src="'.$row['imagen'].'" alt="'.$row['nombre'].'">
                <h3>'.$row['nombre'].'</h3>
                <p>Precio: $'.$row['precio'].'</p>
                <button class="btn-agregar-carrito" data-id="'.$row['id'].'" data-nombre="'.$row['nombre'].'" data-precio="'.$row['precio'].'">Agregar al Carrito</button>
            </div>';
        }
        ?>
    </section>

    <div class="carrito" id="carrito">
        <h2>Carrito de Compras</h2>
        <div id="carrito-items"></div>
        <div class="carrito-total">
            Total: $<span id="carrito-total">0.00</span>
        </div>
        <button class="btn-comprar" id="btn-comprar">Comprar</button>
    </div>

    <script>
        const carrito = [];
        const carritoElement = document.getElementById('carrito');
        const carritoItemsElement = document.getElementById('carrito-items');
        const carritoTotalElement = document.getElementById('carrito-total');

        document.querySelectorAll('.btn-agregar-carrito').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const nombre = button.getAttribute('data-nombre');
                const precio = parseFloat(button.getAttribute('data-precio'));

                const producto = carrito.find(p => p.id === id);
                if (producto) {
                    producto.cantidad++;
                } else {
                    carrito.push({ id, nombre, precio, cantidad: 1 });
                }

                actualizarCarrito();
            });
        });

        function actualizarCarrito() {
            carritoItemsElement.innerHTML = '';
            let total = 0;

            carrito.forEach(producto => {
                const itemElement = document.createElement('div');
                itemElement.className = 'carrito-item';
                itemElement.innerHTML = `
                    <span>${producto.nombre} x${producto.cantidad}</span>
                    <span>$${(producto.precio * producto.cantidad).toFixed(2)}</span>
                `;
                carritoItemsElement.appendChild(itemElement);

                total += producto.precio * producto.cantidad;
            });

            carritoTotalElement.textContent = total.toFixed(2);
            carritoElement.style.display = carrito.length > 0 ? 'block' : 'none';
        }

        document.getElementById('btn-comprar').addEventListener('click', () => {
            if (carrito.length > 0) {
                alert('Compra realizada con éxito');
                carrito.length = 0;
                actualizarCarrito();
            }
        });
    </script>
</body>
</html>
