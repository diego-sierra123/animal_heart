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

$query = "SELECT c.id_cliente, c.nombres, c.apellidos, c.telefono, c.ciudad, c.barrio, 
                 c.direccion, c.t_documento, c.n_documento, c.correo, r.nombre AS rol 
          FROM cliente c, rol r  
          WHERE c.id_rol = r.id_rol   
          AND (c.nombres LIKE '%$search%' OR c.apellidos LIKE '%$search%' OR c.n_documento LIKE '%$search%') 
          ORDER BY c.id_cliente ASC";

$ejecutar = mysqli_query($conexion, $query);

$cont = 0;
$html = '';

if (mysqli_num_rows($ejecutar) > 0) {

    while ($fila = mysqli_fetch_assoc($ejecutar)) {

        $cont++;
        $idpac = $fila['id_cliente'];
        
        // Truncar textos largos como en artículos
        $nombre = substr($fila['nombres'], 0, 15) . (strlen($fila['nombres']) > 15 ? '...' : '');
        $ape = substr($fila['apellidos'], 0, 15) . (strlen($fila['apellidos']) > 15 ? '...' : '');
        $tel = $fila['telefono'];
        $ciu = substr($fila['ciudad'], 0, 10) . (strlen($fila['ciudad']) > 10 ? '...' : '');
        $bar = substr($fila['barrio'], 0, 10) . (strlen($fila['barrio']) > 10 ? '...' : '');
        $dir = substr($fila['direccion'], 0, 15) . (strlen($fila['direccion']) > 15 ? '...' : '');
        $tdoc = $fila['t_documento'];
        $ndoc = substr($fila['n_documento'], 0, 12) . (strlen($fila['n_documento']) > 12 ? '...' : '');
        $cor = substr($fila['correo'], 0, 15) . (strlen($fila['correo']) > 15 ? '...' : '');

        $html .= '<tr style="border: 1px solid black;">';

        $html .= '<td class="align-middle"><b>'.$cont.'</b></td>';
        $html .= '<td class="align-middle" title="'.$fila['nombres'].'">'.$nombre.'</td>';
        $html .= '<td class="align-middle" title="'.$fila['apellidos'].'">'.$ape.'</td>';
        $html .= '<td class="align-middle">'.$tel.'</td>';
        $html .= '<td class="align-middle" title="'.$fila['ciudad'].'">'.$ciu.'</td>';
        $html .= '<td class="align-middle" title="'.$fila['barrio'].'">'.$bar.'</td>';
        $html .= '<td class="align-middle" title="'.$fila['direccion'].'">'.$dir.'</td>';
        $html .= '<td class="align-middle">'.$tdoc.'</td>';
        $html .= '<td class="align-middle" title="'.$fila['n_documento'].'">'.$ndoc.'</td>';
        $html .= '<td class="align-middle" title="'.$fila['correo'].'">'.$cor.'</td>';

        $html .= '<td class="align-middle">
                    <a class="btn btn-secondary btn-sm py-0 px-1" href="../facturacion/factura.php?facturar='.$idpac.'" style="font-size: 0.7rem;">
                        <i class="fas fa-file-invoice"></i>
                    </a>
                  </td>';

        $html .= '<td class="align-middle">
                    <a href="update.php?actualizar='.$idpac.'" class="btn btn-primary btn-sm py-0 px-1" style="font-size: 0.7rem;">
                        <i class="fas fa-sync"></i>
                    </a>
                  </td>';
                    
        $html .= '<td class="align-middle">';
        
        // Verificar si el cliente tiene facturas o mascotas asociadas
        $consulta_relacionada = "SELECT id_factura FROM factura WHERE id_cliente='$idpac' 
                                  UNION 
                                  SELECT id_mascota FROM mascota WHERE id_cliente='$idpac'";
        $ejecutar_relacionada = mysqli_query($conexion, $consulta_relacionada);
        
        if (mysqli_num_rows($ejecutar_relacionada) > 0) {
            $html .= '<span class="text-danger" style="font-size: 0.7rem;">✗</span>';
        } else {
            $html .= '<a class="btn btn-danger btn-sm py-0 px-1" href="select.php?eliminar='.$idpac.'" style="font-size: 0.7rem;">
                        <i class="fas fa-trash"></i>
                      </a>';
        }

        $html .= '</td>';
        $html .= '</tr>';
    }

} else {

    $html .= '<tr>
                <td colspan="13" class="text-center align-middle">
                    No se encontraron clientes
                </td>
              </tr>';
}

echo $html;
?>