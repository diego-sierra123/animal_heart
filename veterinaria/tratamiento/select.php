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
                    TRATAMIENTOS
                </h1>
            </div>

            <div id="table-container">

                <?php
                // Corregido: Eliminar la condición WHERE incorrecta y contar todos los registros excepto ID 1
                $query = mysqli_query($conexion, "SELECT * FROM tratamiento WHERE id_tratamiento ");
                $numRegistros = $query->num_rows;

                $registros = 10;
                $totalPaginas = ceil($numRegistros / $registros);

                if (!isset($_GET['pagina']) || $_GET['pagina'] < 1) {
                    $pagina = 1;
                } else {
                    $pagina = $_GET['pagina'];
                }
                
                // Asegurar que la página no exceda el total de páginas
                if ($pagina > $totalPaginas && $totalPaginas > 0) {
                    $pagina = $totalPaginas;
                }

                $desde = ($pagina - 1) * $registros;

                // CORREGIDO: Eliminar la condición WHERE t.id_tratamiento que estaba causando el problema
                $consulta = "SELECT t.id_tratamiento, t.fecha, m.nombre AS mascota, t.observaciones, t.medicamentos 
                            FROM tratamiento t
                            INNER JOIN mascota m ON t.id_mascota = m.id_mascota
                            WHERE t.id_tratamiento != 1
                            ORDER BY t.id_tratamiento DESC
                            LIMIT $desde,$registros";

                $ejecutar = mysqli_query($conexion, $consulta);
                ?>

                <br>
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3" style="margin-left: 0; padding-left: 0;">
                            <a href="insert.php" class="btn btn-success m-2">+ Agregar Tratamiento</a>
                            <a href="../mascota/select.php" class="btn btn-dark m-2">Regresar a Mascotas</a>
                        </div>
                    </div>
                </div>
                <br>
                <form id="search-form" class="search-form" style="justify-content: flex-start; margin-left: 0; padding-left: 0;">
                    <input type="text" id="search-input"
                        placeholder="Ingrese nom mascota, fecha o medicamento..."
                        style="margin-left: 0; width: 500px;">
                    <button type="button" class="btn btn-secondary" id="limpiar_busqueda">Borrar</button>
                </form>
                <br>

                <div class="table-responsive">

                    <table class="table table-hover table-striped table-sm text-center align-middle w-100 tabla-veterinaria"
                        style="border:2px solid black; font-size:0.9rem;">

                        <thead>
                            <tr>
                                <th>ID_TRATAMIENTO</th>
                                <th>MASCOTA</th>
                                <th>FECHA</th>
                                <th>MEDICAMENTOS</th>
                                <th>OBSERVACIONES</th>
                                <th>ACTUALIZAR</th>
                                <th>ELIMINAR</th>
                            </tr>
                        </thead>

                        <tbody id="tabla-body">

                            <?php
                            $cont = ($pagina - 1) * $registros;

                            while ($fila = mysqli_fetch_assoc($ejecutar)) {
                                $cont++;

                                $idtrat = $fila['id_tratamiento'];
                                $mascota = $fila['mascota'];
                                $fecha = $fila['fecha'];
                                $medicamentos = $fila['medicamentos'];
                                $observaciones = $fila['observaciones'];
                            ?>

                                <tr style="border:1px solid black;">
                                    <td><b><?php echo $cont ?></b></td>
                                    <td><?php echo $mascota ?></td>
                                    <td><?php echo $fecha ?></td>
                                    <td><?php echo $medicamentos ?></td>
                                    <td><?php echo $observaciones ?></td>
                                    <td>
                                        <a href="update.php?actualizar=<?php echo $idtrat ?>" class="btn btn-primary btn-sm">
                                            <i class="fas fa-sync"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger btn-sm" href="select.php?eliminar=<?php echo $idtrat ?>">
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
                    
                    // No permitir eliminar el tratamiento con ID 1 (posiblemente un tratamiento por defecto)
                    if ($borrar_id == 1) {
                        echo '<script>
                                swal({
                                    title:"Advertencia",
                                    text:"No se puede eliminar el tratamiento por defecto del sistema.",
                                    icon:"warning"
                                }).then(function(){
                                    window.open("select.php","_SELF");
                                });
                              </script>';
                        exit();
                    }
                    
                    $puede_eliminar = true;

                    // Verificar si el tratamiento está siendo usado en historiales clínicos
                    $consulta_relacionada = "SELECT id_historial_clinico FROM historial_clinico WHERE id_tratamiento ='$borrar_id'";
                    $ejecutar_relacionada = mysqli_query($conexion, $consulta_relacionada);

                    if (mysqli_num_rows($ejecutar_relacionada) > 0) {
                        $puede_eliminar = false;
                    }

                    if ($puede_eliminar) {
                        $eliminar = "DELETE FROM tratamiento WHERE id_tratamiento='$borrar_id'";
                        $ejecutar_eliminar = mysqli_query($conexion, $eliminar);

                        if ($ejecutar_eliminar) {
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
                                    text:"No se puede eliminar este registro porque está relacionado con historiales clínicos.",
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
            data: { search: searchTerm },
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