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
                    FACTURAS REALIZADAS
                </h1>
            </div>

            <div id="table-container">
                <?php
                // Configuración de paginación
                $query = mysqli_query($conexion, "SELECT * FROM factura");
                $numRegistros = $query->num_rows;
                $registros = 10;
                $totalPaginas = ceil($numRegistros / $registros);

                if (!isset($_GET['pagina'])) {
                    $pagina = 1;
                } else {
                    $pagina = $_GET['pagina'];
                }

                $desde = ($pagina - 1) * $registros;

                // Consulta principal con JOIN corregido
                $consulta = "SELECT f.id_factura, f.fecha, f.total_factura, 
                                   c.id_cliente, CONCAT(c.nombres, ' ', c.apellidos) AS cliente,
                                   e.id_empleado, e.nombre AS empleado, 
                                   es.id_estado_factura, es.nombre AS estado 
                            FROM factura f
                            INNER JOIN cliente c ON f.id_cliente = c.id_cliente 
                            INNER JOIN empleado e ON f.id_empleado = e.id_empleado 
                            INNER JOIN estado_factura es ON f.id_estado_factura = es.id_estado_factura 
                            ORDER BY f.id_factura DESC 
                            LIMIT $desde, $registros";

                $ejecutar = mysqli_query($conexion, $consulta);
                ?>

                <br>
                <br>

                <!-- Botón de regresar centrado correctamente -->
                <div class="row justify-content-center">
                    <div class="col-10">
                        <div class="row mb-3">
                            <div class="col-12">
                                <a href="../cliente/select.php" class="btn btn-dark m-2" style="margin-top: 10px;">
                                    Regresar a Clientes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <br>

                <!-- Formulario de búsqueda centrado correctamente -->
                <div class="row justify-content-center">
                    <div class="col-12" style="margin-left: 20px;">
                        <form id="search-form" class="search-form">
                            <input type="text" id="search-input"
                                placeholder="Ingrese el cliente, empleado o fecha..."
                                style="width: 500px;">
                            <button type="button" class="btn btn-secondary" id="borrar_contenido">Borrar</button>
                        </form>
                    </div>
                </div>

                <br>

                <!-- Tabla centrada correctamente -->
                <div class="row justify-content-center">
                    <div class="col-10">
                        <div class="table-container">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-sm text-center tabla-veterinaria" style="width: 100%; border: 2px solid black">
                                    <thead>
                                        <tr>
                                            <th>ID_FACTURA</th>
                                            <th>FECHA</th>
                                            <th>TOTAL</th>
                                            <th>CLIENTE</th>
                                            <th>EMPLEADO</th>
                                            <th>ESTADO</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cont = ($pagina - 1) * $registros;
                                        while ($fila = mysqli_fetch_assoc($ejecutar)) {
                                            $cont++;
                                            $id_factura = $fila['id_factura'];
                                            $fecha = date('d/m/Y', strtotime($fila['fecha']));
                                            $total = number_format($fila['total_factura'], 0, ',', '.');
                                            $cliente = $fila['cliente'];
                                            $empleado = $fila['empleado'];
                                            $estado = $fila['estado'];
                                            $id_cliente = $fila['id_cliente'];
                                            $id_estado = $fila['id_estado_factura'];

                                            // Determinar clase CSS según estado
                                            $estadoClase = ($id_estado == 1) ? 'badge bg-success' : 'badge bg-danger';
                                        ?>
                                            <tr style="border: 1px solid black;">
                                                <td><b><?php echo $cont; ?></b></td>
                                                <td><?php echo $fecha; ?></td>
                                                <td>$<?php echo $total; ?></td>
                                                <td><?php echo htmlspecialchars($cliente); ?></td>
                                                <td><?php echo htmlspecialchars($empleado); ?></td>
                                                <td>
                                                    <span class="<?php echo $estadoClase; ?>"><?php echo $estado; ?></span>
                                                </td>
                                                <td>
                                                    <?php if ($id_estado == 1): ?>
                                                        <button class="btn btn-warning btn-sm m-3" onclick="confirmarAnulacion(<?php echo $id_factura; ?>)" title="Anular Factura">
                                                            <i class="fas fa-ban"></i> Anular
                                                        </button>
                                                    <?php endif; ?>

                                                    <?php if ($id_estado == 2): ?>
                                                        <span class="text-muted text-danger" style="margin-right: 30px; margin-left:20px; color:#dc3545 !important;" title="Factura Anulada">
                                                            <i class="fas fa-times-circle text-danger"></i> Anulada
                                                        </span>
                                                    <?php endif; ?>

                                                    <a class="btn btn-danger btn-sm " href="pdf.php?facturar=<?php echo $id_factura; ?>&cliente=<?php echo $id_cliente; ?>&anular=<?php echo $id_estado; ?>" target="_blank" title="Ver PDF">
                                                        <i class="fas fa-file-pdf"></i> PDF
                                                    </a>


                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                // Procesar anulación de factura
                if (isset($_GET['anular'])) {
                    $borrar_id = mysqli_real_escape_string($conexion, $_GET['anular']);

                    // Verificar si la factura ya está anulada
                    $verificar = "SELECT id_estado_factura FROM factura WHERE id_factura = '$borrar_id'";
                    $resultado = mysqli_query($conexion, $verificar);
                    $factura = mysqli_fetch_assoc($resultado);

                    if ($factura['id_estado_factura'] == 1) {

                        // Iniciar transacción
                        mysqli_begin_transaction($conexion);

                        try {
                            // 1. Obtener los productos y cantidades de la factura
                            $query_detalles = "SELECT id_articulo, cantidad FROM detalle_factura WHERE id_factura = '$borrar_id'";
                            $result_detalles = mysqli_query($conexion, $query_detalles);

                            // 2. Restaurar stock de cada producto
                            while ($detalle = mysqli_fetch_assoc($result_detalles)) {
                                $id_articulo = $detalle['id_articulo'];
                                $cantidad = $detalle['cantidad'];

                                // Sumar la cantidad al stock actual
                                $update_stock = "UPDATE articulo SET stock = stock + $cantidad WHERE id_articulo = '$id_articulo'";
                                if (!mysqli_query($conexion, $update_stock)) {
                                    throw new Exception("Error al restaurar stock");
                                }
                            }

                            // 3. Anular la factura
                            $eliminar = "UPDATE factura SET id_estado_factura = 2 WHERE id_factura = '$borrar_id'";
                            if (!mysqli_query($conexion, $eliminar)) {
                                throw new Exception("Error al anular la factura");
                            }

                            // Confirmar todos los cambios
                            mysqli_commit($conexion);

                            echo '<script type="text/javascript">
                swal({
                    title: "Mensaje",
                    text: "Factura anulada y stock restaurado correctamente.",
                    icon: "success",
                    showCancelButton: false,
                    confirmButtonText: "OK"
                }).then(function() {
                    window.location.href = "finalizarfactura.php";
                });
            </script>';
                        } catch (Exception $e) {
                            // Si algo falla, revertir todo
                            mysqli_rollback($conexion);

                            echo '<script type="text/javascript">
                swal({
                    title: "Error",
                    text: "Error al anular la factura. Intente nuevamente.",
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonText: "OK"
                }).then(function() {
                    window.location.href = "finalizarfactura.php";
                });
            </script>';
                        }
                    } else {
                        echo '<script type="text/javascript">
            swal({
                title: "Advertencia",
                text: "Esta factura ya se encuentra anulada.",
                icon: "warning",
                showCancelButton: false,
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "finalizarfactura.php";
            });
        </script>';
                    }
                }
                ?>

                <br>

                <!-- Paginación centrada correctamente -->
                <div class="row justify-content-center">
                    <div class="col-10">
                        <div class="pagination-container">
                            <div class="pagination">
                                <div class="row">
                                    <div class="col">
                                        <?php
                                        for ($i = 1; $i <= $totalPaginas; $i++) {
                                            $activeClass = ($pagina == $i) ? 'active' : '';
                                            echo "<a href='finalizarfactura.php?pagina=$i' style='margin: 0 5px;'><b class='$activeClass'>$i</b></a>";
                                        }
                                        ?>
                                    </div>
                                </div>
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

<!-- Script para búsqueda -->
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
                url: 'buscar_facturas.php',
                type: 'POST',
                data: {
                    search: searchTerm
                },
                success: function(response) {
                    $('#table-container table tbody').html(response);
                },
                error: function() {
                    swal({
                        title: "Error",
                        text: "Error al realizar la búsqueda.",
                        icon: "error"
                    });
                }
            });
        });

        $('#borrar_contenido').click(function() {
            $('#search-input').val('');
            location.reload();
        });
    });

    function confirmarAnulacion(idFactura) {
        swal({
            title: "Confirmación",
            text: "¿Estás seguro de anular esta factura? Esta acción no se puede deshacer.",
            icon: "warning",
            buttons: ["Cancelar", "Anular"],
            dangerMode: true
        }).then((confirmar) => {
            if (confirmar) {
                window.location.href = 'finalizarfactura.php?anular=' + idFactura;
            }
        });
    }
</script>

<?php include("../template_ingreso_admin/pie.php") ?>