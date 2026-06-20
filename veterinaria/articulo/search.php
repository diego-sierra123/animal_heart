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

$query = "SELECT P.id_articulo, P.nombre, P.descripcion, P.mascota, P.marca, P.tamano_mascota, P.etapa_vida, P.valor, P.costo_conseguido, P.stock, P.fecha_vencimiento, P.foto, PR.nombre AS proveedor, T.nombre AS tipo 
          FROM articulo P, proveedor PR, tipo_articulo T 
          WHERE P.id_proveedor = PR.id_proveedor 
          AND P.id_tipo_articulo = T.id_tipo_articulo 
          AND P.nombre LIKE '%$search%' 
          ORDER BY P.id_articulo ASC";

$ejecutar = mysqli_query($conexion, $query);

$cont = 0;
$html = '';

if (mysqli_num_rows($ejecutar) > 0) {

    while ($fila = mysqli_fetch_assoc($ejecutar)) {

        $cont++;
        $idpac = $fila['id_articulo'];
        $nombre = substr($fila['nombre'], 0, 15) . (strlen($fila['nombre']) > 15 ? '...' : '');
        $des = substr($fila['descripcion'], 0, 15) . (strlen($fila['descripcion']) > 15 ? '...' : '');
        $mar = substr($fila['marca'], 0, 8) . (strlen($fila['marca']) > 8 ? '...' : '');
        $tip = $fila['mascota'];
        $tam = $fila['tamano_mascota'];
        $eta = $fila['etapa_vida'];
        $valor = "$" . number_format($fila['valor'], 0, ',', '.');
        $costo = "$" . number_format($fila['costo_conseguido'], 0, ',', '.');
        $stock = ($idpac >= 190 && $idpac <= 192) || ($idpac >= 210 && $idpac <= 221) ? "No stock" : $fila['stock'];
        $fecha = !empty($fila['fecha_vencimiento']) ? date('d/m/y', strtotime($fila['fecha_vencimiento'])) : '';
        $foto = $fila['foto'];
        $prove = substr($fila['proveedor'], 0, 10) . (strlen($fila['proveedor']) > 10 ? '...' : '');
        $tipo = substr($fila['tipo'], 0, 8) . (strlen($fila['tipo']) > 8 ? '...' : '');

        $html .= '<tr style="border: 1px solid black;">';

        $html .= '<td class="align-middle"><b>'.$cont.'</b></td>';
        $html .= '<td class="align-middle" title="'.$fila['nombre'].'">'.$nombre.'</td>';
        $html .= '<td class="align-middle" title="'.$fila['descripcion'].'">'.$des.'</td>';
        $html .= '<td class="align-middle" title="'.$fila['marca'].'">'.$mar.'</td>';
        $html .= '<td class="align-middle">'.$tip.'</td>';
        $html .= '<td class="align-middle">'.$tam.'</td>';
        $html .= '<td class="align-middle">'.$eta.'</td>';
        $html .= '<td class="align-middle">'.$valor.'</td>';
        $html .= '<td class="align-middle">'.$costo.'</td>';
        $html .= '<td class="align-middle">'.$stock.'</td>';
        $html .= '<td class="align-middle">'.(($fecha == '01/01/70' || $fecha == '31/12/69' || $fecha == '') ? '00/00/00' : $fecha).'</td>';
        $html .= '<td class="align-middle">
                    <img width="40px" height="40px" src="'.$foto.'" class="img-fluid rounded" style="object-fit: cover;">
                  </td>';
        $html .= '<td class="align-middle" title="'.$fila['proveedor'].'">'.$prove.'</td>';
        $html .= '<td class="align-middle" title="'.$fila['tipo'].'">'.$tipo.'</td>';

        $html .= '<td class="align-middle">
                    <a href="update.php?actualizar='.$idpac.'" class="btn btn-primary btn-sm py-0 px-1" style="font-size: 0.7rem;">
                        <i class="fas fa-sync"></i>
                    </a>
                  </td>';

        $html .= '<td class="align-middle">';

        if ($idpac >= 222) {
            $html .= '<a class="btn btn-danger btn-sm py-0 px-1" href="select.php?eliminar='.$idpac.'" style="font-size: 0.7rem;">
                        <i class="fas fa-trash"></i>
                      </a>';
        } else {
            $html .= '<span class="text-danger" style="font-size: 0.7rem;">✗</span>';
        }

        $html .= '</td>';
        $html .= '</tr>';
    }

} else {

    $html .= '<tr>
                <td colspan="16" class="text-center align-middle">
                    No se encontraron artículos
                </td>
              </tr>';
}

echo $html;
?>