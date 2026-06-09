<?php
include("../database/conexion.php"); 

if (isset($_POST['tipo_mascota'])) {
    $departamentoId = $_POST['tipo_mascota'];

    $consulta = "SELECT * FROM raza WHERE id_tipo_mascota = '$departamentoId'";
    $ejecutar = mysqli_query($conexion, $consulta);

    $ciudades = array();

    while ($res = mysqli_fetch_assoc($ejecutar)) {
        $ciudades[] = array(
            'id_raza' => $res['id_raza'],
            'nombre' => $res['nombre']
        );
    }

    echo json_encode($ciudades);
}
?>