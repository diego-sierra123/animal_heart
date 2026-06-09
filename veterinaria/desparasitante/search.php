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

$query = "SELECT id_desparasitante, nombre
          FROM desparasitante
          WHERE nombre LIKE '%$search%' 
          ORDER BY id_desparasitante ASC";

$ejecutar = mysqli_query($conexion, $query);

$cont = 0;
$html = '';

/* Encabezado de la tabla */
$html .= '<tr>
            <th>ID_DESPARASITANTE</th>
            <th>NOMBRE</th>
            <th>ACTUALIZAR</th>
            <th>ELIMINAR</th>
          </tr>';

if (mysqli_num_rows($ejecutar) > 0) {

    while ($fila = mysqli_fetch_assoc($ejecutar)) {

        $cont++;
        $idpac = $fila['id_desparasitante'];
        $nombre = $fila['nombre'];

        $html .= '<tr style="border: 1px solid black;">';

        $html .= '<td><b>'.$cont.'</b></td>';
        $html .= '<td>'.$nombre.'</td>';

        $html .= '<td>';
        
        if ($idpac > 5) {
            $html .= '<a href="update.php?actualizar='.$idpac.'" class="btn btn-primary">
                    <i class="fas fa-sync" style="margin-right: 8px;"></i>Actualizar
                    </a>';
        } else {
            $html .= '<p class="text-primary"><b>No se puede actualizar</b></p>';
        }

        $html .= '</td>';
                    

        $html .= '<td>';

        if ($idpac > 5) {
            $html .= '<a class="btn btn-danger" href="select.php?eliminar='.$idpac.'">
                        <i class="fas fa-trash" style="margin-right: 8px;"></i> Eliminar
                      </a>';
        } else {
            $html .= '<p class="text-danger"><b>No se puede eliminar</b></p>';
        }

        $html .= '</td>';
        $html .= '</tr>';
    }

} else {

    $html .= '<tr>
                <td colspan="6" class="text-center">
                No se encontraron desparasitantes
                </td>
              </tr>';
}

echo $html;
?>
