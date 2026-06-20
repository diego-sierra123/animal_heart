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

$hora_actual = date('Y-m-d H:i:s');
$horas_a_retrasar = 7;
$nueva_fecha = date('Y-m-d', strtotime($hora_actual . ' - ' . $horas_a_retrasar . ' hours'));

$animales = $_GET['animal'];
$historial = $_GET['historia'];

$pdf->SetFont('Arial', 'B', 16); 
$pdf->Cell(0, 10, utf8_decode('HISTORIA CLINICA'), 0, 1, 'C'); 
$pdf->Ln(10); 

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, utf8_decode('Fecha de hoy: ') . $nueva_fecha, 0, 0, 'L');
$pdf->Ln(20);

$consul = mysqli_query($conexion, " SELECT h.id_historial_clinico, c.id_cliente, c.nombres AS cliente, m.id_mascota, m.nombre AS mascota, 
h.fecha_visita, h.diagnostico, t.id_tratamiento, t.medicamentos, t.fecha, t.observaciones , h.instrucciones, h.fecha_proxima_cita, 
h.pulso, h.cardio, h.peso, v.id_vacuna, v.nombre AS vacuna, h.fecha_vacuna, d.id_desparasitante, 
d.nombre AS desparasitante, h.fecha_desparasitante, e.id_empleado, e.nombre AS empleado 
FROM historial_clinico h 
LEFT JOIN cliente c ON h.id_cliente = c.id_cliente
LEFT JOIN mascota m ON h.id_mascota = m.id_mascota
LEFT JOIN tratamiento t ON h.id_tratamiento = t.id_tratamiento
LEFT JOIN vacuna v ON h.id_vacuna = v.id_vacuna
LEFT JOIN desparasitante d ON h.id_desparasitante = d.id_desparasitante
LEFT JOIN empleado e ON h.id_empleado = e.id_empleado 
WHERE m.id_mascota = $animales AND h.id_historial_clinico = $historial ");

while ($ejecutando = mysqli_fetch_array($consul)) {
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'INFORMACION GENERAL', 1, 1, 'C');

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(47, 10, 'PROPIETARIO:', 1, 0, 'L');
    $pdf->Cell(48, 10, empty($ejecutando['cliente']) ? 'N/A' : utf8_decode($ejecutando['cliente']), 1, 0, 'L');
    $pdf->Cell(47, 10, 'MASCOTA:', 1, 0, 'L');
    $pdf->Cell(48, 10, empty($ejecutando['mascota']) ? 'N/A' : utf8_decode($ejecutando['mascota']), 1, 1, 'L');

    $pdf->Cell(47, 10, 'FECHA VISITA:', 1, 0, 'L');
    $pdf->Cell(48, 10, empty($ejecutando['fecha_visita']) ? 'N/A' : utf8_decode($ejecutando['fecha_visita']), 1, 0, 'L');
    $pdf->Cell(47, 10, 'PULSO:', 1, 0, 'L');
    $pdf->Cell(48, 10, empty($ejecutando['pulso']) ? 'N/A' : utf8_decode($ejecutando['pulso']) .' ppm', 1, 1, 'L');

    $pdf->Cell(47, 10, 'PROXIMA VISITA:', 1, 0, 'L');
    $pdf->Cell(48, 10, empty($ejecutando['fecha_proxima_cita']) ? 'N/A' : utf8_decode($ejecutando['fecha_proxima_cita']), 1, 0, 'L');
    $pdf->Cell(47, 10, 'CARDIO:', 1, 0, 'L');
    $pdf->Cell(48, 10, empty($ejecutando['cardio']) ? 'N/A' : utf8_decode($ejecutando['cardio']) .' lpm', 1, 1, 'L');
    $pdf->Cell(47, 10, 'ATENDIDO POR:', 1, 0, 'L');
    $pdf->Cell(48, 10, empty($ejecutando['empleado']) ? 'N/A' : utf8_decode($ejecutando['empleado']), 1, 0, 'L');
    $pdf->Cell(47, 10, 'PESO:', 1, 0, 'L');
    $pdf->Cell(48, 10, empty($ejecutando['peso']) ? 'N/A' : $ejecutando['peso'] . ' kg', 1, 1, 'L');
    $pdf->Cell(47, 10, 'DIAGNOSTICO:', 1, 0, 'L');
    $pdf->Cell(143, 10, empty($ejecutando['diagnostico']) ? 'N/A' : utf8_decode($ejecutando['diagnostico']), 1, 1, 'L');
    $pdf->Cell(47, 10, 'INSTRUCCIONES:', 1, 0, 'L');
    $pdf->Cell(143, 10, empty($ejecutando['instrucciones']) ? 'N/A' : utf8_decode($ejecutando['instrucciones']), 1, 1, 'L');

    $pdf->SetFont('Arial', 'B', 14); 
    $pdf->Cell(0, 10, 'VACUNAS', 1, 1, 'C');

    $pdf->SetFont('Arial', '', 10); 
    $pdf->Cell(47, 10, 'VACUNA:', 1, 0, 'L');
    $pdf->Cell(0, 10, empty($ejecutando['vacuna']) ? 'N/A' : utf8_decode($ejecutando['vacuna']), 1, 1, 'L');
    $pdf->Cell(47, 10, 'FECHA VACUNA:', 1, 0, 'L');
    $pdf->Cell(0, 10, empty($ejecutando['fecha_vacuna']) ? 'N/A' : utf8_decode($ejecutando['fecha_vacuna']), 1, 1, 'L');

    $pdf->SetFont('Arial', 'B', 14); 
    $pdf->Cell(0, 10, 'DESPARASITANTES', 1, 1, 'C');

    $pdf->SetFont('Arial', '', 10); 
    $pdf->Cell(47, 10, 'DESPARASITANTE:', 1, 0, 'L');
    $pdf->Cell(0, 10, empty($ejecutando['desparasitante']) ? 'N/A' : utf8_decode($ejecutando['desparasitante']), 1, 1, 'L');
    $pdf->Cell(47, 10, 'FECHA DESPARASITANTE:', 1, 0, 'L');
    $pdf->Cell(0, 10, empty($ejecutando['fecha_desparasitante']) ? 'N/A' : utf8_decode($ejecutando['fecha_desparasitante']), 1, 1, 'L');

    $pdf->SetFont('Arial', 'B', 14); 
    $pdf->Cell(0, 10, 'TRATAMIENTOS', 1, 1, 'C');

    $pdf->SetFont('Arial', '', 10); 
    $pdf->Cell(47, 20, 'MEDICAMENTOS:', 1, 0, 'L');
    $pdf->MultiCell(0, 20, empty($ejecutando['medicamentos']) ? 'N/A' : utf8_decode($ejecutando['medicamentos']), 1, 'L');
    $pdf->Cell(47, 10, 'FECHA TRATAMIENTO:', 1, 0, 'L');
    $pdf->MultiCell(0, 10, empty($ejecutando['fecha']) ? 'N/A' : utf8_decode($ejecutando['fecha']), 1, 'L');
    $pdf->Cell(47, 10, 'OBSERVACIONES:', 1, 0, 'L');
    $pdf->MultiCell(0, 10, empty($ejecutando['observaciones']) ? 'N/A' : utf8_decode($ejecutando['observaciones']), 1, 'L');
    $pdf->Ln(10);
}

$pdf->Output();