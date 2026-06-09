<?php
session_start();
include("../database/conexion.php");

if (!isset($_SESSION["id"])) {
    exit();
}

$idsocio = $_SESSION['id'];
$search = isset($_POST['search']) ? mysqli_real_escape_string($conexion, $_POST['search']) : '';

$query = "SELECT f.*, CONCAT(c.nombres,' ',c.apellidos) AS nombrecliente 
          FROM factura f
          INNER JOIN cliente c ON f.id_cliente = c.id_cliente
          WHERE f.id_cliente = $idsocio
          AND f.fecha LIKE '%$search%'
          ORDER BY f.id_factura DESC";

$resultado = mysqli_query($conexion, $query);

$html = '';
$cont = 0;

if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $cont++;
        $idre = $fila['id_factura'];
        $fh = $fila["fecha"];
        $tl = $fila["total_factura"];
        $idest = $fila["id_estado_factura"];
        $cliente = $fila["nombrecliente"];
        
        if ($idest == 1) {
            $esta = '<span class="badge bg-success">PAGADO</span>';
        } elseif ($idest == 2) {
            $esta = '<span class="badge bg-danger">ANULADO</span>';
        } else {
            $esta = '<span class="badge bg-warning text-dark">NO PAGADO</span>';
        }

        $html .= '<tr>';
        $html .= '<td class="align-middle"><b>'.$cont.'</b></td>';
        $html .= '<td class="align-middle">'.$fh.'</td>';
        $html .= '<td class="align-middle">'.htmlspecialchars($cliente).'</td>';
        $html .= '<td class="align-middle">$'.number_format($tl, 0, ',', '.').'</td>';
        $html .= '<td class="align-middle">'.$esta.'</td>';
        $html .= '<td class="align-middle">
                    <a class="btn btn-danger btn-sm" href="../facturacion/pdf.php?facturar='.$idre.'&cliente='.$idsocio.'&anular='.$idest.'" target="_blank">
                        <i class="fas fa-file-pdf"></i> PDF
                    </a>
                   </td>';
        $html .= '</tr>';
    }

} else {
    $html .= '<tr>
                <td colspan="6" class="text-center">
                    No se encontraron facturas para la fecha: "' . htmlspecialchars($search) . '"
                </td>
              </tr>';
}

echo $html;
?>