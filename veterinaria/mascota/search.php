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

$query = "SELECT m.id_mascota, m.nombre, m.sexo, 
                 t.nombre AS tipo_mascota, 
                 r.nombre AS raza, 
                 m.fecha_nacimiento, 
                 c.id_cliente, c.nombres AS cliente, 
                 m.fecha_registro, m.observaciones 
          FROM mascota m
          INNER JOIN tipo_mascota t ON m.id_tipo_mascota = t.id_tipo_mascota
          INNER JOIN raza r ON m.id_raza = r.id_raza
          INNER JOIN cliente c ON m.id_cliente = c.id_cliente
          WHERE m.nombre LIKE '%$search%' 
             OR c.nombres LIKE '%$search%'
             OR t.nombre LIKE '%$search%'
             OR r.nombre LIKE '%$search%'
          ORDER BY m.id_mascota ASC";

$ejecutar = mysqli_query($conexion, $query);

$cont = 0;
$html = '';

if (mysqli_num_rows($ejecutar) > 0) {
    while ($fila = mysqli_fetch_assoc($ejecutar)) {
        $cont++;
        $idmasc = $fila['id_mascota'];
        $nombre = $fila['nombre'];
        $sexo = $fila['sexo'];
        $tipo_mascota = $fila['tipo_mascota'];
        $raza = $fila['raza'];
        $fecha_nac = $fila['fecha_nacimiento'];
        $cliente = $fila['cliente'];
        $id_cliente = $fila['id_cliente'];
        $fecha_reg = $fila['fecha_registro'];
        $observaciones = $fila['observaciones'];

        $html .= '<tr style="border:1px solid black;">';
        
        $html .= '<td><b>' . $cont . '</b></td>';
        $html .= '<td>' . $nombre . '</td>';
        $html .= '<td>' . $sexo . '</td>';
        $html .= '<td>' . $tipo_mascota . '</td>';
        $html .= '<td>' . $raza . '</td>';
        $html .= '<td>' . $fecha_nac . '</td>';
        $html .= '<td>' . $cliente . '</td>';
        $html .= '<td>' . $fecha_reg . '</td>';
        $html .= '<td>' . $observaciones . '</td>';
        
        // Tratamientos
        $html .= '<td>';
        $html .= '<a href="../tratamiento/selectpropio.php?id=' . $idmasc . '" class="btn btn-info btn-sm">';
        $html .= '<i class="fas fa-stethoscope"></i>';
        $html .= '</a>';
        $html .= '</td>';
        
        // Historial
        $html .= '<td>';
        $html .= '<a href="../historial_clinico/select.php?id=' . $idmasc . '&clienteee=' . $id_cliente . '" class="btn btn-warning btn-sm">';
        $html .= '<i class="fas fa-file-medical"></i>';
        $html .= '</a>';
        $html .= '</td>';
        
        // Actualizar
        $html .= '<td>';
        $html .= '<a href="update.php?actualizar=' . $idmasc . '" class="btn btn-primary btn-sm">';
        $html .= '<i class="fas fa-sync"></i>';
        $html .= '</a>';
        $html .= '</td>';
        
        // Eliminar
        $html .= '<td>';
        $html .= '<a class="btn btn-danger btn-sm" href="select.php?eliminar=' . $idmasc . '">';
        $html .= '<i class="fas fa-trash"></i>';
        $html .= '</a>';
        $html .= '</td>';
        
        $html .= '</tr>';
    }
} else {
    $html .= '<tr>
                <td colspan="15" class="text-center">
                No se encontraron mascotas
                </td>
              </tr>';
}

echo $html;
?>