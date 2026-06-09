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

$pdf->Cell(185, 5, utf8_decode('CANTIDAD DE MASCOTAS DE LA VETERINARIA'), 0, 1, 'C');

$pdf->Ln(15);

$pdf->Cell(95, 5, utf8_decode('Fecha de hoy: ') . $nueva_fecha, 0, 0, 'L');

$pdf->Ln(15);

$pdf->Cell(190, 10, utf8_decode('CANTIDAD MASCOTAS'), 1, 1, 'C');

$consul = mysqli_query($conexion, "SELECT COUNT(*) AS cantidadmascotas FROM mascota");

while ($ejecutando = mysqli_fetch_array($consul)) {

    $pdf->Cell(190, 10, $ejecutando['cantidadmascotas'], 1, 1, 'C');
}

$pdf->Output();