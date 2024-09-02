<?php
session_start();

$response = array();

if (isset($_SESSION['usuario'])) {
    $response['usuario'] = $_SESSION['usuario'];
} else {
    $response['usuario'] = null;
}

echo json_encode($response);
?>
