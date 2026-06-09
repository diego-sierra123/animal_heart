<?php

ob_start();
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', 0);

include('plantillapdf.php');
include_once('../database/conexion.php');
require_once('../fpdf/fpdf.php');

mysqli_set_charset($conexion, "utf8");

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$hora_actual = date('Y-m-d H:i:s');
$horas_a_retrasar = 7;
$nueva_fecha = date('Y-m-d', strtotime($hora_actual . ' - ' . $horas_a_retrasar . ' hours'));

$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(185, 5, utf8_decode('CANTIDAD DE ARTÍCULOS SEGÚN EL TIPO Y STOCK'), 0, 1, 'C');

$pdf->Ln(15);

$pdf->Cell(95, 5, utf8_decode('Fecha de hoy: ') . $nueva_fecha, 0, 0, 'L');

$pdf->Ln(15);

$pdf->Cell(63, 10, utf8_decode('TIPO DE ARTÍCULO'), 1, 0, 'C');
$pdf->Cell(53, 10, utf8_decode('CANTIDAD ARTÍCULOS'), 1, 0, 'C');
$pdf->Cell(73, 10, utf8_decode('VALOR TOTAL STOCK'), 1, 1, 'C');

$consul = mysqli_query($conexion, "
SELECT t.nombre AS tipoarticulo,
COUNT(*) AS cantidad_de_articulos,
SUM(a.valor * a.stock) AS valor_total
FROM articulo a, tipo_articulo t
WHERE a.id_articulo NOT IN (190,191,192,210,211,212,213,214,215,216,217,218,219,220,221)
AND a.id_tipo_articulo = t.id_tipo_articulo
GROUP BY a.id_tipo_articulo
");

while ($ejecutando = mysqli_fetch_array($consul)) {

    $pdf->Cell(63, 10, utf8_decode($ejecutando['tipoarticulo']), 1, 0, 'C');
    $pdf->Cell(53, 10, $ejecutando['cantidad_de_articulos'], 1, 0, 'C');
    $pdf->Cell(73, 10, "$" . number_format($ejecutando['valor_total'], 0, ',', '.'), 1, 1, 'C');
}

$pdf->Output();