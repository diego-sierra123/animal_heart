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

$pdf->Cell(185, 5, utf8_decode('GANANCIAS DEL MES'), 0, 1, 'C');

$pdf->Ln(15);

$pdf->Cell(95, 5, utf8_decode('Fecha de hoy: ') . $nueva_fecha, 0, 0, 'L');

$pdf->Ln(15);

$meses = [
    'enero' => 1,
    'febrero' => 2,
    'marzo' => 3,
    'abril' => 4,
    'mayo' => 5,
    'junio' => 6,
    'julio' => 7,
    'agosto' => 8,
    'septiembre' => 9,
    'octubre' => 10,
    'noviembre' => 11,
    'diciembre' => 12
];

$buscado = strtolower(mysqli_real_escape_string($conexion, $_GET['buscado']));

$partes = explode(' ', $buscado);

if (count($partes) === 2) {

    $mesTexto = $partes[0];
    $ano = $partes[1];

    if (isset($meses[$mesTexto]) && is_numeric($ano)) {

        $mesNumero = $meses[$mesTexto];

        $consulta = "
        SELECT MONTH(f.fecha) AS mes,
        SUM(df.valor_total - (a.costo_conseguido * df.cantidad)) AS ganancias
        FROM factura f
        JOIN detalle_factura df ON f.id_factura = df.id_factura
        JOIN articulo a ON df.id_articulo = a.id_articulo
        WHERE f.id_estado_factura = 1
        AND MONTH(f.fecha) = $mesNumero
        AND YEAR(f.fecha) = $ano
        ";

        $sql = mysqli_query($conexion, $consulta);

        if ($sql) {

            $resultadosEncontrados = false;

            while ($datos = mysqli_fetch_array($sql)) {

                $pdf->Cell(95, 10, 'MES', 1, 0, 'C');
                $pdf->Cell(95, 10, 'GANANCIAS', 1, 1, 'C');

                $pdf->Cell(95, 10, utf8_decode($mesTexto . ' ' . $ano), 1, 0, 'C');

                $pdf->Cell(
                    95,
                    10,
                    '$' . (number_format($datos['ganancias'] == 0 ? "0" : $datos['ganancias'], 0, ',', '.')),
                    1,
                    1,
                    'C'
                );

                $resultadosEncontrados = true;
            }

            if (!$resultadosEncontrados) {

                $pdf->Cell(
                    190,
                    10,
                    utf8_decode('NO SE ENCONTRARON RESULTADOS EN LA BÚSQUEDA.'),
                    1,
                    1,
                    'C'
                );
            }

        } else {

            $pdf->Cell(
                190,
                10,
                utf8_decode('ERROR AL EJECUTAR LA CONSULTA.'),
                1,
                1,
                'C'
            );
        }

    } else {

        $pdf->Cell(
            190,
            10,
            utf8_decode('FORMATO INCORRECTO EN LA BÚSQUEDA.'),
            1,
            1,
            'C'
        );
    }

} else {

    $pdf->Cell(
        190,
        10,
        utf8_decode('NO SE ENCONTRARON RESULTADOS EN LA BÚSQUEDA.'),
        1,
        1,
        'C'
    );
}

$pdf->Output();