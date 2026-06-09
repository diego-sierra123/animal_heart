<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION["id_rol"] != 3) {
    header("Location: ../login.php");
    exit();
}
?>

<?php include("../database/conexion.php") ?>

<?php include("../template_ingreso_cliente/cabecera.php") ?>

<!-- SweetAlert2 CSS y JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php include("../template_ingreso_cliente/menu.php") ?>

<div class="container-fluid container-main">
    <div class="container">
        <div class="row justify-content-center">

            <div class="row text-center">
                <h1 class="mt-3 text-center titulo-veterinaria">
                    HISTORIAL DE FACTURAS
                </h1>
            </div>

            <div id="table-container">

                <?php
                $idsocio = $_SESSION['id'];
                $registrosPorPagina = 10;
                
                $consultaTotalRegistros = "SELECT COUNT(*) as total FROM factura WHERE id_cliente = $idsocio";
                $resultadoTotalRegistros = mysqli_query($conexion, $consultaTotalRegistros);
                $totalRegistros = mysqli_fetch_assoc($resultadoTotalRegistros)['total'];
                $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

                if (!isset($_GET['pagina'])) {
                    $pagina = 1;
                } else {
                    $pagina = (int)$_GET['pagina'];
                }

                $inicio = ($pagina - 1) * $registrosPorPagina;

                $consulta = "SELECT f.*, CONCAT(c.nombres,' ',c.apellidos) AS nombrecliente 
                             FROM factura f
                             INNER JOIN cliente c ON f.id_cliente = c.id_cliente
                             WHERE f.id_cliente = $idsocio
                             ORDER BY f.id_factura DESC
                             LIMIT $inicio, $registrosPorPagina";

                $ejecutar = mysqli_query($conexion, $consulta);
                ?>
                
                <br>

                <form id="search-form" class="search-form" style="justify-content: flex-start; margin-left: 0; padding-left: 0;">
                    <input type="text" id="search-input" 
                        placeholder="Buscar por fecha (YYYY-MM-DD)..."
                        style="margin-left: 0; width: 500px;">
                    <button type="button" class="btn btn-secondary" id="borrar_contenido">Borrar</button>
                </form>
                
                <br>
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-sm text-center align-middle w-100 tabla-veterinaria" style="border: 2px solid black; font-size: 0.9rem;">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">FECHA</th>
                                <th scope="col">CLIENTE</th>
                                <th scope="col">TOTAL</th>
                                <th scope="col">ESTADO</th>
                                <th scope="col">FACTURA</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-body">
                            <?php
                            $contador = 0;
                            if (mysqli_num_rows($ejecutar) > 0) {
                                while ($fila = mysqli_fetch_assoc($ejecutar)) {
                                    $idre = $fila['id_factura'];
                                    $fh = $fila["fecha"];
                                    $tl = $fila["total_factura"];
                                    $idest = $fila["id_estado_factura"];
                                    $cliente = $fila["nombrecliente"];
                                    
                                    if ($idest == 1) {
                                        $esta = '<span class="badge bg-success">PAGADO</span>';
                                    } elseif ($idest == 2) {
                                        $esta = '<span class="badge bg-danger">ANULADO</span>';
                                    } else {
                                        $esta = '<span class="badge bg-warning text-dark">NO PAGADO</span>';
                                    }
                            ?>
                                    <tr>
                                        <td class="align-middle"><b><?php echo ($inicio + $contador + 1); ?></b></td>
                                        <td class="align-middle"><?php echo $fh; ?></td>
                                        <td class="align-middle"><?php echo $cliente; ?></td>
                                        <td class="align-middle">$<?php echo number_format($tl, 0, ',', '.'); ?></td>
                                        <td class="align-middle"><?php echo $esta; ?></td>
                                        <td class="align-middle">
                                            <a class="btn btn-danger btn-sm" href="../facturacion/pdf.php?facturar=<?php echo $idre ?>&cliente=<?php echo $idsocio; ?>&anular=<?php echo $idest; ?>" target="_blank">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </a>
                                        </td>
                                    </tr>
                            <?php
                                    $contador++;
                                }
                            } else {
                                echo '<tr><td colspan="6" class="text-center">No hay facturas registradas</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <br>
                <div class="pagination-container">
                    <div class="pagination d-flex flex-wrap justify-content-center gap-2">
                        <?php
                        for ($i = 1; $i <= $totalPaginas; $i++) {
                            $activeClass = ($pagina == $i) ? 'active' : '';
                            echo "<a href='historialfactura.php?pagina=$i' class='btn btn-outline-primary mx-1 my-1 $activeClass'><b>$i</b></a>";
                        }
                        ?>
                    </div>
                </div>
                <br>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var timeoutId = null;

        function realizarBusqueda() {
            var searchTerm = $('#search-input').val();

            if (searchTerm.trim() === '') {
                location.reload();
                return;
            }

            $.ajax({
                url: 'search_factura.php',
                type: 'POST',
                data: {
                    search: searchTerm
                },
                success: function(response) {
                    $('#tabla-body').html(response);
                    $('.pagination-container').hide();
                }
            });
        }

        $('#search-input').on('input', function() {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(function() {
                realizarBusqueda();
            }, 500);
        });

        $('#borrar_contenido').click(function() {
            $('#search-input').val('');
            location.reload();
        });

        $('#search-form').submit(function(event) {
            event.preventDefault();
            realizarBusqueda();
        });
    });
</script>

<?php include("../template_ingreso_cliente/pie.php") ?>