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

if ($_SESSION["id_rol"] == 2) {
    $_SESSION['error'] = 'sin permiso para ingresar';
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <title>Advertencia</title>
    </head>
    <body>
        <script type="text/javascript">
            swal({
                title: 'Mensaje',
                text: 'No tiene permiso para ingresar.',
                showCancelButton: false, 
                confirmButtonText: 'OK' 
            }).then(function() {
                // Redirigir después de aceptar
                window.location.href = "../paginas_personal/bienvenido.php";
            });
        </script>
    </body>
    </html>
    <?php
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
                    RAZAS
                </h1>
            </div>

            <div id="table-container">

                <?php
                $query = mysqli_query($conexion, "SELECT * FROM raza");
                $numRegistros = $query->num_rows;

                $registros = 10;
                $totalPaginas = ceil($numRegistros / $registros);

                if (!isset($_GET['pagina'])) {
                    $pagina = 1;
                } else {
                    $pagina = $_GET['pagina'];
                }

                $desde = ($pagina - 1) * $registros;

                $consulta = "SELECT r.id_raza, r.nombre, t.nombre AS tipo_mascota 
                             FROM raza r
                             INNER JOIN tipo_mascota t ON r.id_tipo_mascota = t.id_tipo_mascota
                             ORDER BY r.id_raza ASC 
                             LIMIT $desde,$registros";

                $ejecutar = mysqli_query($conexion, $consulta);
                ?>

                <br>
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3" style="margin-left: 0; padding-left: 0;">
                            <a href="insert.php" class="btn btn-success m-2">+ Agregar Raza</a>
                            <a href="../mascota/select.php" class="btn btn-dark m-2">Regresar a Mascotas</a>
                        </div>
                    </div>
                </div>
                <br>
                <form id="search-form" class="search-form" style="justify-content: flex-start; margin-left: 0; padding-left: 0;">
                    <input type="text" id="search-input"
                        placeholder="Ingrese nombre de la raza o tipo de mascota..."
                        style="margin-left: 0; width: 500px;">
                    <button type="button" class="btn btn-secondary" id="limpiar_busqueda">Borrar</button>
                </form>
                <br>

                <div class="table-responsive">

                    <table class="table table-hover table-striped table-sm text-center align-middle w-100 tabla-veterinaria"
                        style="border:2px solid black; font-size:1rem;">

                        <thead>
                            <tr>
                                <th>ID_RAZA</th>
                                <th>NOMBRE</th>
                                <th>TIPO MASCOTA</th>
                                <th>ACTUALIZAR</th>
                                <th>ELIMINAR</th>
                            </tr>
                        </thead>

                        <tbody id="tabla-body">

                            <?php
                            $cont = ($pagina - 1) * $registros;

                            while ($fila = mysqli_fetch_assoc($ejecutar)) {
                                $cont++;

                                $idraza = $fila['id_raza'];
                                $nombre = $fila['nombre'];
                                $tipo_mascota = $fila['tipo_mascota'];
                            ?>

                                <tr style="border:1px solid black;">
                                    <td><b><?php echo $cont ?></b></td>
                                    <td><?php echo $nombre ?></td>
                                    <td><?php echo $tipo_mascota ?></td>
                                    <td>
                                        <?php
                                        if ($idraza > 5) {
                                            echo '<a href="update.php?actualizar=' . $idraza . '" class="btn btn-primary btn-sm">';
                                            echo '<i class="fas fa-sync"></i>';
                                            echo '</a>';
                                        } else {
                                            echo '<span class="text-primary"><small><b>No se puede actualizar</b></small></span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($idraza > 5) {
                                            echo '<a class="btn btn-danger btn-sm" href="select.php?eliminar=' . $idraza . '">';
                                            echo '<i class="fas fa-trash"></i>';
                                            echo '</a>';
                                        } else {
                                            echo '<span class="text-danger"><small><b>No se puede eliminar</b></small></span>';
                                        }
                                        ?>
                                    </td>
                                </tr>

                            <?php } ?>

                        </tbody>
                    </table>

                </div>

                <?php
                if (isset($_GET['eliminar'])) {
                    $borrar_id = $_GET['eliminar'];
                    
                    if ($borrar_id <= 5) {
                        echo '<script>
                                swal({
                                    title:"Advertencia",
                                    text:"No se puede eliminar una raza protegida del sistema.",
                                    icon:"warning"
                                }).then(function(){
                                    window.open("select.php","_SELF");
                                });
                              </script>';
                        exit();
                    }
                    
                    $puede_eliminar = true;

                    // Verificar si la raza está siendo usada por alguna mascota
                    $consulta_relacionada = "SELECT id_mascota FROM mascota WHERE id_raza ='$borrar_id'";
                    $ejecutar_relacionada = mysqli_query($conexion, $consulta_relacionada);

                    if (mysqli_num_rows($ejecutar_relacionada) > 0) {
                        $puede_eliminar = false;
                    }

                    if ($puede_eliminar) {
                        $eliminar = "DELETE FROM raza WHERE id_raza='$borrar_id'";
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
                                    text:"No se puede eliminar este registro porque está siendo usado por una o más mascotas.",
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