<?php
include("../database/conexion.php");

$consultafac = "SELECT MAX(id_factura) AS 'id_factura' FROM factura";
$ejecutarconsultafac = mysqli_query($conexion, $consultafac) or die(mysqli_error($conexion));
$maxfactura = mysqli_fetch_assoc($ejecutarconsultafac);
$consulta1 = $maxfactura['id_factura'];


$articulosProtegidos = array(190, 191, 192, 210, 211, 212, 213, 214, 215, 216, 217, 218, 219, 220, 221); 


$consultaDetalles = "SELECT id_articulo, cantidad FROM detalle_factura_temp WHERE id_factura = $consulta1";
$resultadoDetalles = mysqli_query($conexion, $consultaDetalles);

while ($detalle = mysqli_fetch_assoc($resultadoDetalles)) {
    $idArticulo = $detalle['id_articulo'];
    $cantidad = $detalle['cantidad'];


    if (!in_array($idArticulo, $articulosProtegidos)) {
        // Obtén el stock actual del artículo
        $consultaStock = "SELECT stock FROM articulo WHERE id_articulo = $idArticulo";
        $resultadoStock = mysqli_query($conexion, $consultaStock);
        $stockActual = mysqli_fetch_assoc($resultadoStock)['stock'];

        // Restaurar el stock restando la cantidad de la factura
        $nuevoStock = $stockActual + $cantidad;

        // Actualizar el stock en la base de datos
        $actualizarStock = "UPDATE articulo SET stock = $nuevoStock WHERE id_articulo = $idArticulo";
        mysqli_query($conexion, $actualizarStock);
    }
}

// Elimina la factura y los detalles de la factura
$eliminarFactura = "DELETE FROM factura WHERE id_factura = $consulta1";
$eliminarDetalles = "DELETE FROM detalle_factura_temp WHERE id_factura = $consulta1";

mysqli_query($conexion, $eliminarDetalles);
mysqli_query($conexion, $eliminarFactura);

// Redirige a la página principal o a donde desees después de cancelar la factura
header("Location: ../cliente/select.php");
exit(); // Detiene la ejecución del script
?>
