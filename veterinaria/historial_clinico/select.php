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
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $id_mascota = $_GET['id'];
                $id_cliente = $_GET['clienteee'] ?? 0;

                // Obtener nombre de la mascota para mostrar
                $consulta_mascota = "SELECT nombre FROM mascota WHERE id_mascota = $id_mascota";
                $result_mascota = mysqli_query($conexion, $consulta_mascota);
                $nombre_mascota = mysqli_fetch_assoc($result_mascota)['nombre'] ?? 'Mascota';
            } else {
                echo "<div class='alert alert-danger'>Error: ID de mascota no válido</div>";
                exit;
            }
            ?>

            <div class="row text-center">
                <h1 class="mt-3 text-center titulo-veterinaria">
                    HISTORIAS CLINICAS DE: <?php echo strtoupper(htmlspecialchars($nombre_mascota)); ?>
                </h1>
            </div>

            <div id="table-container">
                <?php
                // Consulta para contar el total de registros
                $consultaTotal = "SELECT COUNT(*) as total FROM historial_clinico WHERE id_mascota = $id_mascota";
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

                // CONSULTA CORREGIDA - Eliminado el punto extra y arreglado el ORDER BY
                $consulta = "SELECT h.id_historial_clinico, c.id_cliente, c.nombres AS cliente, m.id_mascota, m.nombre AS mascota, 
                            h.fecha_visita, h.diagnostico, t.id_tratamiento, t.medicamentos AS tratamiento, h.instrucciones, 
                            h.fecha_proxima_cita, h.pulso, h.cardio, v.id_vacuna, v.nombre AS vacuna, h.fecha_vacuna, 
                            d.id_desparasitante, d.nombre AS desparasitante, h.fecha_desparasitante, e.id_empleado, e.nombre AS empleado, 
                            ns.nombre AS nombre_servicio
                            FROM historial_clinico h 
                            LEFT JOIN cliente c ON h.id_cliente = c.id_cliente
                            LEFT JOIN mascota m ON h.id_mascota = m.id_mascota
                            LEFT JOIN nom_servicio ns ON h.id_nom_servicio = ns.id_nom_servicio
                            LEFT JOIN tratamiento t ON h.id_tratamiento = t.id_tratamiento
                            LEFT JOIN vacuna v ON h.id_vacuna = v.id_vacuna
                            LEFT JOIN desparasitante d ON h.id_desparasitante = d.id_desparasitante
                            LEFT JOIN empleado e ON h.id_empleado = e.id_empleado
                            WHERE h.id_mascota = $id_mascota
                            ORDER BY h.id_historial_clinico DESC 
                            LIMIT $desde, $registrosPorPagina";

                $ejecutar = mysqli_query($conexion, $consulta);
                ?>
                <br>
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3" style="margin-left: 0; padding-left: 0;">
                            <a href="insert.php?id_mascotaa=<?php echo $id_mascota; ?>&id_clientee=<?php echo $id_cliente; ?>" class="btn btn-success m-2">+ Agregar Historia Clínica</a>
                            <a href="../mascota/select.php" class="btn btn-secondary ms-2 m-2">Regresar a Mascotas</a>
                        </div>
                    </div>
                </div>
                <br>
                <form id="search-form" class="search-form" style="justify-content: flex-start; margin-left: 0; padding-left: 0;">
                    <input type="hidden" id="id_mascota" name="id_mascota" value="<?php echo $id_mascota; ?>">
                    <input type="text" id="search-input" placeholder="Buscar por fecha..." style="margin-left: 0; width: 500px;">
                    <button type="button" class="btn btn-secondary" id="limpiar_busqueda">Borrar</button>
                </form>
                <br>
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-sm text-center align-middle w-100 tabla-veterinaria" style="border: 2px solid black; font-size: 0.9rem;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>MASCOTA</th>
                                    <th>CLIENTE</th>
                                    <th>SERVICIO</th>
                                    <th>FECHA VISITA</th>
                                    <th>PULSO</th>
                                    <th>CARDIO</th>
                                    <th>FECHA PROXIMA</th>
                                    <th>ACT</th>
                                    <th>ELIM</th>
                                    <th>PDF</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-body">
                                <?php
                                $contador_inicio = ($pagina - 1) * $registrosPorPagina + 1;
                                if (mysqli_num_rows($ejecutar) > 0) {
                                    while ($fila = mysqli_fetch_assoc($ejecutar)) {
                                        $idpac = $fila['id_historial_clinico'];
                                        $mas = $fila['mascota'] ?? '-----';
                                        $cli = $fila['cliente'] ?? '-----';
                                        $servicio = $fila['nombre_servicio'] ?? '-----';  // Variable corregida
                                        $fecvi = $fila['fecha_visita'] ?? '-----';
                                        $pul = !empty($fila['pulso']) ? $fila['pulso'] . ' ppm' : '-----';
                                        $car = !empty($fila['cardio']) ? $fila['cardio'] . ' lpm' : '-----';
                                        $fecpr = $fila['fecha_proxima_cita'] ?? '-----';
                                        $id_cliente_tabla = $fila['id_cliente'];
                                ?>
                                        <tr style="border: 1px solid black;">
                                            <td class="align-middle"><b><?php echo $contador_inicio; ?></b></td>
                                            <td class="align-middle"><?php echo htmlspecialchars($mas); ?></td>
                                            <td class="align-middle"><?php echo htmlspecialchars($cli); ?></td>
                                            <td class="align-middle"><?php echo htmlspecialchars($servicio); ?></td>
                                            <td class="align-middle"><?php echo htmlspecialchars($fecvi); ?></td>
                                            <td class="align-middle"><?php echo htmlspecialchars($pul); ?></td>
                                            <td class="align-middle"><?php echo htmlspecialchars($car); ?></td>
                                            <td class="align-middle"><?php echo htmlspecialchars($fecpr); ?></td>
                                            <td class="align-middle">
                                                <a class="btn btn-primary btn-sm py-0 px-1" href="update.php?id_mascota=<?php echo $id_mascota; ?>&id_cliente=<?php echo $id_cliente_tabla; ?>&id_historia=<?php echo $idpac; ?>" style="font-size: 0.7rem;">
                                                    <i class="fas fa-sync"></i>
                                                </a>
                                            </td>
                                            <td class="align-middle">
                                                <button type="button" class="btn btn-danger btn-sm py-0 px-1" style="font-size: 0.7rem;"
                                                    onclick="confirmarEliminacion(<?php echo $id_mascota; ?>, <?php echo $id_cliente_tabla; ?>, <?php echo $idpac; ?>)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                            <td class="align-middle">
                                                <a href="../historial_clinico/historial.php?animal=<?php echo $id_mascota; ?>&historia=<?php echo $idpac; ?>" class="btn btn-info btn-sm py-0 px-1" style="font-size: 0.7rem;" target="_blank">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            </td>
                                        </tr>
                                <?php
                                        $contador_inicio++;
                                    }
                                } else {
                                    echo '<tr><td colspan="11" class="text-center align-middle">No hay historias clínicas registradas para esta mascota.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php
                if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
                    $borrar_id = mysqli_real_escape_string($conexion, $_GET['eliminar']);

                    $eliminar = "DELETE FROM historial_clinico WHERE id_historial_clinico='$borrar_id'";
                    $ejecutar_eliminar = mysqli_query($conexion, $eliminar);

                    if ($ejecutar_eliminar) {
                        echo '<script type="text/javascript">
                                swal({
                                    title: "Mensaje",
                                    text: "Eliminación exitosa.",
                                    icon: "success",
                                    showCancelButton: false, 
                                    confirmButtonText: "OK" 
                                }).then(function() {
                                    window.open("select.php?id=' . $id_mascota . '&clienteee=' . $id_cliente . '", "_self");
                                });
                            </script>';
                    } else {
                        echo '<script type="text/javascript">
                                swal({
                                    title: "Error",
                                    text: "Error al eliminar el registro: ' . addslashes(mysqli_error($conexion)) . '",
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
                                echo "<a href='select.php?id=$id_mascota&clienteee=$id_cliente&pagina=$i' class='btn btn-outline-primary mx-1 my-1 $activeClass'><b>$i</b></a>";
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

        // Función de búsqueda automática mientras escribe
        $('#search-input').on('keyup', function() {
            clearTimeout(timeoutId);
            var searchTerm = $(this).val();

            timeoutId = setTimeout(function() {
                if (searchTerm.trim() === '') {
                    location.reload();
                } else {
                    realizarBusqueda(searchTerm);
                }
            }, 500); // Espera 500ms después de dejar de escribir
        });

        function realizarBusqueda(searchTerm) {
            var id_mascota = $('#id_mascota').val();

            $.ajax({
                url: 'search.php',
                type: 'GET',
                data: {
                    id: id_mascota,
                    search: searchTerm
                },
                success: function(response) {
                    $('#tabla-body').html(response);
                },
                error: function(xhr, status, error) {
                    console.log('Error en la búsqueda:', error);
                    $('#tabla-body').html('<tr><td colspan="11" class="text-center text-danger">Error en la búsqueda</td></tr>');
                }
            });
        }

        // Botón para limpiar búsqueda
        $('#limpiar_busqueda').click(function() {
            $('#search-input').val('');
            location.reload();
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmarEliminacion(id_mascota, id_cliente, id_historia) {
        Swal.fire({
            title: '¿Está seguro?',
            text: "¡Esta acción no se puede deshacer!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#3085d6',
            confirmButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sí, eliminar',
            reverseButtons: true
            
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirigir a la URL de eliminación
                window.location.href = `select.php?id=${id_mascota}&clienteee=${id_cliente}&eliminar=${id_historia}`;
            }
        });
    }
</script>

<?php include("../template_ingreso_admin/pie.php") ?>