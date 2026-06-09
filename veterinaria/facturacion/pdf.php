<?php
use Dompdf\FrameDecarator\Image;

ob_start();
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', 0);

include('plantillapdf.php');
include_once('../database/conexion.php');
require_once('../fpdf/fpdf.php');

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

if (isset($_GET['anular'])) {
    $anul = $_GET['anular'];
    if ($anul == 2) {
        $pdf->Image('../img/anulado.png', 26, 80, 160);
    }
}

$pdf->SetFont('Arial', 'B', 10);

if (isset($_GET['cliente'])) {
    $IDPAC = $_GET['cliente'];
    $facturar = $_GET['facturar'];

    $sub_sql_1 = "SELECT * FROM cliente WHERE id_cliente = '$IDPAC'";
    $executee = mysqli_query($conexion, $sub_sql_1);
    $restabla = mysqli_fetch_array($executee);

    $sub_sql_2 = "SELECT c.*, f.id_factura, f.fecha, es.nombre AS estado 
    FROM cliente c, factura f, estado_factura es 
    WHERE f.id_cliente = c.id_cliente 
    AND f.id_estado_factura = es.id_estado_factura 
    AND c.id_cliente = '$IDPAC' 
    AND f.id_factura = '$facturar'";
    
    $execute = mysqli_query($conexion, $sub_sql_2);
    $pais = mysqli_fetch_array($execute);

    $pdf->Cell(185, 5, utf8_decode('DATOS DEL CLIENTE'), 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->Cell(95, 5, utf8_decode('FECHA: ') . $pais['fecha'], 0, 0, 'L');
    $pdf->Ln(10);

    $pdf->Cell(95, 5, utf8_decode('IDENTIFICACION: ') . $restabla['n_documento'], 0, 0, 'L');
    $pdf->Ln(10);

    $pdf->Cell(95, 5, utf8_decode('NOMBRE: ' . $restabla['nombres'] . ' ' . $restabla['apellidos']), 0, 0, 'L');
    $pdf->Ln(10);

    $pdf->Cell(95, 5, utf8_decode('TELEFONO: ' . $restabla['telefono']), 0, 0, 'L');
    $pdf->Ln(10);

    $pdf->Cell(95, 5, utf8_decode('DIRECCION: ' . $restabla['direccion']), 0, 0, 'L');
    $pdf->Ln(10);

    $pdf->Cell(95, 5, utf8_decode('ESTADO: '), 0, 0, 'L');
    $pdf->SetX(28); 
    $pdf->Cell(16, 5, utf8_decode($pais['estado']), 1, 0, 'L'); 
    $pdf->Ln(10);
}

if (isset($_GET['facturar'])) {
    $id = $_GET['facturar'];

    $pdf->Cell(185, 5, utf8_decode('DETALLE FACTURA'), 0, 1, 'C');
    $pdf->Ln(9);

    $pdf->Cell(110, 10, utf8_decode('ARTICULOS O SERVICIOS'), 1, 0, 'C');
    $pdf->Cell(22, 10, utf8_decode('CANTIDAD'), 1, 0, 'C');
    $pdf->Cell(33, 10, utf8_decode('PRECIO UNITARIO'), 1, 0, 'C');
    $pdf->Cell(26, 10, utf8_decode('SUBTOTAL'), 1, 1, 'C');

    $consul = "SELECT pv.nombre, df.* 
    FROM detalle_factura AS df 
    INNER JOIN articulo AS pv ON pv.id_articulo = df.id_articulo 
    WHERE id_factura='$id'";
    
    $execute = mysqli_query($conexion, $consul);

    while ($ejecutando = mysqli_fetch_array($execute)) {
        $subtotal = $ejecutando['cantidad'] * $ejecutando['valor'];

        $pdf->Cell(110, 10, utf8_decode($ejecutando['nombre']), 1, 0, 'C');
        $pdf->Cell(22, 10, $ejecutando['cantidad'], 1, 0, 'C');
        $pdf->Cell(33, 10, '$' . $ejecutando['valor'], 1, 0, 'C');
        $pdf->Cell(26, 10, '$' . $subtotal, 1, 1, 'C');
    }

    $consultotal = "SELECT f.total_factura FROM factura AS f WHERE id_factura='$id'";
    $ejecutarconsultotal = mysqli_query($conexion, $consultotal);

    while ($total = mysqli_fetch_array($ejecutarconsultotal)) {
        $pdf->Cell(132, 6, ' ', 0, 0, 'R');
        $pdf->Cell(33, 6, utf8_decode('PRECIO TOTAL'), 1, 0, 'C');
        $pdf->Cell(26, 6, '$' . $total['total_factura'], 1, 0, 'C');
        $pdf->Ln(10);
    }
}

$pdf->Output();