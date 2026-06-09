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
                    CITAS DEL DÍA
                </h1>
            </div>

            <div id="table-container">
                <?php
                $hora_actual = date('Y-m-d H:i:s');
                $horas_a_retrasar = 7;
                $nueva_fecha = date('Y-m-d', strtotime($hora_actual . ' - ' . $horas_a_retrasar . ' hours'));

                // Consulta para contar el total de registros
                $consultaTotal = "SELECT COUNT(*) as total FROM cita WHERE fecha = '$nueva_fecha'";
                $resultadoTotal = mysqli_query($conexion, $consultaTotal);
                $filaTotal = mysqli_fetch_assoc($resultadoTotal);
                $totalRegistros = $filaTotal['total'];

                $registrosPorPagina = 10;
                $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

                if (!isset($_GET['pagina'])) {
                    $pagina = 1;
                } else {
                    $pagina = $_GET['pagina'];
                }

                $desde = ($pagina - 1) * $registrosPorPagina;

                $consulta = "SELECT c.id_cita, c.fecha, c.hora, CONCAT(cl.nombres,' ',cl.apellidos) AS cliente, 
                                    m.nombre AS mascota, es.id_estado_cita, es.nombre AS estado_cita, 
                                    nom.nombre AS servicio, c.descripcion 
                            FROM cita c
                            LEFT JOIN cliente cl ON c.id_cliente = cl.id_cliente
                            LEFT JOIN mascota m ON c.id_mascota = m.id_mascota
                            LEFT JOIN estado_cita es ON c.id_estado_cita = es.id_estado_cita
                            LEFT JOIN nom_servicio nom ON c.id_nom_servicio = nom.id_nom_servicio
                            WHERE c.fecha = '$nueva_fecha'
                            ORDER BY c.hora ASC 
                            LIMIT $desde, $registrosPorPagina";

                $ejecutar = mysqli_query($conexion, $consulta);
                ?>
                <br>
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3" style="margin-left: 0; padding-left: 0;">
                            <a href="select.php" class="btn btn-dark m-2">Regresar a todas las citas</a>
                        </div>
                    </div>
                </div>
                <br>
                <form id="search-form" class="search-form" style="justify-content: flex-start; margin-left: 0; padding-left: 0;">
                    <input type="text" id="search-input" placeholder="Buscar por hora (ej: 02:00 PM)..." style="margin-left: 0; width: 500px;">
                    <button type="button" class="btn btn-secondary" id="limpiar_busqueda">Borrar</button>
                </form>
                <br>
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-sm text-center align-middle w-100 tabla-veterinaria" style="border: 2px solid black; font-size: 0.9rem;">
                            <thead>
                                <tr>
                                    <th>ID_CITA</th>
                                    <th>FECHA</th>
                                    <th>HORA</th>
                                    <th>CLIENTE</th>
                                    <th>MASCOTA</th>
                                    <th>ESTADO</th>
                                    <th>SERVICIO</th>
                                    <th>DESCRIPCIÓN</th>
                                    <th>ACT</th>
                                    <th>ELIM</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-body">
                                <?php
                                $contador_inicio = ($pagina - 1) * $registrosPorPagina + 1;
                                if (mysqli_num_rows($ejecutar) > 0) {
                                    while ($fila = mysqli_fetch_assoc($ejecutar)) {
                                        $id_cita = $fila['id_cita'];
                                        $fecha = $fila['fecha'] ?? '-----';
                                        $hora = $fila['hora'] ?? '-----';
                                        $hora_formateada = !empty($hora) ? date("h:i A", strtotime($hora)) : '-----';
                                        $cliente = $fila['cliente'] ?? '-----';
                                        $mascota = $fila['mascota'] ?? '-----';
                                        $estado = $fila['estado_cita'] ?? '-----';
                                        $servicio = $fila['servicio'] ?? '-----';
                                        $descripcion = $fila['descripcion'] ?? '-----';
                                        $idest = $fila['id_estado_cita'];
                                ?>
                                        <tr style="border: 1px solid black;">
                                            <td class="align-middle"><b><?php echo $contador_inicio; ?></b> </td>
                                            <td class="align-middle"><?php echo htmlspecialchars($fecha); ?></td>
                                            <td class="align-middle"><?php echo htmlspecialchars($hora_formateada); ?></td>
                                            <td class="align-middle"><?php echo htmlspecialchars($cliente); ?></td>
                                            <td class="align-middle"><?php echo htmlspecialchars($mascota); ?></td>
                                            <td class="align-middle"><?php echo htmlspecialchars($estado); ?></td>
                                            <td class="align-middle"><?php echo htmlspecialchars($servicio); ?></td>
                                            <td class="align-middle"><?php echo htmlspecialchars($descripcion); ?></td>
                                            <td class="align-middle">
                                                <?php if ($idest == 1) { ?>
                                                    <a class="btn btn-primary btn-sm py-0 px-1" href="updatedia.php?actualizar=<?php echo $id_cita; ?>" style="font-size: 0.7rem;">
                                                        <i class="fas fa-sync"></i>
                                                    </a>
                                                <?php } else { ?>
                                                    <span class="text-primary" style="font-size: 0.7rem;">N/A</span>
                                                <?php } ?>
                                            </td>
                                            <td class="align-middle">
                                                <?php if ($idest == 1) { ?>
                                                    <button type="button" class="btn btn-danger btn-sm py-0 px-1" style="font-size: 0.7rem;"
                                                        onclick="confirmarEliminacion(<?php echo $id_cita; ?>)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                <?php } else { ?>
                                                    <span class="text-danger" style="font-size: 0.7rem;">N/A</span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                <?php
                                        $contador_inicio++;
                                    }
                                } else {
                                    echo '<tr><td colspan="10" class="text-center align-middle">No hay citas programadas para hoy.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php
                if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
                    $borrar_id = mysqli_real_escape_string($conexion, $_GET['eliminar']);

                    $eliminar = "DELETE FROM cita WHERE id_cita='$borrar_id'";
                    $ejecutar_eliminar = mysqli_query($conexion, $eliminar);

                    if ($ejecutar_eliminar) {
                        echo '<script type="text/javascript">
                                swal({
                                    title: "Mensaje",
                                    text: "Cita cancelada exitosamente.",
                                    icon: "success",
                                    showCancelButton: false, 
                                    confirmButtonText: "OK" 
                                }).then(function() {
                                    window.open("selectdia.php", "_self");
                                });
                            </script>';
                    } else {
                        echo '<script type="text/javascript">
                                swal({
                                    title: "Error",
                                    text: "Error al cancelar la cita: ' . addslashes(mysqli_error($conexion)) . '",
                                    icon: "error",
                                    showCancelButton: false, 
                                    confirmButtonText: "OK" 
                                });
                            </script>';
                    }
                }
                ?>

                <br>
                <?php if ($totalPaginas > 1): ?>
                    <div class="pagination-container">
                        <div class="pagination d-flex flex-wrap justify-content-center gap-2">
                            <?php
                            for ($i = 1; $i <= $totalPaginas; $i++) {
                                $activeClass = ($pagina == $i) ? 'active' : '';
                                echo "<a href='selectdia.php?pagina=$i' class='btn btn-outline-primary mx-1 my-1 $activeClass'><b>$i</b></a>";
                            }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
                <br>
                <br>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let timeoutId = null;

        $('#search-input').on('keyup', function() {
            clearTimeout(timeoutId);
            var searchTerm = $(this).val();

            timeoutId = setTimeout(function() {
                if (searchTerm.trim() === '') {
                    location.reload();
                } else {
                    realizarBusqueda(searchTerm);
                }
            }, 500);
        });

        function realizarBusqueda(searchTerm) {
            $.ajax({
                url: 'search_two.php',
                type: 'POST',
                data: { search: searchTerm },
                success: function(response) {
                    $('#tabla-body').html(response);
                },
                error: function(xhr, status, error) {
                    console.log('Error en la búsqueda:', error);
                    $('#tabla-body').html('<tr><td colspan="10" class="text-center text-danger">Error en la búsqueda</td></tr>');
                }
            });
        }

        $('#limpiar_busqueda').click(function() {
            $('#search-input').val('');
            location.reload();
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmarEliminacion(id_cita) {
        Swal.fire({
            title: '¿Está seguro?',
            text: "¡Esta acción cancelará la cita!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#3085d6',
            confirmButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sí, cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `selectdia.php?eliminar=${id_cita}`;
            }
        });
    }
</script>

<?php include("../template_ingreso_admin/pie.php") ?>