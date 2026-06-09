<?php
include("../database/conexion.php");

// Obtén todos los elementos de detalle_factura_temp
$consultaDetalle = "SELECT id_detalle_factura_temp, id_articulo, cantidad FROM detalle_factura_temp";
$resultadoDetalle = mysqli_query($conexion, $consultaDetalle);

while ($detalle = mysqli_fetch_assoc($resultadoDetalle)) {
    $idDetalleFactura = $detalle['id_detalle_factura_temp'];
    $idArticulo = $detalle['id_articulo'];
    $cantidad = $detalle['cantidad'];

    // Verificar si el artículo debe ser eliminado o restaurado
    $articulosExcluidos = [190, 191, 192, 210, 211, 212, 213, 214, 215, 216, 217, 218, 219, 220, 221];
    if (in_array($idArticulo, $articulosExcluidos)) {
        // Si el artículo está en la lista de excluidos, simplemente elimina el elemento
        $eliminarDetalle = "DELETE FROM detalle_factura_temp WHERE id_detalle_factura_temp = $idDetalleFactura";
        mysqli_query($conexion, $eliminarDetalle);
    } else {
        // Si el artículo no está en la lista de excluidos, restaura el stock
        // Obtén el stock actual del artículo
        $consultaStock = "SELECT stock FROM articulo WHERE id_articulo = $idArticulo";
        $resultadoStock = mysqli_query($conexion, $consultaStock);
        $stockActual = mysqli_fetch_assoc($resultadoStock)['stock'];

        // Restaura el stock sumando la cantidad del detalle de la factura
        $nuevoStock = $stockActual + $cantidad;

        // Actualiza el stock en la base de datos
        $actualizarStock = "UPDATE articulo SET stock = $nuevoStock WHERE id_articulo = $idArticulo";
        mysqli_query($conexion, $actualizarStock);

        // Elimina el elemento de detalle_factura_temp
        $eliminarDetalle = "DELETE FROM detalle_factura_temp WHERE id_detalle_factura_temp = $idDetalleFactura";
        mysqli_query($conexion, $eliminarDetalle);
    }
}
?>
