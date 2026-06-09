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

$query = "SELECT CP.id_compra_proveedor, CP.fecha, CP.valor_total, CP.foto, PR.nombre AS proveedor 
          FROM compra_proveedor CP, proveedor PR 
          WHERE CP.id_proveedor = PR.id_proveedor 
          AND CP.fecha LIKE '%$search%' 
          ORDER BY CP.id_compra_proveedor ASC";

$ejecutar = mysqli_query($conexion, $query);

$cont = 0;
$html = '';

if (mysqli_num_rows($ejecutar) > 0) {

    while ($fila = mysqli_fetch_assoc($ejecutar)) {

        $cont++;
        $idCompra = $fila['id_compra_proveedor'];
        $fecha = date('d/m/Y', strtotime($fila['fecha']));
        $proveedor = $fila['proveedor'];
        $valor = "$" . number_format($fila['valor_total'], 0, '', ' ');
        $foto = $fila['foto'];

        $html .= '<tr style="border: 1px solid black;">';

        $html .= '<td class="align-middle"><b>'.$cont.'</b></td>';
        $html .= '<td class="align-middle">'.$fecha.'</td>';
        $html .= '<td class="align-middle">'.$proveedor.'</td>';
        $html .= '<td class="align-middle">'.$valor.'</td>';
        
        $html .= '<td class="align-middle">';
        if (!empty($foto) && file_exists($foto)) {
            $html .= '<button type="button" class="btn btn-info btn-sm py-0 px-1" style="font-size: 0.7rem;" data-bs-toggle="modal" data-bs-target="#imageModal" data-image-src="'.$foto.'">
                        <i class="fas fa-eye"></i> Ver
                      </button>';
        } else {
            $html .= '<span class="text-muted" style="font-size: 0.7rem;">Sin archivo</span>';
        }
        $html .= '</td>';

        $html .= '<td class="align-middle">
                    <a href="update.php?actualizar='.$idCompra.'" class="btn btn-primary btn-sm py-0 px-1" style="font-size: 0.7rem;">
                        <i class="fas fa-sync"></i>
                    </a>
                  </td>';

        $html .= '<td class="align-middle">
                    <a class="btn btn-danger btn-sm py-0 px-1" href="select.php?eliminar='.$idCompra.'" style="font-size: 0.7rem;">
                        <i class="fas fa-trash"></i>
                    </a>
                  </td>';

        $html .= '</tr>';
    }

} else {

    $html .= '<tr>
                <td colspan="7" class="text-center align-middle">
                    No se encontraron compras a proveedores
                </td>
              </tr>';
}

echo $html;
?>