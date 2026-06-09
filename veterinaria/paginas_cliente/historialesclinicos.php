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

<?php include("../template_ingreso_cliente/menu.php") ?>

<div class="container-fluid container-main">
    <div class="container">
        <div class="row justify-content-center">

            <div class="row text-center">
                <h1 id="unico" class="mt-3 text-center titulo-veterinaria">
                    HISTORIALES CLÍNICOS DE LA MASCOTA
                </h1>
            </div>

            <div id="table-container">
                <?php
                if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                    $id_mascota = (int)$_GET['id'];

                    // Verificar que la mascota pertenezca al cliente
                    $verificar = "SELECT id_mascota FROM mascota WHERE id_mascota = $id_mascota AND id_cliente = '" . $_SESSION['id'] . "'";
                    $verificar_result = mysqli_query($conexion, $verificar);

                    if (mysqli_num_rows($verificar_result) == 0) {
                        echo '<div class="alert alert-danger">No tienes permisos para ver esta mascota.</div>';
                        exit;
                    }

                    $consultaMascota = "SELECT nombre FROM mascota WHERE id_mascota = $id_mascota";
                    $resultadoMascota = mysqli_query($conexion, $consultaMascota);
                    $nombreMascota = mysqli_fetch_assoc($resultadoMascota)['nombre'];

                    $consultaTotal = "SELECT COUNT(*) as total FROM historial_clinico WHERE id_mascota = $id_mascota";
                    $resultadoTotal = mysqli_query($conexion, $consultaTotal);
                    $filaTotal = mysqli_fetch_assoc($resultadoTotal);
                    $totalRegistros = $filaTotal['total'];

                    $registrosPorPagina = 10;
                    $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

                    if (!isset($_GET['pagina'])) {
                        $pagina = 1;
                    } else {
                        $pagina = (int)$_GET['pagina'];
                    }

                    $desde = ($pagina - 1) * $registrosPorPagina;

                    $consulta = "SELECT h.id_historial_clinico, c.nombres AS cliente, m.nombre AS mascota, 
                                        h.fecha_visita, h.diagnostico, h.instrucciones, h.fecha_proxima_cita, 
                                        h.pulso, h.cardio, v.nombre AS vacuna, h.fecha_vacuna, 
                                        d.nombre AS desparasitante, h.fecha_desparasitante, e.nombre AS empleado 
                                 FROM historial_clinico h 
                                 LEFT JOIN cliente c ON h.id_cliente = c.id_cliente
                                 LEFT JOIN mascota m ON h.id_mascota = m.id_mascota
                                 LEFT JOIN vacuna v ON h.id_vacuna = v.id_vacuna
                                 LEFT JOIN desparasitante d ON h.id_desparasitante = d.id_desparasitante
                                 LEFT JOIN empleado e ON h.id_empleado = e.id_empleado
                                 WHERE h.id_mascota = $id_mascota
                                 ORDER BY h.fecha_visita DESC 
                                 LIMIT $desde, $registrosPorPagina";

                    $ejecutar = mysqli_query($conexion, $consulta);
                } else {
                    echo '<div class="alert alert-danger">Error: ID de mascota no válido</div>';
                    exit;
                }
                ?>

                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3" style="margin-left: 0; padding-left: 0;">
                            <a href="historialmascota.php" class="btn btn-dark m-2">Regresar a Mascotas</a>
                            <span class="ms-3"><strong>Mascota:</strong> <?php echo $nombreMascota; ?></span>
                        </div>
                    </div>
                </div>

                <form id="search-form" class="search-form" style="justify-content: flex-start; margin-left: 0; padding-left: 0;">
                    <input type="hidden" id="id_mascota" name="id_mascota" value="<?php echo $id_mascota; ?>">
                    <input type="text" id="search-input"
                        placeholder="Buscar por fecha (YYYY-MM-DD)..."
                        style="margin-left: 0; width: 500px;">
                    <button type="button" class="btn btn-secondary" id="borrar_contenido">Borrar</button>
                </form>

                <br>
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-sm text-center align-middle w-100 tabla-veterinaria" style="border: 2px solid black; font-size: 0.9rem;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">MASCOTA</th>
                                    <th scope="col">CLIENTE</th>
                                    <th scope="col">FECHA VISITA</th>
                                    <th scope="col">PULSO</th>
                                    <th scope="col">CARDIO</th>
                                    <th scope="col">FECHA PROXIMA</th>
                                    <th scope="col">PDF</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $contador_inicio = ($pagina - 1) * $registrosPorPagina + 1;
                                if (mysqli_num_rows($ejecutar) > 0) {
                                    while ($fila = mysqli_fetch_assoc($ejecutar)) {
                                        $idpac = $fila['id_historial_clinico'];
                                        $mas = $fila['mascota'];
                                        $cli = $fila['cliente'];
                                        $fecvi = $fila['fecha_visita'];
                                        $pul = $fila['pulso'];
                                        $car = $fila['cardio'];
                                        $fecpr = $fila['fecha_proxima_cita'];
                                ?>
                                        <tr>
                                            <td class="align-middle"><b><?php echo $contador_inicio; ?></b></td>
                                            <td class="align-middle"><?php echo !empty($mas) ? $mas : '-----'; ?></td>
                                            <td class="align-middle"><?php echo !empty($cli) ? $cli : '-----'; ?></td>
                                            <td class="align-middle"><?php echo !empty($fecvi) ? $fecvi : '-----'; ?></td>
                                            <td class="align-middle"><?php echo !empty($pul) ? $pul . ' ppm' : '-----'; ?></td>
                                            <td class="align-middle"><?php echo !empty($car) ? $car . ' lpm' : '-----'; ?></td>
                                            <td class="align-middle"><?php echo !empty($fecpr) ? $fecpr : '-----'; ?></td>
                                            <td class="align-middle">
                                                <a href="historial.php?animal=<?php echo $id_mascota; ?>&historia=<?php echo $idpac; ?>" class="btn btn-info btn-sm py-0 px-1" target="_blank" style="font-size: 0.7rem;">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            </td>
                                        </tr>
                                <?php
                                        $contador_inicio++;
                                    }
                                } else {
                                    echo '<tr><td colspan="8" class="text-center">No hay historiales clínicos para esta mascota</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <br>
                <?php if ($totalPaginas > 0) { ?>
                    <div class="pagination-container">
                        <div class="pagination d-flex flex-wrap justify-content-center gap-2">
                            <?php
                            for ($i = 1; $i <= $totalPaginas; $i++) {
                                $activeClass = ($pagina == $i) ? 'active' : '';
                                echo "<a href='historialesclinicos.php?id=$id_mascota&pagina=$i' class='btn btn-outline-primary mx-1 my-1 $activeClass'><b>$i</b></a>";
                            }
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <br>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var timeoutId = null;

        function realizarBusqueda() {
            var searchTerm = $('#search-input').val();
            var id_mascota = $('#id_mascota').val();
            var pagina = <?php echo isset($pagina) ? $pagina : 1; ?>;

            if (searchTerm.trim() === '') {
                // Si está vacío, recargar la página para mostrar todos los registros
                location.reload();
                return;
            }

            $.ajax({
                url: 'search_mascota_two.php',
                type: 'GET',
                data: {
                    id: id_mascota,
                    search: searchTerm,
                    pagina: pagina
                },
                success: function(response) {
                    // Reemplazar solo el tbody con los resultados
                    $('tbody').html(response);
                    // Ocultar la paginación original durante la búsqueda
                    $('.pagination-container').hide();
                },
                error: function() {
                    console.log('Error en la búsqueda');
                    $('tbody').html('<tr><td colspan="8" class="text-center text-danger">Error al realizar la búsqueda</td></tr>');
                }
            });
        }

        // Búsqueda en tiempo real mientras el usuario escribe
        $('#search-input').on('input', function() {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(function() {
                realizarBusqueda();
            }, 500); // Espera 500ms después de que el usuario deja de escribir
        });

        // Botón borrar - limpia el campo y recarga la página
        $('#borrar_contenido').click(function() {
            $('#search-input').val('');
            location.reload();
        });

        // Prevenir submit del formulario (por si alguien presiona Enter)
        $('#search-form').submit(function(event) {
            event.preventDefault();
            realizarBusqueda();
        });
    });
</script>

<?php include("../template_ingreso_cliente/pie.php") ?>