<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION["id_rol"] != 1 && $_SESSION["id_rol"] != 2) {
    header("Location: ../login.php");
    exit();
}
?>

<?php include("../database/conexion.php") ?>
<?php include("../template_ingreso_admin/cabecera.php") ?>
<?php include("../template_ingreso_admin/menu.php") ?>

<div class="container-fluid container-main">
    <div class="container">
        <div class="row justify-content-center">

            <?php
            $buscado = isset($_GET['txtbuscar']) ? mysqli_real_escape_string($conexion, $_GET['txtbuscar']) : '';
            ?>

            <div class="row text-center">
                <h1 class="mt-3 text-center titulo-veterinaria">
                    GANANCIAS: <?php echo strtoupper(htmlspecialchars($buscado)); ?>
                </h1>
            </div>

            <div id="table-container">
                <br>
                <br>
                <div class="row">
                    <div class="col-12 text-center">
                        <a href="reporte6.php" class="btn btn-dark m-2">Atrás</a>
                        <a href="pdf6.php?buscado=<?php echo urlencode($buscado); ?>" class="btn btn-danger m-2" target="_blank">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                    </div>
                </div>

                <br><br>
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-sm text-center align-middle w-100 tabla-veterinaria" style="border: 2px solid black; font-size: 0.9rem;">
                            <thead>
                                <tr class="table-dark">
                                    <th>MES</th>
                                    <th>GANANCIAS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (empty($buscado)) {
                                    echo '<tr><td colspan="2" class="text-center align-middle">Por favor, ingrese un mes y año para buscar.</td></tr>';
                                } else {
                                    $meses = [
                                        'enero' => 1, 'febrero' => 2, 'marzo' => 3, 'abril' => 4,
                                        'mayo' => 5, 'junio' => 6, 'julio' => 7, 'agosto' => 8,
                                        'septiembre' => 9, 'octubre' => 10, 'noviembre' => 11, 'diciembre' => 12
                                    ];

                                    $busqueda = strtolower(trim($buscado));
                                    $partes = explode(' ', $busqueda);

                                    if (count($partes) === 2) {
                                        $mesTexto = $partes[0];
                                        $ano = $partes[1];

                                        if (isset($meses[$mesTexto]) && is_numeric($ano) && strlen($ano) == 4) {
                                            $mesNumero = $meses[$mesTexto];

                                            $consulta = "SELECT 
                                                            SUM(df.valor_total - (a.costo_conseguido * df.cantidad)) AS ganancias
                                                        FROM factura f
                                                        INNER JOIN detalle_factura df ON f.id_factura = df.id_factura
                                                        INNER JOIN articulo a ON df.id_articulo = a.id_articulo
                                                        WHERE f.id_estado_factura = 1
                                                        AND MONTH(f.fecha) = $mesNumero
                                                        AND YEAR(f.fecha) = $ano";
                                            $sql = mysqli_query($conexion, $consulta);

                                            if ($sql) {
                                                $resultadosEncontrados = false;
                                                while ($datos = mysqli_fetch_assoc($sql)) {
                                                    $ganancia = $datos['ganancias'] ?? 0;
                                                    echo '<tr style="border: 1px solid black;">';
                                                    echo '<td class="align-middle">' . ucfirst($mesTexto) . ' ' . $ano . '</td>';
                                                    echo '<td class="align-middle">$ ' . number_format($ganancia, 0, ',', '.') . '</td>';
                                                    echo '</tr>';
                                                    $resultadosEncontrados = true;
                                                }

                                                if (!$resultadosEncontrados) {
                                                    echo '<tr><td colspan="2" class="text-center align-middle">No se encontraron ganancias para ' . ucfirst($mesTexto) . ' ' . $ano . '</td></tr>';
                                                }
                                            } else {
                                                echo '<tr><td colspan="2" class="text-center align-middle text-danger">Error en la consulta</td></tr>';
                                            }
                                        } else {
                                            echo '<tr><td colspan="2" class="text-center align-middle">Formato incorrecto o mes no válido. Ejemplo: Enero 2026</td></tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="2" class="text-center align-middle">Formato incorrecto. Use: Mes Año (ejemplo: Enero 2026)</td></tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <br>
                <br>
            </div>

        </div>
    </div>
</div>

<?php include("../template_ingreso_admin/pie.php") ?>