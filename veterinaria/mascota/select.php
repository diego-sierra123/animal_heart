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
                    MASCOTAS
                </h1>
            </div>

            <div id="table-container">

                <?php
                $query = mysqli_query($conexion, "SELECT * FROM mascota");
                $numRegistros = $query->num_rows;

                $registros = 10;
                $totalPaginas = ceil($numRegistros / $registros);

                if (!isset($_GET['pagina'])) {
                    $pagina = 1;
                } else {
                    $pagina = $_GET['pagina'];
                }

                $desde = ($pagina - 1) * $registros;

                $consulta = "SELECT m.id_mascota, m.nombre, m.sexo, 
                                    t.nombre AS tipo_mascota, 
                                    r.nombre AS raza, 
                                    m.fecha_nacimiento, 
                                    c.id_cliente, c.nombres AS cliente, 
                                    m.fecha_registro, m.observaciones 
                             FROM mascota m
                             INNER JOIN tipo_mascota t ON m.id_tipo_mascota = t.id_tipo_mascota
                             INNER JOIN raza r ON m.id_raza = r.id_raza
                             INNER JOIN cliente c ON m.id_cliente = c.id_cliente
                             ORDER BY m.id_mascota ASC 
                             LIMIT $desde,$registros";

                $ejecutar = mysqli_query($conexion, $consulta);
                ?>

                <br>
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3" style="margin-left: 0; padding-left: 0;">
                            <a href="insert.php" class="btn btn-success m-2">+ Agregar Mascota</a>
                            <a href="../tipo_mascota/select.php" class="btn btn-success m-2">Tipos Mascotas</a>
                            <a href="../raza/select.php" class="btn btn-success m-2">Razas</a>
                            <a href="../tratamiento/select.php" class="btn btn-success m-2">Tratamientos</a>
                        </div>
                    </div>
                </div>
                <br>
                <form id="search-form" class="search-form" style="justify-content: flex-start; margin-left: 0; padding-left: 0;">
                    <input type="text" id="search-input"
                        placeholder="Ingrese nom de mascota, cliente, tipo o raza..."
                        style="margin-left: 0; width: 500px;">
                    <button type="button" class="btn btn-secondary" id="limpiar_busqueda">Borrar</button>
                </form>
                <br>

                <div class="table-responsive">

                    <table class="table table-hover table-striped table-sm text-center align-middle w-100 tabla-veterinaria"
                        style="border:2px solid black; font-size:0.9rem;">

                        <thead>
                            <tr>
                                <th>ID_MASCOTA</th>
                                <th>NOMBRE</th>
                                <th>SEXO</th>
                                <th>TIPO</th>
                                <th>RAZA</th>
                                <th>F. NACIMIENTO</th>
                                <th>CLIENTE</th>
                                <th>F. REGISTRO</th>
                                <th>OBSERVACIONES</th>
                                <th>TRATAMIENTOS</th>
                                <th>HISTORIAL</th>
                                <th>ACT</th>
                                <th>ELIM</th>
                            </tr>
                        </thead>

                        <tbody id="tabla-body">

                            <?php
                            $cont = ($pagina - 1) * $registros;

                            while ($fila = mysqli_fetch_assoc($ejecutar)) {
                                $cont++;

                                $idmasc = $fila['id_mascota'];
                                $nombre = $fila['nombre'];
                                $sexo = $fila['sexo'];
                                $tipo_mascota = $fila['tipo_mascota'];
                                $raza = $fila['raza'];
                                $fecha_nac = $fila['fecha_nacimiento'];
                                $cliente = $fila['cliente'];
                                $id_cliente = $fila['id_cliente'];
                                $fecha_reg = $fila['fecha_registro'];
                                $observaciones = $fila['observaciones'];
                            ?>

                                <tr style="border:1px solid black;">
                                    <td><b><?php echo $cont ?></b></td>
                                    <td><?php echo $nombre ?></td>
                                    <td><?php echo $sexo ?></td>
                                    <td><?php echo $tipo_mascota ?></td>
                                    <td><?php echo $raza ?></td>
                                    <td><?php echo $fecha_nac ?></td>
                                    <td><?php echo $cliente ?></td>
                                    <td><?php echo $fecha_reg ?></td>
                                    <td><?php echo $observaciones ?></td>
                                    <td>
                                        <a href="../tratamiento/selectpropio.php?id=<?php echo $idmasc ?>" class="btn btn-info btn-sm">
                                            <i class="fas fa-stethoscope"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="../historial_clinico/select.php?id=<?php echo $idmasc ?>&clienteee=<?php echo $id_cliente ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-file-medical"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="update.php?actualizar=<?php echo $idmasc ?>" class="btn btn-primary btn-sm">
                                            <i class="fas fa-sync"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger btn-sm" href="select.php?eliminar=<?php echo $idmasc ?>">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>

                            <?php } ?>

                        </tbody>
                    </table>

                </div>

                <?php
                if (isset($_GET['eliminar'])) {
                    $borrar_id = $_GET['eliminar'];
                    $puede_eliminar = true;

                    // Verificar relaciones en otras tablas
                    $consulta_historial = "SELECT id_historial_clinico FROM historial_clinico WHERE id_mascota='$borrar_id'";
                    $consulta_cita = "SELECT id_cita FROM cita WHERE id_mascota='$borrar_id'";
                    $consulta_tratamiento = "SELECT id_tratamiento FROM tratamiento WHERE id_mascota='$borrar_id'";

                    $ejecutar_historial = mysqli_query($conexion, $consulta_historial);
                    $ejecutar_cita = mysqli_query($conexion, $consulta_cita);
                    $ejecutar_tratamiento = mysqli_query($conexion, $consulta_tratamiento);

                    if (
                        mysqli_num_rows($ejecutar_historial) > 0 ||
                        mysqli_num_rows($ejecutar_cita) > 0 ||
                        mysqli_num_rows($ejecutar_tratamiento) > 0
                    ) {
                        $puede_eliminar = false;
                    }

                    if ($puede_eliminar) {
                        $eliminar = "DELETE FROM mascota WHERE id_mascota='$borrar_id'";
                        $ejecutar = mysqli_query($conexion, $eliminar);

                        if ($ejecutar) {
                            echo '
                                    <script>
                                    swal({
                                        title:"Mensaje",
                                        text:"Eliminación exitosa.",
                                        icon:"success"
                                    }).then(function(){
                                        window.open("select.php","_SELF");
                                    });
                                    </script>';
                        }
                    } else {
                        echo '
                                <script>
                                swal({
                                    title:"Advertencia",
                                    text:"No se puede eliminar este registro porque está relacionado con historiales, citas o tratamientos.",
                                    icon:"warning"
                                }).then(function(){
                                    window.open("select.php","_SELF");
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
                            $active = ($pagina == $i) ? 'active' : '';
                            echo "<a href='select.php?pagina=$i' class='btn btn-outline-primary $active'><b>$i</b></a>";
                        }
                        ?>
                    </div>
                </div>

                <br><br>

            </div>
        </div>
    </div>
</div>

<!-- Script para búsqueda en tiempo real -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#search-form').submit(function(event) {
            event.preventDefault();
            var searchTerm = $('#search-input').val();

            if (searchTerm.trim() === '') {
                return;
            }

            $.ajax({
                url: 'search.php',
                type: 'POST',
                data: {
                    search: searchTerm
                },
                success: function(response) {
                    $('#tabla-body').html(response);
                }
            });
        });

        $('#limpiar_busqueda').click(function() {
            $('#search-input').val('');
            location.reload();
        });
    });
</script>

<?php include("../template_ingreso_admin/pie.php") ?>