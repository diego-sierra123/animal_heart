<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION["id_rol"] != 3) {
    header("Location: ../login.php");
    exit();
}
?>

<?php include("../database/conexion.php") ?>

<?php include("../template_ingreso_cliente/cabecera.php") ?>

<!-- SweetAlert2 CSS y JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php include("../template_ingreso_cliente/menu.php") ?>

<div class="container-fluid container-main">
    <div class="container">
        <div class="row justify-content-center">

            <div class="row text-center">
                <h1 class="mt-3 text-center titulo-veterinaria">
                    CITAS AGENDADAS PARA HOY
                </h1>
            </div>

            <div id="table-container">

                <?php
                $idsocio = $_SESSION['id'];
                $hora_actual = date('Y-m-d H:i:s');
                $horas_a_retrasar = 7;
                $nueva_fecha = date('Y-m-d', strtotime($hora_actual . ' - ' . $horas_a_retrasar . ' hours'));
                
                $registrosPorPagina = 10;
                
                $consultaTotalRegistros = "SELECT COUNT(*) as total FROM cita WHERE id_cliente = $idsocio AND fecha = '$nueva_fecha'";
                $resultadoTotalRegistros = mysqli_query($conexion, $consultaTotalRegistros);
                $totalRegistros = mysqli_fetch_assoc($resultadoTotalRegistros)['total'];
                $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

                if (!isset($_GET['pagina'])) {
                    $pagina = 1;
                } else {
                    $pagina = (int)$_GET['pagina'];
                }

                $inicio = ($pagina - 1) * $registrosPorPagina;

                $consulta = "SELECT c.id_cita, c.fecha, c.hora 
                             FROM cita c
                             WHERE c.id_cliente = $idsocio AND c.fecha = '$nueva_fecha'
                             ORDER BY c.hora ASC 
                             LIMIT $inicio, $registrosPorPagina";

                $ejecutar = mysqli_query($conexion, $consulta);
                ?>
                
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3" style="margin-left: 0; padding-left: 0;">
                            <a href="vercitasotra.php" class="btn btn-success m-2">Buscar citas por fecha</a>
                            <a href="historialcita.php" class="btn btn-dark m-2">Regresar al historial de citas</a>
                        </div>
                    </div>
                </div>
                
                <br>
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-sm text-center align-middle w-100 tabla-veterinaria" style="border: 2px solid black; font-size: 0.9rem;">
                        <thead>
                             <tr>
                                <th scope="col">CITA</th>
                                <th scope="col">FECHA</th>
                                <th scope="col">HORA</th>
                             </tr>
                        </thead>
                        <tbody id="tabla-body">
                            <?php
                            $contador = 0;
                            if (mysqli_num_rows($ejecutar) > 0) {
                                while ($fila = mysqli_fetch_assoc($ejecutar)) {
                                    $hora_formateada = date("h:i A", strtotime($fila['hora']));
                            ?>
                                     <tr>
                                        <td class="align-middle"><b><?php echo ($inicio + $contador + 1); ?></b></td>
                                        <td class="align-middle"><?php echo $fila['fecha']; ?></td>
                                        <td class="align-middle"><?php echo $hora_formateada; ?></td>
                                     </tr>
                            <?php
                                    $contador++;
                                }
                            } else {
                                echo '<tr><td colspan="3" class="text-center">No hay citas agendadas para hoy</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <br>
                <div class="pagination-container">
                    <div class="pagination d-flex flex-wrap justify-content-center gap-2">
                        <?php
                        for ($i = 1; $i <= $totalPaginas; $i++) {
                            $activeClass = ($pagina == $i) ? 'active' : '';
                            echo "<a href='vercitas.php?pagina=$i' class='btn btn-outline-primary mx-1 my-1 $activeClass'><b>$i</b></a>";
                        }
                        ?>
                    </div>
                </div>
                <br>
            </div>

        </div>
    </div>
</div>

<?php include("../template_ingreso_cliente/pie.php") ?>