<?php
include("../database/conexion.php");

$id_cliente = intval($_POST['cliente']);

$query = "SELECT id_mascota, nombre FROM mascota WHERE id_cliente = '$id_cliente'";
$result = mysqli_query($conexion, $query);

$mascotas = array();
while ($row = mysqli_fetch_assoc($result)) {
    $mascotas[] = $row;
}

echo json_encode($mascotas);
?>