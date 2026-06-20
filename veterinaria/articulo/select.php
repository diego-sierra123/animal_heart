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
                <h1 id="unico" class="mt-3 text-center titulo-veterinaria">
                    ARTÍCULOS
                </h1>
            </div>

            <div id="table-container">

                <?php
                $query = mysqli_query($conexion, "SELECT * FROM articulo");
                $numRegistros = $query->num_rows;
                $regitros = 10;
                $totalPaginas = ceil($numRegistros / $regitros);

                if (!isset($_GET['pagina'])) {
                    $pagina = 1;
                } else {
                    $pagina = $_GET['pagina'];
                }

                $desde = ($pagina - 1) * $regitros;

                $consulta = "SELECT P.id_articulo, P.nombre, P.descripcion, P.mascota, P.marca, P.tamano_mascota, P.etapa_vida, P.valor, P.costo_conseguido, P.stock, P.fecha_vencimiento, P.foto, PR.nombre AS proveedor, T.nombre AS tipo 
                            FROM articulo P, proveedor PR, tipo_articulo T 
                            WHERE P.id_proveedor = PR.id_proveedor AND P.id_tipo_articulo = T.id_tipo_articulo 
                            ORDER BY P.id_articulo ASC LIMIT $desde, $regitros";

                $ejecutar = mysqli_query($conexion, $consulta);

                $consultaSuma = "SELECT SUM(valor * stock) AS suma_total FROM articulo WHERE NOT ((id_articulo >= 190 AND id_articulo <= 192) OR (id_articulo >= 210 AND id_articulo <= 221))";
                $ejecutarSuma = mysqli_query($conexion, $consultaSuma);
                $sumaTotal = 0;

                if ($ejecutarSuma) {
                    $filaSuma = mysqli_fetch_assoc($ejecutarSuma);
                    $sumaTotal = $filaSuma['suma_total'];
                }
                ?>
                <br>
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3" style="margin-left: 0; padding-left: 0;">
                            <a href="insert.php" class="btn btn-success m-2">+ Agregar Artículo</a>
                            <a href="../tipo_articulo/select.php" class="btn btn-success ms-2 m-2">Tipos Artículos</a>
                        </div>
                    </div>
                </div>
                <br>
                <form id="search-form" class="search-form" style="justify-content: flex-start; margin-left: 0; padding-left: 0;">
                    <input type="text" id="search-input" placeholder="Ingrese el nombre del artículo..." style="margin-left: 0;">
                    <button type="submit" class="botonn btn btn-secondary" id="borrar_contenido">Borrar</button>
                </form>
                <br>
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-sm text-center align-middle w-100 tabla-veterinaria" style="border: 2px solid black; font-size: 1rem;">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 10%;">ID_ARTICULO</th>
                                    <th scope="col" style="width: 10%;">NOMBRE</th>
                                    <th scope="col" style="width: 10%;">DESC</th>
                                    <th scope="col" style="width: 10%;">MARCA</th>
                                    <th scope="col" style="width: 10%;">MASCOTA</th>
                                    <th scope="col" style="width: 10%;">TAMAÑO</th>
                                    <th scope="col" style="width: 10%;">ETAPA</th>
                                    <th scope="col" style="width: 10%;">VALOR</th>
                                    <th scope="col" style="width: 10%;">COSTO</th>
                                    <th scope="col" style="width: 10%;">STOCK</th>
                                    <th scope="col" style="width: 10%;">FECHA</th>
                                    <th scope="col" style="width: 10%;">FOTO</th>
                                    <th scope="col" style="width: 10%;">PROV</th>
                                    <th scope="col" style="width: 10%;">TIPO</th>
                                    <th scope="col" style="width: 10%;">ACT</th>
                                    <th scope="col" style="width: 10%;">ELIM</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cont = ($pagina - 1) * $regitros;
                                while ($fila = mysqli_fetch_assoc($ejecutar)) {
                                    $cont++;
                                    $idpac = $fila['id_articulo'];
                                    $nombre = substr($fila['nombre'], 0, 15) . (strlen($fila['nombre']) > 15 ? '...' : '');
                                    $des = substr($fila['descripcion'], 0, 15) . (strlen($fila['descripcion']) > 15 ? '...' : '');
                                    $mar = substr($fila['marca'], 0, 8) . (strlen($fila['marca']) > 8 ? '...' : '');
                                    $tip = $fila['mascota'];
                                    $tam = $fila['tamano_mascota'];
                                    $eta = $fila['etapa_vida'];
                                    $valor = "$" . number_format($fila['valor'], 0, ',', '.');
                                    $costo = "$" . number_format($fila['costo_conseguido'], 0, ',', '.');
                                    $stock = ($idpac >= 190 && $idpac <= 192) || ($idpac >= 210 && $idpac <= 221) ? "No stock" : $fila['stock'];
                                    $fecha = !empty($fila['fecha_vencimiento']) ? date('d/m/y', strtotime($fila['fecha_vencimiento'])) : '';
                                    $foto = $fila['foto'];
                                    $prove = substr($fila['proveedor'], 0, 10) . (strlen($fila['proveedor']) > 10 ? '...' : '');
                                    $tipo = substr($fila['tipo'], 0, 8) . (strlen($fila['tipo']) > 8 ? '...' : '');
                                ?>
                                    <tr style="border: 1px solid black;">
                                        <td class="align-middle"><b><?php echo $cont; ?></b></td>
                                        <td class="align-middle" title="<?php echo $fila['nombre']; ?>"><?php echo $nombre; ?></td>
                                        <td class="align-middle" title="<?php echo $fila['descripcion']; ?>"><?php echo $des; ?></td>
                                        <td class="align-middle" title="<?php echo $fila['marca']; ?>"><?php echo $mar; ?></td>
                                        <td class="align-middle"><?php echo $tip; ?></td>
                                        <td class="align-middle"><?php echo $tam; ?></td>
                                        <td class="align-middle"><?php echo $eta; ?></td>
                                        <td class="align-middle"><?php echo $valor; ?></td>
                                        <td class="align-middle"><?php echo $costo; ?></td>
                                        <td class="align-middle"><?php echo $stock; ?></td>
                                        <td class="align-middle"><?php echo ($fecha == '01/01/70' || $fecha == '31/12/69' || $fecha == '') ? '00/00/00' : $fecha; ?></td>
                                        <td class="align-middle">
                                            <img width="40px" height="40px" src="<?php echo $foto; ?>" class="img-fluid rounded" style="object-fit: cover;">
                                        </td>
                                        <td class="align-middle" title="<?php echo $fila['proveedor']; ?>"><?php echo $prove; ?></td>
                                        <td class="align-middle" title="<?php echo $fila['tipo']; ?>"><?php echo $tipo; ?></td>
                                        <td class="align-middle">
                                            <a href="update.php?actualizar=<?php echo $idpac; ?>" class="btn btn-primary btn-sm py-0 px-1" style="font-size: 0.7rem;">
                                                <i class="fas fa-sync"></i>
                                            </a>
                                        </td>
                                        <td class="align-middle">
                                            <?php
                                            if ($idpac > 221) {
                                                echo '<a class="btn btn-danger btn-sm py-0 px-1" href="select.php?eliminar=' . $idpac . '" style="font-size: 0.7rem;">
                                    <i class="fas fa-trash"></i>
                                  </a>';
                                            } else {
                                                echo '<span class="text-danger" style="font-size: 0.7rem;">✗</span>';
                                            }
                                            ?>
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
                <div class="text-center mt-3">
                    <h3><strong class="inventory-value">Valor total del inventario: $<?php echo number_format($sumaTotal, 0, ',', '.'); ?></strong></h3>
                </div>

                <?php
                if (isset($_GET['eliminar'])) {
                    $borrar_id = $_GET['eliminar'];
                    $puede_eliminar = true;

                    $consulta_relacionada_empleado = "SELECT id_detalle_factura FROM detalle_factura WHERE id_articulo='$borrar_id'";
                    $ejecutar_relacionada_empleado = mysqli_query($conexion, $consulta_relacionada_empleado);

                    $consulta_relacionada_otra_tabla = "SELECT id_detalle_factura_temp FROM detalle_factura_temp WHERE id_articulo ='$borrar_id'";
                    $ejecutar_relacionada_otra_tabla = mysqli_query($conexion, $consulta_relacionada_otra_tabla);

                    if (
                        ($ejecutar_relacionada_empleado && mysqli_num_rows($ejecutar_relacionada_empleado) > 0) ||
                        ($ejecutar_relacionada_otra_tabla && mysqli_num_rows($ejecutar_relacionada_otra_tabla) > 0)
                    ) {
                        $puede_eliminar = false;
                    }

                    if ($puede_eliminar) {

                        // Eliminar imagen física
                        $consulta_imagen = "SELECT foto FROM articulo WHERE id_articulo = '$borrar_id'";
                        $ejecutar_imagen = mysqli_query($conexion, $consulta_imagen);
                        $fila_imagen = mysqli_fetch_assoc($ejecutar_imagen);
                        $imagenPath = $fila_imagen['foto'];

                        if (!empty($imagenPath) && file_exists($imagenPath)) {
                            unlink($imagenPath);
                        }

                        $eliminar = "DELETE FROM articulo WHERE id_articulo ='$borrar_id'";
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
                    } else {
                        echo '<script type="text/javascript">
                        swal({
                            title: "Advertencia",
                            text: "No se puede eliminar este registro porque está relacionado con otros registros de alguna otra página.",
                            icon: "warning",
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
                    $('#table-container table').html(response);
                }
            });
        });

        $('#borrar_contenido').click(function() {
            location.reload();
        });
    });
</script>