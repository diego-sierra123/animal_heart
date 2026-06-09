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

$query = "SELECT id_rol, nombre
          FROM rol
          WHERE nombre LIKE '%$search%' 
          ORDER BY id_rol ASC";

$ejecutar = mysqli_query($conexion, $query);

$cont = 0;
$html = '';

/* Encabezado de la tabla */
$html .= '<tr>
            <th>ID_ROL</th>
            <th>NOMBRE</th>
            <th>ACTUALIZAR</th>
            <th>ELIMINAR</th>
          </tr>';

if (mysqli_num_rows($ejecutar) > 0) {

    while ($fila = mysqli_fetch_assoc($ejecutar)) {

        $cont++;
        $idpac = $fila['id_rol'];
        $nombre = $fila['nombre'];

        $html .= '<tr style="border: 1px solid black;">';

        $html .= '<td><b>'.$cont.'</b></td>';
        $html .= '<td>'.$nombre.'</td>';

        $html .= '<td>
                    <p class="text-primary"><b>No se puede actualizar</b></p>
                  </td>';

        $html .= '<td>';

        
            $html .= '<p class="text-danger"><b>No se puede eliminar</b></p>';
        

        $html .= '</td>';
        $html .= '</tr>';
    }

} else {

    $html .= '<tr>
                <td colspan="6" class="text-center">
                No se encontraron roles
                </td>
              </tr>';
}

echo $html;
?>
