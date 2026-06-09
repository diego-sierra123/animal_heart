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
                    HISTORIAL DE CITAS
                </h1>
            </div>

            <div id="table-container">

                <?php
                $idsocio = $_SESSION['id'];
                $registrosPorPagina = 10;
                
                $consultaTotalRegistros = "SELECT COUNT(*) as total FROM cita WHERE id_cliente = $idsocio";
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
                             WHERE ci.id_cliente = $idsocio
                             ORDER BY ci.id_cita DESC
                             LIMIT $inicio, $registrosPorPagina";

                $ejecutar = mysqli_query($conexion, $consulta);
                ?>
                
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3" style="margin-left: 0; padding-left: 0;">
                            <a href="inserthistorialcita.php" class="btn btn-success m-2">+ Agregar Cita</a>
                            <a href="vercitas.php" class="btn btn-info m-2">Ver Citas Agendadas De Hoy</a>
                        </div>
                    </div>
                </div>
                
                <form id="search-form" class="search-form" style="justify-content: flex-start; margin-left: 0; padding-left: 0;">
                    <input type="text" id="search-input" 
                        placeholder="Buscar por fecha (YYYY-MM-DD)..."
                        style="margin-left: 0; width: 500px;">
                    <button type="button" class="btn btn-secondary" id="borrar_contenido">Borrar</button>
                </form>
                <div class="alert alert-info mt-3" style="background-color: #e3f2fd; border-left: 4px solid #0d6efd; padding: 10px 15px; width: fit-content;">
                    
                    <strong>NOTA:</strong> Se informa que las citas están disponibles únicamente en los horarios de <strong>9:00 AM a 12:00 PM</strong> y de <strong>2:00 PM a 6:00 PM</strong>. Esta condición aplica tanto para el registro como para la actualización de las citas.
                </div>
                
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
                                <th scope="col">ACTUALIZAR</th>
                                <th scope="col">CANCELAR</th>
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
                                            <?php
                                            if ($idest == 1) {
                                                echo '<a href="updatehistorialcita.php?actualizar=' . $idre . '" class="btn btn-primary btn-sm py-0 px-1" style="font-size: 0.7rem;">
                                                        <i class="fas fa-sync"></i>
                                                      </a>';
                                            } else {
                                                echo '<span class="text-muted">---</span>';
                                            }
                                            ?>
                                        </td>
                                        <td class="align-middle">
                                            <?php
                                            if ($idest == 1) {
                                                echo '<button type="button" class="btn btn-danger btn-sm py-0 px-1" style="font-size: 0.7rem;" onclick="confirmarCancelacion(' . $idre . ')">
                                                        <i class="fas fa-trash"></i>
                                                      </button>';
                                            } else {
                                                echo '<span class="text-muted">---</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                            <?php
                                    $contador++;
                                }
                            } else {
                                echo '<tr><td colspan="10" class="text-center">No hay citas registradas</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <?php
                if (isset($_GET['eliminar'])) {
                    $borrar_id = mysqli_real_escape_string($conexion, $_GET['eliminar']);
                    $eliminar = "DELETE FROM cita WHERE id_cita='$borrar_id' AND id_cliente='" . $_SESSION['id'] . "'";
                    $ejecutar_eliminar = mysqli_query($conexion, $eliminar);

                    if ($ejecutar_eliminar) {
                        echo '<script type="text/javascript">
                        Swal.fire({
                            title: "Mensaje",
                            text: "Cita cancelada exitosamente.",
                            icon: "success",
                            showCancelButton: false,
                            confirmButtonText: "OK"
                        }).then(function() {
                            window.location.href = "historialcita.php";
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
                            echo "<a href='historialcita.php?pagina=$i' class='btn btn-outline-primary mx-1 my-1 $activeClass'><b>$i</b></a>";
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
                location.reload();
                return;
            }

            $.ajax({
                url: 'search_cita.php',
                type: 'POST',
                data: {
                    search: searchTerm
                },
                success: function(response) {
                    $('#tabla-body').html(response);
                    $('.pagination-container').hide();
                }
            });
        }

        $('#search-input').on('input', function() {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(function() {
                realizarBusqueda();
            }, 500);
        });

        $('#borrar_contenido').click(function() {
            $('#search-input').val('');
            location.reload();
        });

        $('#search-form').submit(function(event) {
            event.preventDefault();
            realizarBusqueda();
        });
    });

    function confirmarCancelacion(idCita) {
        Swal.fire({
            title: '¿Está seguro?',
            text: '¿Desea cancelar esta cita?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'No',
            reverseButtons: true
            
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `historialcita.php?eliminar=${idCita}`;
            }
        });
    }
</script>

<?php include("../template_ingreso_cliente/pie.php") ?>