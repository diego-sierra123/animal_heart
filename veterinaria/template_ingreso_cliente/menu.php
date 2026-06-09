<?php
if (!isset($_SESSION)) {
    session_start();
}

include("../database/conexion.php");

// FUNCIÓN CONTAR
function contarCliente($conexion, $tabla, $condicion)
{
    $sql = "SELECT COUNT(*) as total FROM $tabla WHERE $condicion";
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado) {
        $data = mysqli_fetch_assoc($resultado);
        return $data['total'];
    } else {
        return 0;
    }
}

$idCliente = $_SESSION['id'];

// CONTADORES DINÁMICOS
$totalMascotas = contarCliente($conexion, 'mascota', "id_cliente = $idCliente");
$totalCitas = contarCliente($conexion, 'cita', "id_cliente = $idCliente");
$totalFacturas = contarCliente($conexion, 'factura', "id_cliente = $idCliente");

// 🔔 NOTIFICACIONES (IMPORTANTE: id_ver = 1 como en tu sistema)
$totalNotificaciones = contarCliente($conexion, 'cita', "id_cliente = $idCliente AND id_ver = 1");
?>

<nav id="sidebar">
    <div class="sidebar-header">
        <h3>
            <a href="../paginas_cliente/bienvenido.php">
                <img src="../img/logo.png" alt="Animal Heart">
            </a>
            <span class="d-none d-md-inline">Animal Heart</span>
        </h3>
        <button type="button" id="closeSidebar" class="btn-close d-md-none"
            style="position: absolute; right: 15px; top: 25px; color: white;"></button>
    </div>

    <div class="user-info text-center py-3">
        <div class="user-avatar mb-2">
            <i class="fas fa-user-circle" style="font-size: 50px; color: var(--primary-color);"></i>
        </div>
        <h5 style="color: var(--text-primary); margin: 0; font-size: 1em;">
            <?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ?>
        </h5>
        <small style="color: var(--text-secondary); font-size: 0.8em;">
            <i class="fas fa-circle" style="color: #28a745; font-size: 8px;"></i> Cliente
        </small>
    </div>

    <ul class="list-unstyled components">

        <li>
            <a href="../paginas_cliente/bienvenido.php">
                <i class="fas fa-home"></i>
                <span>Inicio</span>
            </a>
        </li>

        <hr>

        <!-- MASCOTAS -->
        <li>
            <a href="../paginas_cliente/historialmascota.php">
                <i class="fas fa-paw"></i>
                <span>Mis Mascotas</span>
                <span class="badge bg-danger"><?php echo $totalMascotas; ?></span>
            </a>
        </li>

        <!-- CITAS -->
        <li>
            <a href="../paginas_cliente/historialcita.php">
                <i class="far fa-calendar-alt"></i>
                <span>Citas</span>
                <span class="badge bg-warning"><?php echo $totalCitas; ?></span>
            </a>
        </li>

        <!-- FACTURAS -->
        <li>
            <a href="../paginas_cliente/historialfactura.php">
                <i class="fas fa-file-invoice"></i>
                <span>Facturas</span>
                <span class="badge bg-info"><?php echo $totalFacturas; ?></span>
            </a>
        </li>

        <hr>

        <!-- PERFIL -->
        <li>
            <a href="../paginas_cliente/perfil.php?persona=<?php echo $_SESSION['id']; ?>">
                <i class="fas fa-user-cog"></i>
                <span>Mi Perfil</span>
            </a>
        </li>


        <hr>

        <!-- NOTIFICACIONES -->
        <li>
            <a href="../notificacion_cliente/notificacion.php">
                <i class="fas fa-bell"></i>
                <span>Notificaciones</span>
                <span class="badge bg-danger"><?php echo $totalNotificaciones; ?></span>
            </a>
        </li>

    </ul>

    <!-- FOOTER (SIN CAMBIOS) -->
    <div class="sidebar-footer">
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

        <a href="../paginas_cliente/bienvenido.php" class="navbar-center">
            <span class="logo-text">ANIMAL HEAR</span><span class="logo-t">T</span>
        </a>
    </div>
</nav>