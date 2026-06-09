<?php
session_start();
include("../database/conexion.php");

if (!isset($_SESSION["id"])) {
    exit();
}

$idsocio = $_SESSION['id'];
$search = isset($_POST['search']) ? mysqli_real_escape_string($conexion, $_POST['search']) : '';

$query = "SELECT m.id_mascota, m.nombre, m.sexo, t.nombre AS tipo_mascota, r.nombre AS raza, 
                 m.fecha_nacimiento, c.nombres AS cliente, m.observaciones
          FROM mascota m
          INNER JOIN tipo_mascota t ON m.id_tipo_mascota = t.id_tipo_mascota
          INNER JOIN raza r ON m.id_raza = r.id_raza
          INNER JOIN cliente c ON m.id_cliente = c.id_cliente
          WHERE m.id_cliente = $idsocio
          AND m.nombre LIKE '%$search%'
          ORDER BY m.id_mascota ASC";

$resultado = mysqli_query($conexion, $query);

$html = '';
$cont = 0;

if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $cont++;

        $obs = substr($fila['observaciones'], 0, 20) . 
              (strlen($fila['observaciones']) > 20 ? '...' : '');

        $html .= '<tr>';
        $html .= '<td class="align-middle"><b>'.$cont.'</b></td>';
        $html .= '<td class="align-middle">'.htmlspecialchars($fila['nombre']).'</td>';
        $html .= '<td class="align-middle">'.htmlspecialchars($fila['sexo']).'</td>';
        $html .= '<td class="align-middle">'.htmlspecialchars($fila['tipo_mascota']).'</td>';
        $html .= '<td class="align-middle">'.htmlspecialchars($fila['raza']).'</td>';
        $html .= '<td class="align-middle">'.htmlspecialchars($fila['fecha_nacimiento']).'</td>';
        $html .= '<td class="align-middle">'.htmlspecialchars($fila['cliente']).'</td>';
        $html .= '<td class="align-middle" title="'.htmlspecialchars($fila['observaciones']).'">'.htmlspecialchars($obs).'</td>';
        $html .= '<td class="align-middle">
                    <a href="historialesclinicos.php?id='.$fila['id_mascota'].'" class="btn btn-warning btn-sm py-0 px-1" style="font-size: 0.7rem;">
                        <i class="fas fa-file-medical"></i>
                    </a>
                   </td>';
        $html .= '<td class="align-middle">
                    <a href="updatehistorialmascota.php?actualizar='.$fila['id_mascota'].'" class="btn btn-primary btn-sm py-0 px-1" style="font-size: 0.7rem;">
                        <i class="fas fa-sync"></i>
                    </a>
                   </td>';
        $html .= '<td class="align-middle">
                    <button type="button" class="btn btn-danger btn-sm py-0 px-1" style="font-size: 0.7rem;" onclick="confirmarEliminacion('.$fila['id_mascota'].', \''.addslashes($fila['nombre']).'\')">
                        <i class="fas fa-trash"></i>
                    </button>
                   </td>';
        $html .= '</tr>';
    }

} else {
    $html .= '<tr>
                <td colspan="11" class="text-center">
                    No se encontraron mascotas con el nombre: "' . htmlspecialchars($search) . '"
                 </td>
               </tr>';
}

echo $html;
?>