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
                    CLIENTES
                </h1>
            </div>

            <div id="table-container">

                <?php
                $query = mysqli_query($conexion, "SELECT * FROM cliente");
                $numRegistros = $query->num_rows;
                $registros = 10;
                $totalPaginas = ceil($numRegistros / $registros);

                if (!isset($_GET['pagina'])) {
                    $pagina = 1;
                } else {
                    $pagina = $_GET['pagina'];
                }

                $desde = ($pagina - 1) * $registros;

                $consulta = "SELECT c.id_cliente, c.nombres, c.apellidos, c.telefono, c.ciudad, c.barrio, 
                                   c.direccion, c.t_documento, c.n_documento, c.correo, r.nombre AS rol 
                            FROM cliente c, rol r  
                            WHERE c.id_rol = r.id_rol 
                            ORDER BY c.id_cliente ASC 
                            LIMIT $desde, $registros";

                $ejecutar = mysqli_query($conexion, $consulta);
                ?>
                <br>
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3" style="margin-left: 0; padding-left: 0;">
                            <a href="insert.php" class="btn btn-success m-2">+ Agregar Cliente</a>
                            <a href="../facturacion/finalizarfactura.php" class="btn btn-success ms-2 m-2">Facturas realizadas</a>
                        </div>
                    </div>
                </div>
                <br>
                <form id="search-form" class="search-form" style="justify-content: flex-start; margin-left: 0; padding-left: 0;">
                    <input type="text" id="search-input"
                        placeholder="Ingrese nom, ape o num doc del cliente..."
                        style="margin-left: 0; width: 500px;">
                    <button type="submit" class="botonn btn btn-secondary" id="borrar_contenido">Borrar</button>
                </form>
                <br>
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-sm text-center align-middle w-100 tabla-veterinaria" style="border: 2px solid black; font-size: 1rem;">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 5%;">ID_CLIENTE</th>
                                    <th scope="col" style="width: 8%;">NOMBRES</th>
                                    <th scope="col" style="width: 8%;">APELLIDOS</th>
                                    <th scope="col" style="width: 8%;">TELÉFONO</th>
                                    <th scope="col" style="width: 8%;">CIUDAD</th>
                                    <th scope="col" style="width: 8%;">BARRIO</th>
                                    <th scope="col" style="width: 10%;">DIRECCIÓN</th>
                                    <th scope="col" style="width: 5%;">T_DOC</th>
                                    <th scope="col" style="width: 8%;">N_DOCUMENTO</th>
                                    <th scope="col" style="width: 12%;">CORREO</th>
                                    <th scope="col" style="width: 8%;">FACTURAR</th>
                                    <th scope="col" style="width: 6%;">ACT</th>
                                    <th scope="col" style="width: 6%;">ELIM</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cont = ($pagina - 1) * $registros;
                                while ($fila = mysqli_fetch_assoc($ejecutar)) {
                                    $cont++;
                                    $idpac = $fila['id_cliente'];
                                    $nombre = substr($fila['nombres'], 0, 15) . (strlen($fila['nombres']) > 15 ? '...' : '');
                                    $ape = substr($fila['apellidos'], 0, 15) . (strlen($fila['apellidos']) > 15 ? '...' : '');
                                    $tel = $fila['telefono'];
                                    $ciu = substr($fila['ciudad'], 0, 10) . (strlen($fila['ciudad']) > 10 ? '...' : '');
                                    $bar = substr($fila['barrio'], 0, 10) . (strlen($fila['barrio']) > 10 ? '...' : '');
                                    $dir = substr($fila['direccion'], 0, 15) . (strlen($fila['direccion']) > 15 ? '...' : '');
                                    $tdoc = $fila['t_documento'];
                                    $ndoc = substr($fila['n_documento'], 0, 12) . (strlen($fila['n_documento']) > 12 ? '...' : '');
                                    $cor = substr($fila['correo'], 0, 15) . (strlen($fila['correo']) > 15 ? '...' : '');
                                ?>
                                    <tr style="border: 1px solid black;">
                                        <td class="align-middle"><b><?php echo $cont; ?></b></td>
                                        <td class="align-middle" title="<?php echo $fila['nombres']; ?>"><?php echo $nombre; ?></td>
                                        <td class="align-middle" title="<?php echo $fila['apellidos']; ?>"><?php echo $ape; ?></td>
                                        <td class="align-middle"><?php echo $tel; ?></td>
                                        <td class="align-middle" title="<?php echo $fila['ciudad']; ?>"><?php echo $ciu; ?></td>
                                        <td class="align-middle" title="<?php echo $fila['barrio']; ?>"><?php echo $bar; ?></td>
                                        <td class="align-middle" title="<?php echo $fila['direccion']; ?>"><?php echo $dir; ?></td>
                                        <td class="align-middle"><?php echo $tdoc; ?></td>
                                        <td class="align-middle" title="<?php echo $fila['n_documento']; ?>"><?php echo $ndoc; ?></td>
                                        <td class="align-middle" title="<?php echo $fila['correo']; ?>"><?php echo $cor; ?></td>
                                        <td class="align-middle">
                                            <a class="btn btn-secondary btn-sm py-0 px-1" href="../facturacion/factura.php?facturar=<?php echo $idpac; ?>" style="font-size: 0.7rem;">
                                                <i class="fas fa-file-invoice"></i>
                                            </a>
                                        </td>
                                        <td class="align-middle">
                                            <a href="update.php?actualizar=<?php echo $idpac; ?>" class="btn btn-primary btn-sm py-0 px-1" style="font-size: 0.7rem;">
                                                <i class="fas fa-sync"></i>
                                            </a>
                                        </td>
                                        <td class="align-middle">
                                            <?php
                                            // Verificar si el cliente tiene facturas o mascotas asociadas
                                            $consulta_relacionada = "SELECT id_factura FROM factura WHERE id_cliente='$idpac' 
                                                                      UNION 
                                                                      SELECT id_mascota FROM mascota WHERE id_cliente='$idpac'";
                                            $ejecutar_relacionada = mysqli_query($conexion, $consulta_relacionada);

                                            if (mysqli_num_rows($ejecutar_relacionada) > 0) {
                                                echo '<span class="text-danger" style="font-size: 0.7rem;">✗</span>';
                                            } else {
                                                echo '<a class="btn btn-danger btn-sm py-0 px-1" href="select.php?eliminar=' . $idpac . '" style="font-size: 0.7rem;">
                                                        <i class="fas fa-trash"></i>
                                                      </a>';
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

                <?php
                if (isset($_GET['eliminar'])) {
                    $borrar_id = mysqli_real_escape_string($conexion, $_GET['eliminar']);
                    $puede_eliminar = true;

                    // Verificar si el cliente tiene facturas o mascotas asociadas
                    $consulta_relacionada = "SELECT id_factura FROM factura WHERE id_cliente='$borrar_id' 
                                              UNION 
                                              SELECT id_mascota FROM mascota WHERE id_cliente='$borrar_id'";
                    $ejecutar_relacionada = mysqli_query($conexion, $consulta_relacionada);

                    if ($ejecutar_relacionada && mysqli_num_rows($ejecutar_relacionada) > 0) {
                        $puede_eliminar = false;
                    }

                    if ($puede_eliminar) {
                        $eliminar = "DELETE FROM cliente WHERE id_cliente='$borrar_id'";
                        $ejecutar_eliminar = mysqli_query($conexion, $eliminar);

                        if ($ejecutar_eliminar) {
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
                            text: "No se puede eliminar este cliente porque tiene facturas o mascotas asociadas.",
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
                    $('#table-container table').html(response);
                }
            });
        });

        $('#borrar_contenido').click(function() {
            $('#search-input').val('');
            location.reload();
        });
    });
</script>

<?php include("../template_ingreso_admin/pie.php") ?>