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
                    EMPLEADOS
                </h1>
            </div>

            <div id="table-container">

                <?php
                $query = mysqli_query($conexion, "SELECT * FROM empleado");
                $numRegistros = $query->num_rows;

                $registros = 10;
                $totalPaginas = ceil($numRegistros / $registros);

                if (!isset($_GET['pagina'])) {
                    $pagina = 1;
                } else {
                    $pagina = $_GET['pagina'];
                }

                $desde = ($pagina - 1) * $registros;

                $consulta = "SELECT e.id_empleado, e.nombre, e.telefono, e.ciudad, e.barrio, e.direccion, e.t_documento, e.n_documento, e.correo, r.nombre AS rol FROM empleado e INNER JOIN rol r ON e.id_rol = r.id_rol ORDER BY e.id_empleado ASC LIMIT $desde,$registros";

                $ejecutar = mysqli_query($conexion, $consulta);
                ?>

                <br>
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3" style="margin-left: 0; padding-left: 0;">
                            <a href="insert.php" class="btn btn-success m-2">+ Agregar Empleado</a>
                        </div>
                    </div>
                </div>
                <br>
                <form id="search-form" class="search-form" style="justify-content: flex-start; margin-left: 0; padding-left: 0;">
                    <input type="text" id="search-input"
                        placeholder="Ingrese el nom, doc o correo del empleado..."
                        style="margin-left: 0; width: 500px;">
                    <button type="submit" class="botonn btn btn-secondary" id="borrar_contenido">Borrar</button>
                </form>
                <br>

                <div class="table-responsive">

                    <table class="table table-hover table-striped table-sm text-center align-middle w-100 tabla-veterinaria"
                        style="border:2px solid black; font-size:1rem;">

                        <thead>
                            <tr>

                                <th>ID_EMPLEADO</th>
                                <th>NOMBRE</th>
                                <th>TELÉFONO</th>
                                <th>CIUDAD</th>
                                <th>BARRIO</th>
                                <th>DIRECCIÓN</th>
                                <th>T_DOC</th>
                                <th>N_DOC</th>
                                <th>CORREO</th>
                                <th>ROL</th>
                                <th>ACT</th>
                                <th>ELIM</th>

                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $cont = ($pagina - 1) * $registros;

                            while ($fila = mysqli_fetch_assoc($ejecutar)) {

                                $cont++;

                                $idemp = $fila['id_empleado'];
                                $nombre = $fila['nombre'];
                                $telefono = $fila['telefono'];
                                $ciudad = $fila['ciudad'];
                                $barrio = $fila['barrio'];
                                $direccion = $fila['direccion'];
                                $tdoc = $fila['t_documento'];
                                $ndoc = $fila['n_documento'];
                                $correo = $fila['correo'];
                                $rol = $fila['rol'];
                            ?>

                                <tr style="border:1px solid black;">

                                    <td><b><?php echo $cont ?></b></td>
                                    <td><?php echo $nombre ?></td>
                                    <td><?php echo $telefono ?></td>
                                    <td><?php echo $ciudad ?></td>
                                    <td><?php echo $barrio ?></td>
                                    <td><?php echo $direccion ?></td>
                                    <td><?php echo $tdoc ?></td>
                                    <td><?php echo $ndoc ?></td>
                                    <td><?php echo $correo ?></td>
                                    <td><?php echo $rol ?></td>

                                    <td>

                                        <a
                                            href="update.php?actualizar=<?php echo $idemp ?>"
                                            class="btn btn-primary btn-sm">

                                            <i class="fas fa-sync"></i>

                                        </a>

                                    </td>

                                    <td>

                                        <?php
                                        if ($idemp > 1) {

                                            echo '<a class="btn btn-danger btn-sm" href="select.php?eliminar=' . $idemp . '"> <i class="fas fa-trash"></i> </a>';

                                        } else {

                                            echo '<span class="text-danger">✗</span>';

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
                    $puede_eliminar = true;

                    $consulta_historial = "SELECT id_historial_clinico FROM historial_clinico WHERE id_empleado='$borrar_id'";

                    $consulta_factura = "SELECT id_factura FROM factura WHERE id_empleado='$borrar_id'";

                    $ejecutar_historial = mysqli_query($conexion, $consulta_historial);

                    $ejecutar_factura = mysqli_query($conexion, $consulta_factura);

                    if (

                        mysqli_num_rows($ejecutar_historial) > 0 ||
                        mysqli_num_rows($ejecutar_factura) > 0

                    ) {
                        $puede_eliminar = false;
                    }

                    if ($puede_eliminar) {

                        $eliminar =
                            "DELETE FROM empleado WHERE id_empleado='$borrar_id'";

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
                                text:"No se puede eliminar este registro porque está relacionado.",
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

                            echo "<a href='select.php?pagina=$i' class='btn btn-outline-primary $active'> <b>$i</b> </a>";
                        }

                        ?>

                    </div>
                </div>

                <br><br>

            </div>
        </div>
    </div>
</div>

<?php include("../template_ingreso_admin/pie.php") ?>