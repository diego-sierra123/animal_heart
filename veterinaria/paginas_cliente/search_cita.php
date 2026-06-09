<?php
session_start();
include("../database/conexion.php");

if (!isset($_SESSION["id"])) {
    exit();
}

$idsocio = $_SESSION['id'];
$search = isset($_POST['search']) ? mysqli_real_escape_string($conexion, $_POST['search']) : '';

$query = "SELECT ci.id_cita, ci.fecha, ci.hora, CONCAT(c.nombres,' ',c.apellidos) AS nombrecliente, 
                 m.nombre AS mascotica, es.nombre AS estado, s.nombre AS servicio, 
                 ci.descripcion, ci.id_estado_cita
          FROM cita ci
          INNER JOIN cliente c ON ci.id_cliente = c.id_cliente
          INNER JOIN mascota m ON ci.id_mascota = m.id_mascota
          INNER JOIN estado_cita es ON ci.id_estado_cita = es.id_estado_cita
          INNER JOIN nom_servicio s ON ci.id_nom_servicio = s.id_nom_servicio
          WHERE ci.id_cliente = $idsocio
          AND ci.fecha LIKE '%$search%'
          ORDER BY ci.id_cita DESC";

$resultado = mysqli_query($conexion, $query);

$html = '';
$cont = 0;

if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $cont++;
        $hora_formateada = date("h:i A", strtotime($fila['hora']));
        $des = substr($fila['descripcion'], 0, 30) . (strlen($fila['descripcion']) > 30 ? '...' : '');
        $idest = $fila['id_estado_cita'];

        $html .= '<tr>';
        $html .= '<td class="align-middle"><b>'.$cont.'</b></td>';
        $html .= '<td class="align-middle">'.$fila['fecha'].'</td>';
        $html .= '<td class="align-middle">'.$hora_formateada.'</td>';
        $html .= '<td class="align-middle">'.htmlspecialchars($fila['nombrecliente']).'</td>';
        $html .= '<td class="align-middle">'.htmlspecialchars($fila['mascotica']).'</td>';
        $html .= '<td class="align-middle">';
        if ($idest == 1) {
            $html .= '<span class="badge bg-warning text-dark">'.$fila['estado'].'</span>';
        } elseif ($idest == 2) {
            $html .= '<span class="badge bg-success">'.$fila['estado'].'</span>';
        } else {
            $html .= '<span class="badge bg-danger">'.$fila['estado'].'</span>';
        }
        $html .= '</td>';
        $html .= '<td class="align-middle">'.htmlspecialchars($fila['servicio']).'</td>';
        $html .= '<td class="align-middle" title="'.htmlspecialchars($fila['descripcion']).'">'.htmlspecialchars($des).'</td>';
        $html .= '<td class="align-middle">';
        if ($idest == 1) {
            $html .= '<a href="updatehistorialcita.php?actualizar='.$fila['id_cita'].'" class="btn btn-primary btn-sm py-0 px-1" style="font-size: 0.7rem;">
                        <i class="fas fa-sync"></i>
                      </a>';
        } else {
            $html .= '<span class="text-muted">---</span>';
        }
        $html .= '</td>';
        $html .= '<td class="align-middle">';
        if ($idest == 1) {
            $html .= '<button type="button" class="btn btn-danger btn-sm py-0 px-1" style="font-size: 0.7rem;" onclick="confirmarCancelacion('.$fila['id_cita'].')">
                        <i class="fas fa-trash"></i>
                      </button>';
        } else {
            $html .= '<span class="text-muted">---</span>';
        }
        $html .= '</td>';
        $html .= '</tr>';
    }

} else {
    $html .= '<tr>
                <td colspan="10" class="text-center">
                    No se encontraron citas para la fecha: "' . htmlspecialchars($search) . '"
                  </td>
                </tr>';
}

echo $html;
?>