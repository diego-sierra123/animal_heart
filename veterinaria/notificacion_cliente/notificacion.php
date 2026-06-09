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
                    NOTIFICACIONES
                </h1>
            </div>

            <div id="table-container">

                <?php
                $idsocio = $_SESSION['id'];
                $registrosPorPagina = 10;
                
                $consultaTotalRegistros = "SELECT COUNT(*) as total FROM cita WHERE id_cliente = $idsocio AND id_ver = 1";
                $resultadoTotalRegistros = mysqli_query($conexion, $consultaTotalRegistros);
                $totalRegistros = mysqli_fetch_assoc($resultadoTotalRegistros)['total'];
                $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

                if (!isset($_GET['pagina'])) {
                    $pagina = 1;
                } else {
                    $pagina = (int)$_GET['pagina'];
                }

                $inicio = ($pagina - 1) * $registrosPorPagina;

                $consulta = "SELECT ci.*, CONCAT(c.nombres,' ',c.apellidos) AS nombrecliente, 
                                    es.id_estado_cita, es.nombre AS estado, m.nombre AS mascotica, 
                                    s.nombre AS servicio 
                             FROM cita ci
                             INNER JOIN cliente c ON ci.id_cliente = c.id_cliente
                             INNER JOIN mascota m ON ci.id_mascota = m.id_mascota
                             INNER JOIN estado_cita es ON ci.id_estado_cita = es.id_estado_cita
                             INNER JOIN nom_servicio s ON ci.id_nom_servicio = s.id_nom_servicio
                             WHERE ci.id_cliente = $idsocio AND ci.id_ver = 1
                             ORDER BY ci.id_cita DESC
                             LIMIT $inicio, $registrosPorPagina";

                $ejecutar = mysqli_query($conexion, $consulta);
                ?>
                
                <br>
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-sm text-center align-middle w-100 tabla-veterinaria" style="border: 2px solid black; font-size: 0.9rem;">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">FECHA</th>
                                <th scope="col">HORA</th>
                                <th scope="col">CLIENTE</th>
                                <th scope="col">MASCOTA</th>
                                <th scope="col">ESTADO</th>
                                <th scope="col">SERVICIO</th>
                                <th scope="col">DESCRIPCIÓN</th>
                                <th scope="col">MARCAR COMO LEÍDO</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-body">
                            <?php
                            $contador = 0;
                            if (mysqli_num_rows($ejecutar) > 0) {
                                while ($fila = mysqli_fetch_assoc($ejecutar)) {
                                    $idre = $fila['id_cita'];
                                    $fec = $fila['fecha'];
                                    $hor = $fila['hora'];
                                    $cli = $fila["nombrecliente"];
                                    $mas = $fila["mascotica"];
                                    $est = $fila["estado"];
                                    $ser = $fila["servicio"];
                                    $des = substr($fila["descripcion"], 0, 30) . (strlen($fila["descripcion"]) > 30 ? '...' : '');
                                    $idest = $fila["id_estado_cita"];
                                    
                                    $hora_formateada = date("h:i A", strtotime($hor));
                            ?>
                                    <tr>
                                        <td class="align-middle"><b><?php echo ($inicio + $contador + 1); ?></b></td>
                                        <td class="align-middle"><?php echo $fec; ?></td>
                                        <td class="align-middle"><?php echo $hora_formateada; ?></td>
                                        <td class="align-middle"><?php echo $cli; ?></td>
                                        <td class="align-middle"><?php echo $mas; ?></td>
                                        <td class="align-middle">
                                            <?php
                                            if ($idest == 1) {
                                                echo '<span class="badge bg-warning text-dark">' . $est . '</span>';
                                            } elseif ($idest == 2) {
                                                echo '<span class="badge bg-success">' . $est . '</span>';
                                            } else {
                                                echo '<span class="badge bg-danger">' . $est . '</span>';
                                            }
                                            ?>
                                        </td>
                                        <td class="align-middle"><?php echo $ser; ?></td>
                                        <td class="align-middle" title="<?php echo $fila["descripcion"]; ?>"><?php echo $des; ?></td>
                                        <td class="align-middle">
                                            <button type="button" class="btn btn-info btn-sm py-0 px-2" style="font-size: 0.7rem;" onclick="marcarComoLeido(<?php echo $idre; ?>)">
                                                <i class="fas fa-check-circle"></i> Marcar como leído
                                            </button>
                                        </td>
                                    </tr>
                            <?php
                                    $contador++;
                                }
                            } else {
                                echo '<tr><td colspan="9" class="text-center">No hay notificaciones pendientes</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <?php
                if (isset($_GET['marcar_leido'])) {
                    $marcar_id = mysqli_real_escape_string($conexion, $_GET['marcar_leido']);
                    $actualizar = "UPDATE cita SET id_ver = 3 WHERE id_cita='$marcar_id' AND id_cliente='" . $_SESSION['id'] . "'";
                    $ejecutar_actualizar = mysqli_query($conexion, $actualizar);

                    if ($ejecutar_actualizar) {
                        echo '<script type="text/javascript">
                        Swal.fire({
                            title: "Mensaje",
                            text: "Notificación marcada como leída exitosamente.",
                            icon: "success",
                            showCancelButton: false,
                            confirmButtonText: "OK"
                        }).then(function() {
                            window.location.href = "notificacion.php";
                        });
                        </script>';
                    }
                }
                ?>

                <br>
                <div class="pagination-container">
                    <div class="pagination d-flex flex-wrap justify-content-center gap-2">
                        <?php
                        for ($i = 1; $i <= $totalPaginas; $i++) {
                            $activeClass = ($pagina == $i) ? 'active' : '';
                            echo "<a href='notificacion.php?pagina=$i' class='btn btn-outline-primary mx-1 my-1 $activeClass'><b>$i</b></a>";
                        }
                        ?>
                    </div>
                </div>
                <br>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function marcarComoLeido(idCita) {
        Swal.fire({
            title: '¿Marcar como leído?',
            text: 'Esta notificación ya no volverá a aparecer en esta sección.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, marcar como leído',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
            
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `notificacion.php?marcar_leido=${idCita}`;
            }
        });
    }
</script>

<?php include("../template_ingreso_cliente/pie.php") ?>