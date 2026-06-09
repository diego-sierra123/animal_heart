<?php
if (!isset($_SESSION)) {
    session_start();
}

include("../database/conexion.php");

// FUNCIÓN PARA CONTAR (mejorada un poco)
function contar($conexion, $tabla)
{
    $sql = "SELECT COUNT(*) as total FROM $tabla";
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado) {
        $data = mysqli_fetch_assoc($resultado);
        return $data['total'];
    } else {
        return 0;
    }
}

// CONTADORES GENERALES
$totalMascotas = contar($conexion, 'mascota');
$totalCitas = contar($conexion, 'cita');
$totalClientes = contar($conexion, 'cliente');
$totalEmpleados = contar($conexion, 'empleado');
$totalProveedores = contar($conexion, 'proveedor');
$totalArticulos = contar($conexion, 'articulo');
$totalServicios = contar($conexion, 'nom_servicio');

// NUEVOS
$totalEstadoCita = contar($conexion, 'estado_cita');
$totalEstadoFactura = contar($conexion, 'estado_factura');
$totalRoles = contar($conexion, 'rol');

// NOTIFICACIONES
$sqlNotificaciones = "SELECT COUNT(*) as total FROM cita WHERE id_ver = 2";
$resultNotificaciones = mysqli_query($conexion, $sqlNotificaciones);
$dataNotificaciones = mysqli_fetch_assoc($resultNotificaciones);
$totalNotificaciones = $dataNotificaciones['total'];
?>

