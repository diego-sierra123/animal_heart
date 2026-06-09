<?php
session_start();
include("../database/conexion.php");

if (!isset($_SESSION["id"])) {
    exit();
}

$idsocio = $_SESSION['id'];
$search = isset($_POST['search']) ? mysqli_real_escape_string($conexion, $_POST['search']) : '';

$query = "SELECT c.id_cita, c.fecha, c.hora 
          FROM cita c
          WHERE c.id_cliente = $idsocio 
          AND c.fecha LIKE '%$search%'
          ORDER BY c.fecha ASC";

$resultado = mysqli_query($conexion, $query);

$html = '';
$cont = 0;

if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $cont++;
        $hora_formateada = date("h:i A", strtotime($fila['hora']));

        $html .= '<tr>';
        $html .= '<td class="align-middle"><b>'.$cont.'</b></td>';
        $html .= '<td class="align-middle">'.$fila['fecha'].'</td>';
        $html .= '<td class="align-middle">'.$hora_formateada.'</td>';
        $html .= '</tr>';
    }

} else {
    $html .= '<tr>
                <td colspan="3" class="text-center">
                    No se encontraron citas para la fecha: "' . htmlspecialchars($search) . '"
                </td>
              </tr>';
}

echo $html;
?>