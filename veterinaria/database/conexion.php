<?php

$hostname = "mysql";
$username = "root";
$password = "root";
$database = "veterinaria";

$conexion = mysqli_connect($hostname, $username, $password, $database);

if (!$conexion) {
    echo "Error en la conexión: " . mysqli_connect_error();
    exit();
}

mysqli_set_charset($conexion, "utf8");

?>