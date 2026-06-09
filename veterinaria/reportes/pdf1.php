<?php

ob_start();

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

$pdf->Cell(185, 5, utf8_decode('CANTIDAD DE ARTÍCULOS INCLUYENDO EL STOCK'), 0, 1, 'C');
$pdf->Ln(15);

$pdf->Cell(95, 5, utf8_decode('Fecha de hoy: ') . $nueva_fecha, 0, 0, 'L');
$pdf->Ln(15);

$pdf->Cell(95, 10, utf8_decode('CANTIDAD ARTÍCULOS'), 1, 0, 'C');
$pdf->Cell(95, 10, utf8_decode('VALOR TOTAL INCLUYENDO EL STOCK'), 1, 1, 'C');

$consul = mysqli_query($conexion, "
SELECT COUNT(*) AS cantidad_de_articulos,
SUM(valor * stock) AS valor_total
FROM articulo
WHERE id_articulo NOT IN (190,191,192,210,211,212,213,214,215,216,217,218,219,220,221)
");

while ($ejecutando = mysqli_fetch_array($consul)) {

    $pdf->Cell(95, 10, $ejecutando['cantidad_de_articulos'], 1, 0, 'C');
    $pdf->Cell(95, 10, "$" . number_format($ejecutando['valor_total'], 0, ',', '.'), 1, 1, 'C');
}

$pdf->Output();