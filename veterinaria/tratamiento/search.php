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

$query = "SELECT t.id_tratamiento, t.fecha, m.nombre AS mascota, t.observaciones, t.medicamentos 
          FROM tratamiento t
          INNER JOIN mascota m ON t.id_mascota = m.id_mascota
          WHERE t.id_tratamiento != 1
            AND (m.nombre LIKE '%$search%' 
                 OR t.fecha LIKE '%$search%'
                 OR t.medicamentos LIKE '%$search%'
                 OR t.observaciones LIKE '%$search%')
          ORDER BY t.id_tratamiento DESC";

$ejecutar = mysqli_query($conexion, $query);

$cont = 0;
$html = '';

if (mysqli_num_rows($ejecutar) > 0) {
    while ($fila = mysqli_fetch_assoc($ejecutar)) {
        $cont++;
        $idtrat = $fila['id_tratamiento'];
        $mascota = $fila['mascota'];
        $fecha = $fila['fecha'];
        $medicamentos = $fila['medicamentos'];
        $observaciones = $fila['observaciones'];

        $html .= '<tr style="border: 1px solid black;">';

        $html .= '<td><b>'.$cont.'</b></td>';
        $html .= '<td>'.$mascota.'</td>';
        $html .= '<td>'.$fecha.'</td>';
        $html .= '<td>'.$medicamentos.'</td>';
        $html .= '<td>'.$observaciones.'</td>';

        /* Columna ACTUALIZAR */
        $html .= '<td>';
        $html .= '<a href="update.php?actualizar='.$idtrat.'" class="btn btn-primary btn-sm">';
        $html .= '<i class="fas fa-sync"></i>';
        $html .= '</a>';
        $html .= '</td>';

        /* Columna ELIMINAR */
        $html .= '<td>';
        $html .= '<a class="btn btn-danger btn-sm" href="select.php?eliminar='.$idtrat.'">';
        $html .= '<i class="fas fa-trash"></i>';
        $html .= '</a>';
        $html .= '</td>';

        $html .= '</tr>';
    }
} else {
    $html .= '<tr>
                <td colspan="7" class="text-center">
                No se encontraron tratamientos
                </td>
              </tr>';
}

echo $html;
?>