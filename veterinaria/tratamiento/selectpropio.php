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
                // Obtener el ID de la mascota desde la URL
                $id_mascota_filtro = isset($_GET['id']) ? mysqli_real_escape_string($conexion, $_GET['id']) : 0;

                // Obtener información de la mascota para mostrar en el título
                $infoMascota = "";
                if ($id_mascota_filtro > 0) {
                    $queryMascota = "SELECT m.nombre, c.nombres, c.apellidos 
                                     FROM mascota m 
                                     INNER JOIN cliente c ON m.id_cliente = c.id_cliente 
                                     WHERE m.id_mascota = '$id_mascota_filtro'";
                    $resultMascota = mysqli_query($conexion, $queryMascota);
                    if ($rowMascota = mysqli_fetch_assoc($resultMascota)) {
                        $infoMascota = " - " . $rowMascota['nombre'] . " (" . $rowMascota['nombres'] . " " . $rowMascota['apellidos'] . ")";
                    }
                }

                // Contar los registros filtrados por mascota
                $queryCount = "SELECT COUNT(*) as total FROM tratamiento WHERE id_mascota = '$id_mascota_filtro' AND id_tratamiento != 1";
                $resultCount = mysqli_query($conexion, $queryCount);
                $rowCount = mysqli_fetch_assoc($resultCount);
                $numRegistros = $rowCount['total'];

                $registros = 10;
                $totalPaginas = $numRegistros > 0 ? ceil($numRegistros / $registros) : 1;

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

                // Consulta filtrada por mascota
                $consulta = "SELECT t.id_tratamiento, t.fecha, m.nombre AS mascota, t.observaciones, t.medicamentos 
                            FROM tratamiento t
                            INNER JOIN mascota m ON t.id_mascota = m.id_mascota
                            WHERE t.id_mascota = '$id_mascota_filtro' 
                            AND t.id_tratamiento != 1
                            ORDER BY t.id_tratamiento DESC
                            LIMIT $desde, $registros";

                $ejecutar = mysqli_query($conexion, $consulta);
                ?>

                <br>
                <h5 class="text-center">Tratamientos para la mascota: <?php echo $infoMascota; ?></h5>
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3" style="margin-left: 0; padding-left: 0;">
                            <a href="insertpropio.php?id=<?php echo $id_mascota_filtro; ?>" class="btn btn-success m-2">+ Agregar Tratamiento</a>
                            <a href="../mascota/select.php" class="btn btn-dark m-2">Regresar a Mascotas</a>
                        </div>
                    </div>
                </div>
                
                <br>

                <div class="table-responsive">

                    <table class="table table-hover table-striped table-sm text-center align-middle w-100 tabla-veterinaria"
                        style="border:2px solid black; font-size:0.9rem;">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>MASCOTA</th>
                                <th>FECHA</th>
                                <th>MEDICAMENTOS</th>
                                <th>OBSERVACIONES</th>
                                <th>ACTUALIZAR</th>
                                <th>ELIMINAR</th>
                        </thead>

                        <tbody id="tabla-body">

                            <?php
                            $cont = ($pagina - 1) * $registros;

                            if (mysqli_num_rows($ejecutar) > 0) {
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
                                            <a href="updatepropio.php?actualizar=<?php echo $idtrat ?>&id=<?php echo $id_mascota_filtro ?>" class="btn btn-primary btn-sm">
                                                <i class="fas fa-sync"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-danger btn-sm" href="selectpropio.php?eliminar=<?php echo $idtrat ?>&id=<?php echo $id_mascota_filtro ?>">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="7" class="text-center">No hay tratamientos para esta mascota</td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>

                </div>

                <?php
                if (isset($_GET['eliminar'])) {
                    $borrar_id = mysqli_real_escape_string($conexion, $_GET['eliminar']);
                    $id_mascota_actual = mysqli_real_escape_string($conexion, $_GET['id']);

                    // Verificar si el registro existe y pertenece a la mascota
                    $verificar = "SELECT id_tratamiento FROM tratamiento WHERE id_tratamiento = '$borrar_id' AND id_mascota = '$id_mascota_actual'";
                    $resultVerificar = mysqli_query($conexion, $verificar);

                    if (mysqli_num_rows($resultVerificar) > 0) {
                        // Verificar si el tratamiento está siendo usado en historiales clínicos
                        $consulta_relacionada = "SELECT id_historial_clinico FROM historial_clinico WHERE id_tratamiento ='$borrar_id'";
                        $ejecutar_relacionada = mysqli_query($conexion, $consulta_relacionada);

                        if (mysqli_num_rows($ejecutar_relacionada) > 0) {
                            echo '
                                    <script>
                                    swal({
                                        title:"Advertencia",
                                        text:"No se puede eliminar este registro porque está relacionado con historiales clínicos.",
                                        icon:"warning"
                                    }).then(function(){
                                        window.open("selectpropio.php?id=' . $id_mascota_actual . '","_SELF");
                                    });
                                    </script>';
                        } else {
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
                                            window.open("selectpropio.php?id=' . $id_mascota_actual . '","_SELF");
                                        });
                                        </script>';
                            }
                        }
                    } else {
                        echo '
                                <script>
                                swal({
                                    title:"Advertencia",
                                    text:"No se puede eliminar este registro.",
                                    icon:"warning"
                                }).then(function(){
                                    window.open("selectpropio.php?id=' . $id_mascota_actual . '","_SELF");
                                });
                                </script>';
                    }
                }
                ?>

                <br>

                <?php if ($numRegistros > 0) { ?>
                    <div class="pagination-container">
                        <div class="pagination d-flex flex-wrap justify-content-center gap-2">
                            <?php
                            for ($i = 1; $i <= $totalPaginas; $i++) {
                                $active = ($pagina == $i) ? 'active' : '';
                                echo "<a href='selectpropio.php?id=$id_mascota_filtro&pagina=$i' class='btn btn-outline-primary $active'><b>$i</b></a>";
                            }
                            ?>
                        </div>
                    </div>
                <?php } ?>

                <br><br>

            </div>
        </div>
    </div>
</div>

<!-- Script para búsqueda en tiempo real -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php include("../template_ingreso_admin/pie.php") ?>