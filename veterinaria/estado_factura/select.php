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
                <h1 id="unico" class="mt-3 text-center titulo-veterinaria">
                    ESTADOS FACTURAS
                </h1>
            </div>

            <div id="table-container">

                <?php
                $query = mysqli_query($conexion, "SELECT * FROM estado_factura");
                $numRegistros = $query->num_rows;
                $regitros = 10;
                $totalPaginas = ceil($numRegistros / $regitros);

                if (!isset($_GET['pagina'])) {
                    $pagina = 1;
                } else {
                    $pagina = $_GET['pagina'];
                }

                $desde = ($pagina - 1) * $regitros;

                $consulta = "SELECT id_estado_factura, nombre FROM estado_factura  ORDER BY id_estado_factura ASC LIMIT $desde, $regitros";

                $ejecutar = mysqli_query($conexion, $consulta);
                ?>
                <br>
                <br>
                <br>
                <form id="search-form" class="search-form">
                    <input type="text" id="search-input" placeholder="Ingrese el nombre del estado de la factura...">
                    <button type="submit" class="botonn btn btn-secondary" id="borrar_contenido">Borrar</button>
                </form>
                <br>
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-sm text-center tabla-veterinaria" style="width: 85%; margin: 0 auto; border: 2px solid black">
                            <tr>
                                <th> ID_ESTADO_FACTURA </th>
                                <th> NOMBRE </th>
                                <th> ACTUALIZAR </th>
                                <th> ELIMINAR </th>
                            </tr>
                            <?php
                            $cont = ($pagina - 1) * $regitros;
                            while ($fila = mysqli_fetch_assoc($ejecutar)) {
                                $cont++;
                                $idpac = $fila['id_estado_factura'];
                                $nombre = $fila['nombre'];
                            ?>
                                <tr style="border: 1px solid black;">
                                    <td><b><?php echo $cont; ?></b></td>
                                    <td><?php echo $nombre; ?></td>
                                     <td>
                                        <?php if ($idpac > 2) {  ?>
                                            <a href="update.php?actualizar=<?php echo $idpac; ?>" class="btn btn-primary"> <i class="fas fa-sync" style="margin-right: 8px;"></i>Actualizar</a>
                                        <?php
                                        } else {
                                            echo '<p class=text-primary><b> No se puede actuzalizar</b></p>';
                                        } ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($idpac > 2) {
                                            echo '<a class="btn btn-danger" href="select.php?eliminar=' . $idpac . '"><i class="fas fa-trash" style="margin-right: 8px;"></i> Eliminar</a>';
                                        } else {
                                            echo '<p class=text-danger><b> No se puede eliminar</b></p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php
                            };
                            ?>
                        </table>
                    </div>
                </div>
                <?php
                if (isset($_GET['eliminar'])) {
                    $borrar_id = $_GET['eliminar'];
                    $puede_eliminar = true;

                    $consulta_relacionada = "SELECT id_factura FROM factura WHERE id_estado_factura='$borrar_id'";
                    $ejecutar_relacionada = mysqli_query($conexion, $consulta_relacionada);

                    if (
                        ($ejecutar_relacionada && mysqli_num_rows($ejecutar_relacionada) > 0)
                    ) {
                        $puede_eliminar = false;
                    }

                    if ($puede_eliminar) {
                        $eliminar = "DELETE FROM estado_factura WHERE id_estado_factura='$borrar_id'";
                        $ejecutar = mysqli_query($conexion, $eliminar);

                        if ($ejecutar) {
                            echo '<script type="text/javascript">
                swal({
                    title: \'Mensaje\',
                    text: \'Eliminación exitosa.\',
                    icon: \'success\',
                    showCancelButton: false, 
                    confirmButtonText: \'OK\' 
                }).then(function() {
                    window.open("select.php", "_SELF");
                });
            </script>';
                        }
                    } else {
                        echo '<script type="text/javascript">
            swal({
                title: \'Advertencia\',
                text: \'No se puede eliminar este registro porque está relacionado con otros registros de alguna otra página.\',
                icon: \'warning\',
                showCancelButton: false, 
                confirmButtonText: \'OK\' 
            }).then(function() {
                window.open("select.php", "_SELF");
            });
        </script>';
                    }
                }
                ?>
                <br>
                <div class="pagination-container">
                    <div class="pagination">
                        <div class="row">
                            <div class="col">
                                <?php
                                for ($i = 1; $i <= $totalPaginas; $i++) {
                                    echo "<a href='select.php?pagina=$i'><b>$i</b></a> ";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
            </div>


        </div>
    </div>
</div>

<?php include("../template_ingreso_admin/pie.php") ?>