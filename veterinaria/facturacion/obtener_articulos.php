<?php
include("../database/conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tipoSeleccionado = $_POST['tipo'];

    
    $consulta = "SELECT id_articulo, nombre FROM articulo WHERE id_tipo_articulo = '$tipoSeleccionado'";
    $ejecutar = mysqli_query($conexion, $consulta);

    $articulos = array();

    while ($res = mysqli_fetch_assoc($ejecutar)) {
        $articulos[] = $res;
    }

    
    echo json_encode($articulos);
}
?>
