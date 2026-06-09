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

$query = "SELECT e.id_empleado, e.nombre, e.telefono, e.ciudad, e.barrio, e.direccion, 
                 e.t_documento, e.n_documento, e.correo, r.nombre AS rol
          FROM empleado e
          INNER JOIN rol r ON e.id_rol = r.id_rol
          WHERE e.nombre LIKE '%$search%' 
             OR e.n_documento LIKE '%$search%' 
             OR e.correo LIKE '%$search%'
          ORDER BY e.id_empleado ASC";

$ejecutar = mysqli_query($conexion, $query);

$cont = 0;
$html = '';

// ELIMINÉ EL ENCABEZADO - AHORA SOLO DEVUELVE LAS FILAS

if (mysqli_num_rows($ejecutar) > 0) {

    while ($fila = mysqli_fetch_assoc($ejecutar)) {

        $cont++;
        $idemp = $fila['id_empleado'];
        $nombre = $fila['nombre'];
        $telefono = $fila['telefono'];
        $ciudad = $fila['ciudad'];
        $barrio = $fila['barrio'];
        $direccion = $fila['direccion'];
        $tdoc = $fila['t_documento'];
        $ndoc = $fila['n_documento'];
        $correo = $fila['correo'];
        $rol = $fila['rol'];

        $html .= '<tr style="border: 1px solid black;">';

        $html .= '<td><b>'.$cont.'</b></td>';
        $html .= '<td>'.$nombre.'</td>';
        $html .= '<td>'.$telefono.'</td>';
        $html .= '<td>'.$ciudad.'</td>';
        $html .= '<td>'.$barrio.'</td>';
        $html .= '<td>'.$direccion.'</td>';
        $html .= '<td>'.$tdoc.'</td>';
        $html .= '<td>'.$ndoc.'</td>';
        $html .= '<td>'.$correo.'</td>';
        $html .= '<td>'.$rol.'</td>';

        /* Columna ACTUALIZAR */
        $html .= '<td>';
        $html .= '<a href="update.php?actualizar='.$idemp.'" class="btn btn-primary btn-sm">';
        $html .= '<i class="fas fa-sync"></i>';
        $html .= '</a>';
        $html .= '</td>';

        /* Columna ELIMINAR */
        $html .= '<td>';
        if ($idemp > 1) {
            $html .= '<a class="btn btn-danger btn-sm" href="select.php?eliminar='.$idemp.'">';
            $html .= '<i class="fas fa-trash"></i>';
            $html .= '</a>';
        } else {
            $html .= '<span class="text-danger">✗</span>';
        }
        $html .= '</td>';

        $html .= '</tr>';
    }

} else {
    // Mensaje cuando no hay resultados (ocupa las 12 columnas)
    $html .= '<tr>
                <td colspan="12" class="text-center">
                No se encontraron empleados
                </td>
              </tr>';
}

echo $html;
?>