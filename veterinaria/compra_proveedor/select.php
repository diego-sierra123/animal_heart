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
                    COMPRAS A PROVEEDORES
                </h1>
            </div>

            <div id="table-container">

                <?php
                $query = mysqli_query($conexion, "SELECT * FROM compra_proveedor");
                $numRegistros = $query->num_rows;
                $registros = 10;
                $totalPaginas = ceil($numRegistros / $registros);

                if (!isset($_GET['pagina'])) {
                    $pagina = 1;
                } else {
                    $pagina = $_GET['pagina'];
                }

                $desde = ($pagina - 1) * $registros;

                $consulta = "SELECT CP.id_compra_proveedor, CP.fecha, CP.valor_total, CP.foto, PR.nombre AS proveedor 
                            FROM compra_proveedor CP, proveedor PR 
                            WHERE CP.id_proveedor = PR.id_proveedor 
                            ORDER BY CP.id_compra_proveedor DESC LIMIT $desde, $registros";

                $ejecutar = mysqli_query($conexion, $consulta);
                ?>
                <br>
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3" style="margin-left: 0; padding-left: 0;">
                            <a href="insert.php" class="btn btn-success m-2">+ Agregar Registro de Compra</a>
                            <a href="../proveedor/select.php" class="btn btn-dark ms-2 m-2">Regresar a Proveedores</a>
                        </div>
                    </div>
                </div>
                <br>
                <form id="search-form" class="search-form" style="justify-content: flex-start; margin-left: 0; padding-left: 0;">
                    <input type="text" id="search-input" placeholder="Ingrese la fecha (YYYY-MM-DD)..." style="margin-left: 0;">
                    <button type="submit" class="botonn btn btn-secondary" id="borrar_contenido">Borrar</button>
                </form>
                <br>
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-sm text-center align-middle w-100 tabla-veterinaria" style="border: 2px solid black; font-size: 1rem;">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 10%;">ID_COMPRA_PROVEEDOR</th>
                                    <th scope="col" style="width: 15%;">FECHA</th>
                                    <th scope="col" style="width: 20%;">PROVEEDOR</th>
                                    <th scope="col" style="width: 15%;">VALOR TOTAL</th>
                                    <th scope="col" style="width: 20%;">COMPROBANTE</th>
                                    <th scope="col" style="width: 10%;">ACTUALIZAR</th>
                                    <th scope="col" style="width: 10%;">ELIMINAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cont = ($pagina - 1) * $registros;
                                while ($fila = mysqli_fetch_assoc($ejecutar)) {
                                    $cont++;
                                    $idCompra = $fila['id_compra_proveedor'];
                                    $fecha = date('d/m/Y', strtotime($fila['fecha']));
                                    $proveedor = $fila['proveedor'];
                                    $valor = "$" . number_format($fila['valor_total'], 0, '', ' ');
                                    $foto = $fila['foto'];
                                ?>
                                    <tr style="border: 1px solid black;">
                                        <td class="align-middle"><b><?php echo $cont; ?></b></td>
                                        <td class="align-middle"><?php echo $fecha; ?></td>
                                        <td class="align-middle"><?php echo $proveedor; ?></td>
                                        <td class="align-middle"><?php echo $valor; ?></td>
                                        <td class="align-middle">
                                            <?php if (!empty($foto) && file_exists($foto)): ?>
                                                <button type="button" class="btn btn-info btn-sm py-0 px-1" style="font-size: 0.7rem;" data-bs-toggle="modal" data-bs-target="#imageModal" data-image-src="<?php echo $foto; ?>">
                                                    <i class="fas fa-eye"></i> Ver
                                                </button>
                                            <?php else: ?>
                                                <span class="text-muted" style="font-size: 0.7rem;">Sin archivo</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle">
                                            <a href="update.php?actualizar=<?php echo $idCompra; ?>" class="btn btn-primary btn-sm py-0 px-1" style="font-size: 0.7rem;">
                                                <i class="fas fa-sync"></i>
                                            </a>
                                        </td>
                                        <td class="align-middle">
                                            <a class="btn btn-danger btn-sm py-0 px-1" href="select.php?eliminar=<?php echo $idCompra; ?>" style="font-size: 0.7rem;">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                };
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>

                <!-- Modal más grande -->
                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- modal-xl para extra grande -->
                        <div class="modal-content">
                            <div class="modal-body text-center">
                                <img src="" id="modalImage" style="width: 100%; max-width: 1000px; height: 700px; object-fit: contain; border: 1px solid #ddd; border-radius: 4px; padding: 5px;" alt="Comprobante">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                if (isset($_GET['eliminar'])) {
                    $borrar_id = $_GET['eliminar'];

                    // --- VALIDACIÓN ELIMINADA PORQUE LA TABLA 'detalle_compra' NO EXISTE ---
                    // Simplemente eliminamos el registro directamente como en tu versión original.

                    // Eliminar imagen física
                    $consulta_imagen = "SELECT foto FROM compra_proveedor WHERE id_compra_proveedor = '$borrar_id'";
                    $ejecutar_imagen = mysqli_query($conexion, $consulta_imagen);

                    if ($ejecutar_imagen && mysqli_num_rows($ejecutar_imagen) > 0) {
                        $fila_imagen = mysqli_fetch_assoc($ejecutar_imagen);
                        $imagenPath = $fila_imagen['foto'];

                        if (!empty($imagenPath) && file_exists($imagenPath)) {
                            unlink($imagenPath);
                        }
                    }

                    $eliminar = "DELETE FROM compra_proveedor WHERE id_compra_proveedor ='$borrar_id'";
                    $ejecutar = mysqli_query($conexion, $eliminar);

                    if ($ejecutar) {
                        echo '<script type="text/javascript">
                        swal({
                            title: "Mensaje",
                            text: "Eliminación exitosa.",
                            icon: "success",
                            showCancelButton: false, 
                            confirmButtonText: "OK" 
                        }).then(function() {
                            window.open("select.php", "_SELF");
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
                            echo "<a href='select.php?pagina=$i' class='btn btn-outline-primary mx-1 my-1 $activeClass'><b>$i</b></a>";
                        }
                        ?>
                    </div>
                </div>
                <br>
                <br>
            </div>

        </div>
    </div>
</div>

<?php include("../template_ingreso_admin/pie.php") ?>

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
                    $('#table-container table tbody').html(response);
                }
            });
        });

        $('#borrar_contenido').click(function() {
            location.reload();
        });

        $('#imageModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var imageSrc = button.data('image-src');
            var modal = $(this);
            modal.find('#modalImage').attr('src', imageSrc);
        });
    });
</script>