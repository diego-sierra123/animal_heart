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

<nav id="sidebar">
    <div class="sidebar-header">
        <h3>
            <a id="ellogo" href="../paginas_personal/bienvenido.php">
                <img src="../img/logo.png" alt="Animal Heart">
            </a>
            <span class="d-none d-md-inline">Personal</span>
            <script>
                document.getElementById('ellogo').addEventListener('click', function(e) {
                    e.preventDefault();
                    swal({
                        title: 'Mensaje',
                        text: 'Por favor, primero termine la factura.',
                        icon: 'info',
                        button: 'OK'
                    });
                });
            </script>
        </h3>
        <button type="button" id="closeSidebar" class="btn-close d-md-none" style="position: absolute; right: 15px; top: 25px; color: white;"></button>
    </div>

    <div class="user-info text-center py-3">
        <div class="user-avatar mb-2">
            <i class="fas fa-user-circle" style="font-size: 50px; color: var(--primary-color);"></i>
        </div>
        <h5 style="color: var(--text-primary); margin: 0; font-size: 1em;"><?php echo $_SESSION['nombre'] ?></h5>
        <small style="color: var(--text-secondary); font-size: 0.8em;">
            <i class="fas fa-circle" style="color: #28a745; font-size: 8px;"></i>
            <?php if ($_SESSION["id_rol"] == 1) {
                echo "Administrador";
            } else {
                echo "Empleado";
            } ?>
        </small>
    </div>

    <ul class="list-unstyled components">
        <li>
            <a id="inicio" href="../paginas_personal/bienvenido.php">
                <i class="fas fa-home"></i>
                <span>Inicio</span>
            </a>
            <script>
                document.getElementById('inicio').addEventListener('click', function(e) {
                    e.preventDefault();
                    swal({
                        title: 'Mensaje',
                        text: 'Por favor, primero termine la factura.',
                        icon: 'info',
                        button: 'OK'
                    });
                });
            </script>
        </li>

        <hr>

        <li>
            <a id="vete" href="../veterinaria/select.php">
                <i class="fas fa-clinic-medical"></i>
                <span>Veterinaria</span>
            </a>
            <script>
                document.getElementById('vete').addEventListener('click', function(e) {
                    e.preventDefault();
                    swal({
                        title: 'Mensaje',
                        text: 'Por favor, primero termine la factura.',
                        icon: 'info',
                        button: 'OK'
                    });
                });
            </script>
        </li>

        <li>
            <a href="#homeSubmenu" data-bs-toggle="collapse" aria-expanded="<?php echo (strpos($_SERVER['PHP_SELF'], '/proveedor/') !== false || strpos($_SERVER['PHP_SELF'], '/cliente/') !== false || strpos($_SERVER['PHP_SELF'], '/empleado/') !== false) ? 'true' : 'false'; ?>">
                <i class="fas fa-users"></i>
                <span>Personas</span>
                <i class="fas fa-chevron-down ms-auto" style="font-size: 0.8em;"></i>
            </a>

            <ul class="collapse list-unstyled <?php echo (strpos($_SERVER['PHP_SELF'], '/proveedor/') !== false || strpos($_SERVER['PHP_SELF'], '/cliente/') !== false || strpos($_SERVER['PHP_SELF'], '/empleado/') !== false) ? 'show' : ''; ?>" id="homeSubmenu">
                <li>
                    <a id="prove" href="../proveedor/select.php">
                        <i class="fas fa-truck"></i> Proveedores
                    </a>
                </li>
                <script>
                    document.getElementById('prove').addEventListener('click', function(e) {
                        e.preventDefault();
                        swal({
                            title: 'Mensaje',
                            text: 'Por favor, primero termine la factura.',
                            icon: 'info',
                            button: 'OK'
                        });
                    });
                </script>
                <li>
                    <a id="clien" href="../cliente/select.php">
                        <i class="fas fa-user"></i> Clientes
                    </a>
                </li>
                <script>
                    document.getElementById('clien').addEventListener('click', function(e) {
                        e.preventDefault();
                        swal({
                            title: 'Mensaje',
                            text: 'Por favor, primero termine la factura.',
                            icon: 'info',
                            button: 'OK'
                        });
                    });
                </script>
                <li>
                    <a id="emple" href="../empleado/select.php">
                        <i class="fas fa-user-tie"></i> Personal
                    </a>
                </li>
                <script>
                    document.getElementById('emple').addEventListener('click', function(e) {
                        e.preventDefault();
                        swal({
                            title: 'Mensaje',
                            text: 'Por favor, primero termine la factura.',
                            icon: 'info',
                            button: 'OK'
                        });
                    });
                </script>
            </ul>
        </li>

        <li>
            <a id="mas" href="../mascota/select.php">
                <i class="fas fa-paw"></i>
                <span>Mascotas</span>
            </a>
            <script>
                document.getElementById('mas').addEventListener('click', function(e) {
                    e.preventDefault();
                    swal({
                        title: 'Mensaje',
                        text: 'Por favor, primero termine la factura.',
                        icon: 'info',
                        button: 'OK'
                    });
                });
            </script>
        </li>

        <li>
            <a id="cita" href="../cita/select.php">
                <i class="far fa-calendar-alt"></i>
                <span>Citas</span>
            </a>
            <script>
                document.getElementById('cita').addEventListener('click', function(e) {
                    e.preventDefault();
                    swal({
                        title: 'Mensaje',
                        text: 'Por favor, primero termine la factura.',
                        icon: 'info',
                        button: 'OK'
                    });
                });
            </script>
        </li>

        <li>
            <a id="ser" href="../servicio/select.php">
                <i class="fas fa-hand-holding-heart"></i>
                <span>Servicios</span>
            </a>
            <script>
                document.getElementById('ser').addEventListener('click', function(e) {
                    e.preventDefault();
                    swal({
                        title: 'Mensaje',
                        text: 'Por favor, primero termine la factura.',
                        icon: 'info',
                        button: 'OK'
                    });
                });
            </script>
        </li>

        <li>
            <a href="#pageSubmenu" data-bs-toggle="collapse" aria-expanded="<?php echo (strpos($_SERVER['PHP_SELF'], '/estado_cita/') !== false || strpos($_SERVER['PHP_SELF'], '/estado_factura/') !== false) ? 'true' : 'false'; ?>">
                <i class="fas fa-flag"></i>
                <span>Estados</span>
                <i class="fas fa-chevron-down ms-auto" style="font-size: 0.8em;"></i>
            </a>

            <ul class="collapse list-unstyled <?php echo (strpos($_SERVER['PHP_SELF'], '/estado_cita/') !== false || strpos($_SERVER['PHP_SELF'], '/estado_factura/') !== false) ? 'show' : ''; ?>" id="pageSubmenu">
                <li>
                    <a id="est_cita" href="../estado_cita/select.php">
                        <i class="fas fa-calendar-check"></i> Estados Citas
                    </a>
                    <script>
                        document.getElementById('est_cita').addEventListener('click', function(e) {
                            e.preventDefault();
                            swal({
                                title: 'Mensaje',
                                text: 'Por favor, primero termine la factura.',
                                icon: 'info',
                                button: 'OK'
                            });
                        });
                    </script>
                </li>
                <li>
                    <a id="est_fac" href="../estado_factura/select.php">
                        <i class="fas fa-file-invoice"></i> Estados Facturas
                    </a>
                    <script>
                        document.getElementById('est_fac').addEventListener('click', function(e) {
                            e.preventDefault();
                            swal({
                                title: 'Mensaje',
                                text: 'Por favor, primero termine la factura.',
                                icon: 'info',
                                button: 'OK'
                            });
                        });
                    </script>
                </li>
            </ul>
        </li>

        <li>
            <a id="articulos" href="../articulo/select.php">
                <i class="fas fa-box"></i>
                <span>Artículos</span>
            </a>
            <script>
                document.getElementById('articulos').addEventListener('click', function(e) {
                    e.preventDefault();
                    swal({
                        title: 'Mensaje',
                        text: 'Por favor, primero termine la factura.',
                        icon: 'info',
                        button: 'OK'
                    });
                });
            </script>
        </li>

        <li>
            <a id="rol" href="../rol/select.php">
                <i class="fas fa-user-shield"></i>
                <span>Roles</span>
            </a>
            <script>
                document.getElementById('rol').addEventListener('click', function(e) {
                    e.preventDefault();
                    swal({
                        title: 'Mensaje',
                        text: 'Por favor, primero termine la factura.',
                        icon: 'info',
                        button: 'OK'
                    });
                });
            </script>
        </li>

        <hr>

        <li>
            <a id="repor" href="../reportes/reporte.php">
                <i class="fas fa-chart-bar"></i>
                <span>Reportes</span>
            </a>
            <script>
                document.getElementById('repor').addEventListener('click', function(e) {
                    e.preventDefault();
                    swal({
                        title: 'Mensaje',
                        text: 'Por favor, primero termine la factura.',
                        icon: 'info',
                        button: 'OK'
                    });
                });
            </script>
        </li>
    </ul>

    <!-- Movemos estos elementos DENTRO del flujo normal, después de la lista -->
    <div class="sidebar-footer">
        <div class="theme-toggle">
            <span class="dark">
                <i class="fas fa-moon"></i> <span class="d-none d-md-inline">Dark</span>
            </span>
            <span class="light">
                <i class="fas fa-sun"></i> <span class="d-none d-md-inline">Light</span>
            </span>
        </div>

        <a id="salir" href="../salir.php" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            <span>Cerrar Sesión</span>
        </a>

        <script>
            document.getElementById('salir').addEventListener('click', function(e) {
                e.preventDefault();
                swal({
                    title: 'Mensaje',
                    text: 'Por favor, primero termine la factura.',
                    icon: 'info',
                    button: 'OK'
                });
            });
        </script>
    </div>
