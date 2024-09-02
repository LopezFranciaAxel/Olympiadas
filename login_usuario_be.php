<?php
include 'conexionBD.php';

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

$validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario' and contrasena='$contrasena'");

if(mysqli_num_rows($validar_login) > 0){
    $usuario_data = mysqli_fetch_assoc($validar_login);
    session_start();
    $_SESSION['usuario'] = $usuario_data['usuario'];
    $_SESSION['admin'] = ($usuario_data['usuario'] === 'admin') ? true : false;
    
    echo '
    <script>
     alert("Ingreso correctamente");
     window.location = "index.php"
    </script>
    ';
    exit;
} else {
    echo '
    <script>
     alert("Usuario o contraseña no existe");
     window.location = "registro.php"
    </script>
    ';
    exit;
}

?>
