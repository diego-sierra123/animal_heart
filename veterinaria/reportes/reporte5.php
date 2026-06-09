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

            <div class="row text-center">
                <h1 class="mt-3 text-center titulo-veterinaria">
                    CANTIDAD DE MASCOTAS SEGÚN EL TIPO
                </h1>
            </div>

            <div id="table-container">
                <br>
                <br>
                <div class="row">
                    <div class="col-12 text-center">
                        <a href="reporte.php" class="btn btn-dark m-2">Atrás</a>
                        <a href="pdf5.php" class="btn btn-danger m-2" target="_blank">
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
                                    <th>FECHA DE HOY</th>
                                    <th>TIPO DE MASCOTA</th>
                                    <th>CANTIDAD MASCOTAS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $hora_actual = date('Y-m-d H:i:s');
                                $horas_a_retrasar = 7;
                                $nueva_fecha = date('Y-m-d', strtotime($hora_actual . ' - ' . $horas_a_retrasar . ' hours'));

                                $consulta = "SELECT t.nombre AS tipomascota, COUNT(*) AS cantidadmascota 
                                            FROM mascota m 
                                            INNER JOIN tipo_mascota t ON m.id_tipo_mascota = t.id_tipo_mascota 
                                            GROUP BY m.id_tipo_mascota";
                                $sql = mysqli_query($conexion, $consulta);
                                
                                if (mysqli_num_rows($sql) > 0) {
                                    while ($datos = mysqli_fetch_assoc($sql)) {
                                        echo '<tr style="border: 1px solid black;">';
                                        echo '<td class="align-middle">' . $nueva_fecha . '</td>';
                                        echo '<td class="align-middle">' . htmlspecialchars($datos['tipomascota']) . '</td>';
                                        echo '<td class="align-middle">' . number_format($datos['cantidadmascota'], 0) . '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="3" class="text-center align-middle">No hay datos disponibles</td></tr>';
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