</nav>

<div id="content">

    <?php
    if (!isset($_SESSION)) {
        session_start();
    }
    ?>

    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container-fluid px-2 px-md-4">
            <button type="button" id="sidebarCollapse" class="btn menu-btn">
                <i class="fas fa-bars"></i>
                <span class="d-none d-sm-inline">Menú</span>
            </button>

            <a id="titulo" href="../paginas_personal/bienvenido.php" class=" navbar-center">
                <span class="logo-text">ANIMAL HEAR</span><span class="logo-t">T</span>
            </a>

            <script>
                document.getElementById('titulo').addEventListener('click', function(e) {
                    e.preventDefault();
                    swal({
                        title: 'Mensaje',
                        text: 'Por favor, primero termine la factura.',
                        icon: 'info',
                        button: 'OK'
                    });
                });
            </script>



        </div>
    </nav>

    <div class="container-fluid container-main">
        <div class="container">
            <div class="row justify-content-center">

                <div class="row text-center">
                    <h1 id="unico" class="mt-3 text-center titulo-veterinaria">
                        DETALLE DE FACTURA
                    </h1>
                </div>

                <br>
                <br>
                <br>
                <br>
                <br>
                <br>

                <!-- Formulario para agregar artículos -->
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            <h4 class="mb-0">Agregar Artículo o Servicio</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">Tipo Artículo:</label>
                                        <select name="selecttipo" id="selecttipo" class="form-control" required>
                                            <option value="">Seleccione tipo</option>
                                            <?php
                                            $consulta = "SELECT * FROM tipo_articulo";
                                            $ejecutar = mysqli_query($conexion, $consulta);
                                            while ($res = mysqli_fetch_assoc($ejecutar)) {
                                                echo "<option value='" . $res['id_tipo_articulo'] . "'>" . $res['nombre'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">Artículo:</label>
                                        <select name="selecttratamiento" id="selecttratamiento" class="form-control" required>
                                            <option value="">Primero seleccione tipo</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label class="form-label fw-bold">Cantidad:</label>
                                        <input type="number" name="txtcantidad" class="form-control" min="1" max="10000" value="1" required>
                                    </div>

                                    <div class="col-md-2 mb-3 d-flex align-items-end">
                                        <button type="submit" name="txtinserttra" class="btn btn-success w-100">
                                            Agregar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Script para cargar artículos por tipo -->
                <script>
                    $(document).ready(function() {
                        $('#selecttipo').change(function() {
                            var tipoSeleccionado = $(this).val();

                            $.ajax({
                                url: 'obtener_articulos.php',
                                type: 'POST',
                                data: {
                                    tipo: tipoSeleccionado
                                },
                                success: function(response) {
                                    var selectArticulo = $('#selecttratamiento');
                                    selectArticulo.empty();

                                    try {
                                        var articulos = JSON.parse(response);
                                        selectArticulo.append('<option value="">Seleccione artículo</option>');

                                        articulos.forEach(function(articulo) {
                                            selectArticulo.append('<option value="' + articulo.id_articulo + '">' + articulo.nombre + ' (Stock: ' + articulo.stock + ')</option>');
                                        });
                                    } catch (e) {
                                        console.error('Error parsing JSON:', e);
                                        selectArticulo.append('<option value="">Error al cargar artículos</option>');
                                    }
                                },
                                error: function() {
                                    alert('Error al cargar los artículos');
                                }
                            });
                        });
                    });
                </script>

                <?php
                // Procesar agregar artículo
                if (isset($_POST['txtinserttra'])) {
                    $idtipo = $_POST['selecttipo'];
                    $idtratamiento = $_POST['selecttratamiento'];
                    $cantidad = $_POST['txtcantidad'];

                    if (empty($cantidad) || !is_numeric($cantidad) || $cantidad < 1) {
                        echo '<script>
                        swal({
                            title: "Error",
                            text: "Por favor, ingrese una cantidad válida.",
                            icon: "error"
                        });
                    </script>';
                    } else {
                        // Obtener información del artículo
                        $sql = "SELECT * FROM articulo WHERE id_articulo = " . $idtratamiento;
                        $ejecutar = mysqli_query($conexion, $sql);
                        $tratamiento = mysqli_fetch_assoc($ejecutar);
                        $precio = $tratamiento['valor'];
                        $idtratamientoo = $tratamiento['id_articulo'];

                        // Verificar stock
                        $consulta_stock = mysqli_query($conexion, "SELECT stock FROM articulo WHERE id_articulo = $idtratamiento");
                        $stock_actual = mysqli_fetch_assoc($consulta_stock)['stock'];

                        if ($cantidad <= $stock_actual) {
                            $total = $precio * $cantidad;

                            // Obtener ID de factura actual
                            $seleccionartfactura = "SELECT MAX(id_factura) as 'id_factura' FROM factura";
                            $ejecutar = mysqli_query($conexion, $seleccionartfactura);
                            $factura = mysqli_fetch_assoc($ejecutar);
                            $idfactura = $factura['id_factura'];

                            // Insertar en detalle temporal
                            $insertdetallet = "INSERT INTO detalle_factura_temp (id_articulo, id_factura, cantidad, valor, valor_total, id_tipo_articulo) 
                                          VALUES ($idtratamientoo, $idfactura, $cantidad, $precio, $total, $idtipo)";
                            $ejecutar = mysqli_query($conexion, $insertdetallet);

                            // Actualizar stock (excepto para servicios)
                            $idsArticulosNoDisminuirStock = [190, 191, 192, 210, 211, 212, 213, 214, 215, 216, 217, 218, 219, 220, 221];

                            if (!in_array($idtratamiento, $idsArticulosNoDisminuirStock)) {
                                $nuevo_stock = $stock_actual - $cantidad;
                                $actualizar_stock = "UPDATE articulo SET stock = $nuevo_stock WHERE id_articulo = $idtratamiento";
                                mysqli_query($conexion, $actualizar_stock);
                            }

                            echo "<script>window.location.href = 'detallefactura.php';</script>";
                        } else {
                            echo '<script>
                            swal({
                                title: "Error",
                                text: "No hay stock suficiente del artículo.",
                                icon: "error"
                            });
                        </script>';
                        }
                    }
                }
                ?>

                <!-- Tabla de artículos agregados -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Artículos o Servicios Agregados</h4>
                            <button class="btn btn-dark btn-sm" onclick="confirmarEliminacionTodos()">
                                Eliminar Todos
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-sm text-center align-middle w-100 tabla-veterinaria" style="border: 2px solid black;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ARTÍCULO/SERVICIO</th>
                                            <th>CANTIDAD</th>
                                            <th>PRECIO UNITARIO</th>
                                            <th>TOTAL</th>
                                            <th>ACCIÓN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $suma = 0;
                                        $consulta = "SELECT * FROM detalle_factura_temp";
                                        $ejecutar = mysqli_query($conexion, $consulta);

                                        $contador = 1;

                                        while ($fila = mysqli_fetch_assoc($ejecutar)) {
                                            $iddt = $fila['id_detalle_factura_temp'];
                                            $precioU = $fila['valor'];
                                            $totaldt = $fila['valor_total'];
                                            $idtratamientov = $fila['id_articulo'];
                                            $cantidad = $fila['cantidad'];

                                            // Obtener nombre del artículo
                                            $sub_sql = "SELECT nombre FROM articulo WHERE id_articulo = " . $idtratamientov;
                                            $execute = mysqli_query($conexion, $sub_sql);
                                            $tratventa = mysqli_fetch_assoc($execute);
                                        ?>
                                            <tr>
                                                <td class="align-middle"><b><?php echo $contador; ?></b></td>
                                                <td class="align-middle"><?php echo $tratventa['nombre']; ?></td>
                                                <td class="align-middle"><?php echo $cantidad; ?></td>
                                                <td class="align-middle">$<?php echo number_format($precioU, 0, ',', '.'); ?></td>
                                                <td class="align-middle">$<?php echo number_format($totaldt, 0, ',', '.'); ?></td>
                                                <td class="align-middle">
                                                    <button class="btn btn-danger btn-sm" onclick="confirmarEliminacion(<?php echo $iddt; ?>)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php
                                            $suma += $totaldt;
                                            $contador++;
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="4" class="text-end fw-bold">GRAN TOTAL:</td>
                                            <td colspan="2" class="fw-bold">$<?php echo number_format($suma, 0, ',', '.'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="col-12 mt-4">
                    <div class="d-flex justify-content-center gap-3">
                        <button type="button" id="cancelarFacturaButton" class="btn btn-danger" onclick="cancelarFactura()">
                            Cancelar Factura
                        </button>
                        <form action="detallefactura.php" method="post" class="d-inline">
                            <button type="submit" name="txtfinalizar" class="btn btn-success">
                                Finalizar Factura
                            </button>
                        </form>
                    </div>
                </div>

                <?php
                // Eliminar artículo individual
                if (isset($_GET['eliminar'])) {

                    $borrar_id = $_GET['eliminar'];

                    // Obtener datos del detalle antes de eliminar
                    $consulta = "SELECT id_articulo, cantidad 
                 FROM detalle_factura_temp 
                 WHERE id_detalle_factura_temp = '$borrar_id'";

                    $resultado = mysqli_query($conexion, $consulta);
                    $datos = mysqli_fetch_assoc($resultado);

                    $id_articulo = $datos['id_articulo'];
                    $cantidad = $datos['cantidad'];

                    // Artículos que NO modifican stock
                    $idsArticulosNoDisminuirStock = [190, 191, 192, 210, 211, 212, 213, 214, 215, 216, 217, 218, 219, 220, 221];

                    // Restaurar stock si corresponde
                    if (!in_array($id_articulo, $idsArticulosNoDisminuirStock)) {

                        $consulta_stock = "SELECT stock FROM articulo WHERE id_articulo = $id_articulo";
                        $resultado_stock = mysqli_query($conexion, $consulta_stock);
                        $stock_actual = mysqli_fetch_assoc($resultado_stock)['stock'];

                        $nuevo_stock = $stock_actual + $cantidad;

                        mysqli_query($conexion, "UPDATE articulo 
                                 SET stock = $nuevo_stock 
                                 WHERE id_articulo = $id_articulo");
                    }

                    // Eliminar el artículo del detalle
                    $eliminar = "DELETE FROM detalle_factura_temp 
                 WHERE id_detalle_factura_temp = '$borrar_id'";

                    $ejecutar = mysqli_query($conexion, $eliminar);

                    if ($ejecutar) {

                        echo '<script>
        swal({
            title: "Mensaje",
            text: "Artículo eliminado correctamente.",
            icon: "success"
        }).then(function() {
            window.location.href = "detallefactura.php";
        });
        </script>';
                    }
                }

                // Finalizar factura
                if (isset($_POST['txtfinalizar'])) {
                    $consultafac = "SELECT MAX(id_factura) AS 'id_factura' FROM factura";
                    $ejecutarconsultafac = mysqli_query($conexion, $consultafac);
                    $maxfactura = mysqli_fetch_assoc($ejecutarconsultafac);
                    $consulta1 = $maxfactura['id_factura'];

                    // Verificar si hay artículos
                    $consultaArticulos = "SELECT COUNT(*) AS 'num_articulos' FROM detalle_factura_temp WHERE id_factura = $consulta1";
                    $resultadoArticulos = mysqli_query($conexion, $consultaArticulos);
                    $numArticulos = mysqli_fetch_assoc($resultadoArticulos)['num_articulos'];

                    if ($numArticulos > 0) {
                        $sumtotal = "SELECT SUM(valor_total) AS 'valor_total' FROM detalle_factura_temp WHERE id_factura = $consulta1";
                        $ejectasumatotal = mysqli_query($conexion, $sumtotal);
                        $grantotal = mysqli_fetch_assoc($ejectasumatotal);
                        $consulta2 = $grantotal['valor_total'];

                        // Insertar en detalle_factura permanente
                        $insertfinal = "INSERT INTO detalle_factura (valor, valor_total, id_factura, id_articulo, cantidad, id_tipo_articulo) 
                                   SELECT valor, valor_total, id_factura, id_articulo, cantidad, id_tipo_articulo 
                                   FROM detalle_factura_temp WHERE id_factura = $consulta1";
                        $ejecutarfin = mysqli_query($conexion, $insertfinal);

                        if ($ejecutarfin) {
                            $updatefin = "UPDATE factura SET total_factura = $consulta2 WHERE id_factura = $consulta1";
                            mysqli_query($conexion, $updatefin);

                            $eliminacionfinal = "DELETE FROM detalle_factura_temp";
                            mysqli_query($conexion, $eliminacionfinal);

                            echo '<script>
                            swal({
                                title: "Mensaje",
                                text: "Factura realizada correctamente.",
                                icon: "success"
                            }).then(function() {
                                window.location.href = "finalizarfactura.php";
                            });
                        </script>';
                        }
                    } else {
                        echo '<script>
                        swal({
                            title: "Error",
                            text: "Debe agregar artículos o servicios para realizar la factura.",
                            icon: "error"
                        });
                    </script>';
                    }
                }
                ?>

            </div>
        </div>
    </div>

    <!-- Scripts para confirmaciones -->
    <script>
        function confirmarEliminacion(iddt) {
            swal({
                title: "Confirmación",
                text: "¿Estás seguro de eliminar este artículo?",
                icon: "warning",
                buttons: ["Cancelar", "Eliminar"],
                dangerMode: true
            }).then((confirmar) => {
                if (confirmar) {
                    window.location.href = 'detallefactura.php?eliminar=' + iddt;
                }
            });
        }

        function confirmarEliminacionTodos() {
            swal({
                title: "Confirmación",
                text: "¿Estás seguro de eliminar todos los artículos?",
                icon: "warning",
                buttons: ["Cancelar", "Eliminar"],
                dangerMode: true
            }).then((confirmar) => {
                if (confirmar) {
                    $.ajax({
                        url: 'restaurar_stock_todos.php',
                        type: 'POST',
                        success: function() {
                            window.location.href = 'detallefactura.php?eliminar_todos=1';
                        }
                    });
                }
            });
        }

        function cancelarFactura() {
            swal({
                title: "Confirmación",
                text: "¿Estás seguro de cancelar la factura? Se perderán todos los artículos agregados.",
                icon: "warning",
                buttons: ["No", "Sí, cancelar"],
                dangerMode: true
            }).then((confirmar) => {
                if (confirmar) {
                    $.ajax({
                        url: 'cancelar_factura.php',
                        type: 'POST',
                        success: function() {
                            window.location.href = '../cliente/select.php';
                        }
                    });
                }
            });
        }
    </script>

    <?php
    // Eliminar todos los artículos
    if (isset($_GET['eliminar_todos'])) {
        echo '<script>
        swal({
            title: "Mensaje",
            text: "Todos los artículos han sido eliminados.",
            icon: "success"
        }).then(function() {
            window.location.href = "detallefactura.php";
        });
    </script>';
    }
    ?>

    <?php include("../template_ingreso_admin/pie.php") ?>