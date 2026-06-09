<?php
session_start();
include("../database/conexion.php");

if (!isset($_SESSION["id"])) {
    exit();
}

if ($_SESSION["id_rol"] != 1 && $_SESSION["id_rol"] != 2) {
    exit();
}

$search = isset($_POST['search']) ? mysqli_real_escape_string($conexion, $_POST['search']) : '';

$query = "SELECT r.id_raza, r.nombre, t.nombre AS tipo_mascota 
          FROM raza r
          INNER JOIN tipo_mascota t ON r.id_tipo_mascota = t.id_tipo_mascota
          WHERE r.nombre LIKE '%$search%' 
             OR t.nombre LIKE '%$search%'
          ORDER BY r.id_raza ASC";

$ejecutar = mysqli_query($conexion, $query);

$cont = 0;
$html = '';

if (mysqli_num_rows($ejecutar) > 0) {
    while ($fila = mysqli_fetch_assoc($ejecutar)) {
        $cont++;
        $idraza = $fila['id_raza'];
        $nombre = $fila['nombre'];
        $tipo_mascota = $fila['tipo_mascota'];

        $html .= '<tr style="border: 1px solid black;">';

        $html .= '<td><b>'.$cont.'</b></td>';
        $html .= '<td>'.$nombre.'</td>';
        $html .= '<td>'.$tipo_mascota.'</td>';

        /* Columna ACTUALIZAR */
        $html .= '<td>';
        if ($idraza > 5) { // IDs 1-5 son datos base que no se pueden modificar
            $html .= '<a href="update.php?actualizar='.$idraza.'" class="btn btn-primary btn-sm">';
            $html .= '<i class="fas fa-sync"></i>';
            $html .= '</a>';
        } else {
            $html .= '<span class="text-primary"><small><b>No se puede actualizar</b></small></span>';
        }
        $html .= '</td>';

        /* Columna ELIMINAR */
        $html .= '<td>';
        if ($idraza > 5) {
            $html .= '<a class="btn btn-danger btn-sm" href="select.php?eliminar='.$idraza.'">';
            $html .= '<i class="fas fa-trash"></i>';
            $html .= '</a>';
        } else {
            $html .= '<span class="text-danger"><small><b>No se puede eliminar</b></small></span>';
        }
        $html .= '</td>';

        $html .= '</tr>';
    }
} else {
    $html .= '<tr>
                <td colspan="5" class="text-center">
                No se encontraron razas
                </td>
              </tr>';
}

echo $html;
?>