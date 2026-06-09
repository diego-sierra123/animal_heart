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

$pdf->Cell(185, 5, utf8_decode('MASCOTAS QUE CONTIENEN LOS CLIENTES'), 0, 1, 'C');

$pdf->Ln(15);

$pdf->Cell(95, 5, utf8_decode('Fecha de hoy: ') . $nueva_fecha, 0, 0, 'L');

$pdf->Ln(15);

$buscado = mysqli_real_escape_string($conexion, $_GET['buscado']);

$consul = mysqli_query($conexion, "
SELECT CONCAT(nombres, ' ', apellidos) AS nombre_cliente, id_cliente
FROM cliente
WHERE CONCAT(nombres, ' ', apellidos) LIKE '%$buscado%'
");

if (mysqli_num_rows($consul) === 0) {

    $pdf->Cell(191, 10, utf8_decode('NO SE ENCONTRARON RESULTADOS EN LA BÚSQUEDA.'), 1, 1, 'C');

} else {

    while ($cliente = mysqli_fetch_array($consul)) {

        $id_cliente = $cliente['id_cliente'];

        $consulta_mascotas = "
        SELECT m.nombre, t.nombre AS tipo_animal, r.nombre AS raza
        FROM mascota m, tipo_mascota t, raza r
        WHERE m.id_tipo_mascota = t.id_tipo_mascota
        AND m.id_raza = r.id_raza
        AND m.id_cliente = $id_cliente
        ";

        $sql_mascotas = mysqli_query($conexion, $consulta_mascotas);

        $cantidad_total_mascotas = mysqli_num_rows($sql_mascotas);

        $pdf->Cell(
            153,
            10,
            utf8_decode($cliente['nombre_cliente'] . ' tiene la siguiente cantidad de mascotas:'),
            1,
            0,
            'C'
        );

        $pdf->Cell(38, 10, $cantidad_total_mascotas, 1, 1, 'C');

        $pdf->Cell(58, 10, utf8_decode('NOMBRE DEL CLIENTE'), 1, 0, 'C');
        $pdf->Cell(50, 10, utf8_decode('NOMBRE DE LA MASCOTA'), 1, 0, 'C');
        $pdf->Cell(45, 10, 'RAZA', 1, 0, 'C');
        $pdf->Cell(38, 10, utf8_decode('TIPO DE ANIMAL'), 1, 1, 'C');

        if ($cantidad_total_mascotas > 0) {

            while ($mascota = mysqli_fetch_array($sql_mascotas)) {

                $pdf->Cell(58, 10, utf8_decode($cliente['nombre_cliente']), 1, 0, 'C');
                $pdf->Cell(50, 10, utf8_decode($mascota['nombre']), 1, 0, 'C');
                $pdf->Cell(45, 10, utf8_decode($mascota['raza']), 1, 0, 'C');
                $pdf->Cell(38, 10, utf8_decode($mascota['tipo_animal']), 1, 1, 'C');
            }

        } else {

            $pdf->Cell(58, 10, utf8_decode($cliente['nombre_cliente']), 1, 0, 'C');
            $pdf->Cell(50, 10, 'N/A', 1, 0, 'C');
            $pdf->Cell(45, 10, 'N/A', 1, 0, 'C');
            $pdf->Cell(38, 10, 'N/A', 1, 1, 'C');
        }
    }
}

$pdf->Output();