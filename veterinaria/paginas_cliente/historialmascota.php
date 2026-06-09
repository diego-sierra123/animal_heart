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
                    MIS MASCOTAS
                </h1>
            </div>

            <div id="table-container">

                <?php
                $idsocio = $_SESSION['id'];
                $registrosPorPagina = 10;

                $consultaTotalRegistros = "SELECT COUNT(*) as total FROM mascota WHERE id_cliente = $idsocio";
                $resultadoTotalRegistros = mysqli_query($conexion, $consultaTotalRegistros);
                $totalRegistros = mysqli_fetch_assoc($resultadoTotalRegistros)['total'];
                $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

                if (!isset($_GET['pagina'])) {
                    $pagina = 1;
                } else {
                    $pagina = (int)$_GET['pagina'];
                }

                $inicio = ($pagina - 1) * $registrosPorPagina;

                $consulta = "SELECT m.id_mascota, m.nombre, m.sexo, t.nombre AS tipo_mascota, r.nombre AS raza, 
                                   m.fecha_nacimiento, c.nombres AS cliente, m.fecha_registro, m.observaciones 
                            FROM mascota m
                            INNER JOIN tipo_mascota t ON m.id_tipo_mascota = t.id_tipo_mascota
                            INNER JOIN raza r ON m.id_raza = r.id_raza
                            INNER JOIN cliente c ON m.id_cliente = c.id_cliente
                            WHERE m.id_cliente = $idsocio
                            ORDER BY m.id_mascota ASC 
                            LIMIT $inicio, $registrosPorPagina";

                $ejecutar = mysqli_query($conexion, $consulta);
                ?>

                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3" style="margin-left: 0; padding-left: 0;">
                            <a href="inserthistorialmascota.php" class="btn btn-success m-2">+ Agregar Mascota</a>
                        </div>
                    </div>
                </div>

                <form id="search-form" class="search-form" style="justify-content: flex-start; margin-left: 0; padding-left: 0;">
                    <input type="text" id="search-input"
                        placeholder="Ingrese el nombre de la mascota..."
                        style="margin-left: 0; width: 500px;">
                    <button type="button" class="btn btn-secondary" id="borrar_contenido">Borrar</button>
                </form>

                <br>
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-sm text-center align-middle w-100 tabla-veterinaria" style="border: 2px solid black; font-size: 0.9rem;">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">NOMBRE</th>
                                <th scope="col">SEXO</th>
                                <th scope="col">TIPO MASCOTA</th>
                                <th scope="col">RAZA</th>
                                <th scope="col">FECHA NAC.</th>
                                <th scope="col">CLIENTE</th>
                                <th scope="col">OBSERVACIONES</th>
                                <th scope="col">HISTORIAL</th>
                                <th scope="col">ACTUALIZAR</th>
                                <th scope="col">ELIMINAR</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-body">
                            <?php
                            $contador = 0;
                            if (mysqli_num_rows($ejecutar) > 0) {
                                while ($fila = mysqli_fetch_assoc($ejecutar)) {
                                    $idre = $fila['id_mascota'];
                                    $nombre = $fila['nombre'];
                                    $sex = $fila['sexo'];
                                    $tip = $fila['tipo_mascota'];
                                    $raz = $fila['raza'];
                                    $fec = $fila['fecha_nacimiento'];
                                    $cli = $fila['cliente'];
                                    $obs = substr($fila['observaciones'], 0, 20) . (strlen($fila['observaciones']) > 20 ? '...' : '');
                            ?>
                                    <tr>
                                        <td class="align-middle"><b><?php echo ($inicio + $contador + 1); ?></b></td>
                                        <td class="align-middle"><?php echo $nombre; ?></td>
                                        <td class="align-middle"><?php echo $sex; ?></td>
                                        <td class="align-middle"><?php echo $tip; ?></td>
                                        <td class="align-middle"><?php echo $raz; ?></td>
                                        <td class="align-middle"><?php echo $fec; ?></td>
                                        <td class="align-middle"><?php echo $cli; ?></td>
                                        <td class="align-middle" title="<?php echo $fila['observaciones']; ?>"><?php echo $obs; ?></td>
                                        <td class="align-middle">
                                            <a href="historialesclinicos.php?id=<?php echo $idre; ?>" class="btn btn-warning btn-sm py-0 px-1" style="font-size: 0.7rem;">
                                                <i class="fas fa-file-medical"></i>
                                            </a>
                                        </td>
                                        <td class="align-middle">
                                            <a href="updatehistorialmascota.php?actualizar=<?php echo $idre; ?>" class="btn btn-primary btn-sm py-0 px-1" style="font-size: 0.7rem;">
                                                <i class="fas fa-sync"></i>
                                            </a>
                                        </td>
                                        <td class="align-middle">
                                            <button type="button" class="btn btn-danger btn-sm py-0 px-1" style="font-size: 0.7rem;" onclick="confirmarEliminacion(<?php echo $idre; ?>, '<?php echo addslashes($nombre); ?>')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                            <?php
                                    $contador++;
                                }
                            } else {
                                echo '<tr><td colspan="11" class="text-center">No hay mascotas registradas</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <?php
                if (isset($_GET['eliminar'])) {
                    $borrar_id = mysqli_real_escape_string($conexion, $_GET['eliminar']);
                    $puede_eliminar = true;

                    $consulta_relacionada = "SELECT id_historial_clinico FROM historial_clinico WHERE id_mascota = '$borrar_id'
                                              UNION
                                              SELECT id_cita FROM cita WHERE id_mascota = '$borrar_id'
                                              UNION
                                              SELECT id_tratamiento FROM tratamiento WHERE id_mascota = '$borrar_id'";
                    $ejecutar_relacionada = mysqli_query($conexion, $consulta_relacionada);

                    if (mysqli_num_rows($ejecutar_relacionada) > 0) {
                        $puede_eliminar = false;
                    }

                    if ($puede_eliminar) {
                        $eliminar = "DELETE FROM mascota WHERE id_mascota='$borrar_id' AND id_cliente='" . $_SESSION['id'] . "'";
                        $ejecutar_eliminar = mysqli_query($conexion, $eliminar);

                        if ($ejecutar_eliminar) {
                            echo '<script type="text/javascript">
                            Swal.fire({
                                title: "Mensaje",
                                text: "Eliminación exitosa.",
                                icon: "success",
                                showCancelButton: false,
                                confirmButtonText: "OK"
                            }).then(function() {
                                window.location.href = "historialmascota.php";
                            });
                            </script>';
                        }
                    } else {
                        echo '<script type="text/javascript">
                        Swal.fire({
                            title: "Advertencia",
                            text: "No se puede eliminar esta mascota porque tiene historial clínico, citas o tratamientos asociados.",
                            icon: "warning",
                            showCancelButton: false,
                            confirmButtonText: "OK"
                        }).then(function() {
                            window.location.href = "historialmascota.php";
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
                            echo "<a href='historialmascota.php?pagina=$i' class='btn btn-outline-primary mx-1 my-1 $activeClass'><b>$i</b></a>";
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
    $(document).ready(function() {
        var timeoutId = null;

        function realizarBusqueda() {
            var searchTerm = $('#search-input').val();

            if (searchTerm.trim() === '') {
                // Si está vacío, recargar la página para mostrar todos los registros
                location.reload();
                return;
            }

            $.ajax({
                url: 'search_mascota.php',
                type: 'POST',
                data: {
                    search: searchTerm
                },
                success: function(response) {
                    $('#tabla-body').html(response);
                    // Ocultar la paginación durante la búsqueda
                    $('.pagination-container').hide();
                }
            });
        }

        // Búsqueda en tiempo real con delay
        $('#search-input').on('input', function() {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(function() {
                realizarBusqueda();
            }, 500); // Espera 500ms después de que el usuario deja de escribir
        });

        // Botón borrar
        $('#borrar_contenido').click(function() {
            $('#search-input').val('');
            location.reload();
        });

        // Prevenir submit del formulario
        $('#search-form').submit(function(event) {
            event.preventDefault();
            realizarBusqueda();
        });
    });

    // Función para confirmar eliminación con SweetAlert2
    function confirmarEliminacion(idMascota, nombreMascota) {
        Swal.fire({
            title: '¿Está seguro?',
            text: `¿Desea eliminar la mascota "${nombreMascota}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirigir a la URL con el parámetro de eliminación
                window.location.href = `historialmascota.php?eliminar=${idMascota}`;
            }
        });
    }
</script>

<?php include("../template_ingreso_cliente/pie.php") ?>