<nav id="sidebar">
    <div class="sidebar-header">
        <h3>
            <a href="../paginas_personal/bienvenido.php">
                <img src="../img/logo.png" alt="Animal Heart">
            </a>
            <span class="d-none d-md-inline">Personal</span>
        </h3>
        <button type="button" id="closeSidebar" class="btn-close d-md-none"
            style="position: absolute; right: 15px; top: 25px;"></button>
    </div>

    <div class="user-info text-center py-3">
        <div class="user-avatar mb-2">
            <i class="fas fa-user-circle" style="font-size: 50px;"></i>
        </div>
        <h5><?php echo $_SESSION['nombre'] ?></h5>
        <small>
            <i class="fas fa-circle" style="color: #28a745; font-size: 8px;"></i>
            <?php echo ($_SESSION["id_rol"] == 1) ? "Administrador" : "Empleado"; ?>
        </small>
    </div>

    <ul class="list-unstyled components">

        <li>
            <a href="../paginas_personal/bienvenido.php">
                <i class="fas fa-home"></i>
                <span>Inicio</span>
            </a>
        </li>

        <hr>

        <li>
            <a href="../veterinaria/select.php">
                <i class="fas fa-clinic-medical"></i>
                <span>Veterinaria</span>
            </a>
        </li>

        <!-- PERSONAS -->
        <li>
            <a href="#homeSubmenu" data-bs-toggle="collapse"
                aria-expanded="<?php echo (strpos($_SERVER['PHP_SELF'], '/proveedor/') !== false || strpos($_SERVER['PHP_SELF'], '/cliente/') !== false || strpos($_SERVER['PHP_SELF'], '/empleado/') !== false) ? 'true' : 'false'; ?>">
                <i class="fas fa-users"></i>
                <span>Personas</span>
                <i class="fas fa-chevron-down ms-auto" style="font-size: 0.8em;"></i>
            </a>

            <ul class="collapse list-unstyled <?php echo (strpos($_SERVER['PHP_SELF'], '/proveedor/') !== false || strpos($_SERVER['PHP_SELF'], '/cliente/') !== false || strpos($_SERVER['PHP_SELF'], '/empleado/') !== false) ? 'show' : ''; ?>" id="homeSubmenu">

                <li>
                    <a href="../proveedor/select.php">
                        <i class="fas fa-truck"></i> Proveedores
                        <span class="badge bg-primary"><?php echo $totalProveedores; ?></span>
                    </a>
                </li>

                <li>
                    <a href="../cliente/select.php">
                        <i class="fas fa-user"></i> Clientes
                        <span class="badge bg-primary"><?php echo $totalClientes; ?></span>
                    </a>
                </li>

                <li>
                    <a href="../empleado/select.php">
                        <i class="fas fa-user-tie"></i> Personal
                        <span class="badge bg-primary"><?php echo $totalEmpleados; ?></span>
                    </a>
                </li>

            </ul>
        </li>

        <!-- MASCOTAS -->
        <li>
            <a href="../mascota/select.php">
                <i class="fas fa-paw"></i>
                <span>Mascotas</span>
                <span class="badge bg-secondary"><?php echo $totalMascotas; ?></span>
            </a>
        </li>

        <!-- CITAS -->
        <li>
            <a href="../cita/select.php">
                <i class="far fa-calendar-alt"></i>
                <span>Citas</span>
                <span class="badge bg-warning"><?php echo $totalCitas; ?></span>
            </a>
        </li>

        <!-- SERVICIOS -->
        <li>
            <a href="../servicio/select.php">
                <i class="fas fa-hand-holding-heart"></i>
                <span>Servicios</span>
                <span class="badge bg-success"><?php echo $totalServicios; ?></span>
            </a>
        </li>

        <!-- ESTADOS -->
        <li>
            <a href="#pageSubmenu" data-bs-toggle="collapse"
                aria-expanded="<?php echo (strpos($_SERVER['PHP_SELF'], '/estado_cita/') !== false || strpos($_SERVER['PHP_SELF'], '/estado_factura/') !== false) ? 'true' : 'false'; ?>">
                <i class="fas fa-flag"></i>
                <span>Estados</span>
                <i class="fas fa-chevron-down ms-auto" style="font-size: 0.8em;"></i>
            </a>

            <ul class="collapse list-unstyled <?php echo (strpos($_SERVER['PHP_SELF'], '/estado_cita/') !== false || strpos($_SERVER['PHP_SELF'], '/estado_factura/') !== false) ? 'show' : ''; ?>" id="pageSubmenu">

                <li>
                    <a href="../estado_cita/select.php">
                        <i class="fas fa-calendar-check"></i> Estados Citas
                        <span class="badge bg-info"><?php echo $totalEstadoCita; ?></span>
                    </a>
                </li>

                <li>
                    <a href="../estado_factura/select.php">
                        <i class="fas fa-file-invoice"></i> Estados Facturas
                        <span class="badge bg-info"><?php echo $totalEstadoFactura; ?></span>
                    </a>
                </li>

            </ul>
        </li>

        <!-- ARTICULOS -->
        <li>
            <a href="../articulo/select.php">
                <i class="fas fa-box"></i>
                <span>Artículos</span>
                <span class="badge bg-dark"><?php echo $totalArticulos; ?></span>
            </a>
        </li>

        <!-- ROLES -->
        <li>
            <a href="../rol/select.php">
                <i class="fas fa-user-shield"></i>
                <span>Roles</span>
                <span class="badge bg-secondary"><?php echo $totalRoles; ?></span>
            </a>
        </li>

        <hr>

        <!-- REPORTES -->
        <li>
            <a href="../reportes/reporte.php">
                <i class="fas fa-chart-bar"></i>
                <span>Reportes</span>
            </a>
        </li>

        <hr>

        <!-- NOTIFICACIONES -->
        <li>
            <a href="../notificacion_admin/notificacion.php">
                <i class="fas fa-bell"></i>
                <span>Notificaciones</span>
                <span class="badge bg-danger"><?php echo $totalNotificaciones; ?></span>
            </a>
        </li>

    </ul>

    <div class="sidebar-footer">

        <!-- DARK / LIGHT -->
        <div class="theme-toggle">
            <span class="dark">
                <i class="fas fa-moon"></i> <span class="d-none d-md-inline">Dark</span>
            </span>
            <span class="light">
                <i class="fas fa-sun"></i> <span class="d-none d-md-inline">Light</span>
            </span>
        </div>

        <a href="../salir.php" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            <span>Cerrar Sesión</span>
        </a>
    </div>
</nav>

<div id="content">

    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container-fluid px-2 px-md-4">
            <button type="button" id="sidebarCollapse" class="btn menu-btn">
                <i class="fas fa-bars"></i>
                <span class="d-none d-sm-inline">Menú</span>
            </button>

            <a href="../paginas_personal/bienvenido.php" class="navbar-center">
                <span class="logo-text">ANIMAL HEAR</span><span class="logo-t">T</span>
            </a>
        </div>
    </nav>