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

$pdf->Cell(185, 5, utf8_decode('CANTIDAD DE MASCOTAS SEGÚN EL TIPO'), 0, 1, 'C');

$pdf->Ln(15);

$pdf->Cell(95, 5, utf8_decode('Fecha de hoy: ') . $nueva_fecha, 0, 0, 'L');

$pdf->Ln(15);

$pdf->Cell(95, 10, utf8_decode('TIPO DE MASCOTA'), 1, 0, 'C');
$pdf->Cell(95, 10, utf8_decode('CANTIDAD MASCOTAS'), 1, 1, 'C');

$consul = mysqli_query($conexion, "
SELECT t.nombre AS tipomascota,
COUNT(*) AS cantidadmascota
FROM mascota a, tipo_mascota t
WHERE a.id_tipo_mascota = t.id_tipo_mascota
GROUP BY a.id_tipo_mascota
");

while ($ejecutando = mysqli_fetch_array($consul)) {

    $pdf->Cell(95, 10, utf8_decode($ejecutando['tipomascota']), 1, 0, 'C');
    $pdf->Cell(95, 10, $ejecutando['cantidadmascota'], 1, 1, 'C');
}

$pdf->Output();