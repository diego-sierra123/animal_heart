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

            <?php
            $buscado = isset($_GET['txtbuscar']) ? mysqli_real_escape_string($conexion, $_GET['txtbuscar']) : '';
            ?>

            <div class="row text-center">
                <h1 class="mt-3 text-center titulo-veterinaria">
                    MASCOTAS DEL CLIENTE: <?php echo strtoupper(htmlspecialchars($buscado)); ?>
                </h1>
            </div>

            <div id="table-container">
                <br>
                <br>
                <div class="row">
                    <div class="col-12 text-center">
                        <a href="reporte3.php" class="btn btn-dark m-2">Atrás</a>
                        <a href="pdf3.php?buscado=<?php echo urlencode($buscado); ?>" class="btn btn-danger m-2" target="_blank">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                    </div>
                </div>

                <br><br>
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-sm text-center align-middle w-100 tabla-veterinaria" style="border: 2px solid black; font-size: 0.9rem;">
                            <thead>
                                <tr class="table-dark">
                                    <th>NOMBRE DEL CLIENTE</th>
                                    <th>NOMBRE DE LA MASCOTA</th>
                                    <th>RAZA</th>
                                    <th>TIPO DE ANIMAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (empty($buscado)) {
                                    echo '<tr><td colspan="4" class="text-center align-middle">Por favor, ingrese un nombre para buscar.</td></tr>';
                                } else {
                                    $consulta_clientes = "SELECT CONCAT(nombres, ' ', apellidos) AS nombre_cliente, id_cliente
                                                         FROM cliente
                                                         WHERE CONCAT(nombres, ' ', apellidos) LIKE '%$buscado%'";
                                    $sql_clientes = mysqli_query($conexion, $consulta_clientes);

                                    $cliente_encontrado = false;
                                    $datos_encontrados = false;

                                    if (mysqli_num_rows($sql_clientes) === 0) {
                                        echo '<tr><td colspan="4" class="text-center align-middle">No se encontraron clientes con ese nombre.</td></tr>';
                                    } else {
                                        while ($cliente = mysqli_fetch_assoc($sql_clientes)) {
                                            $id_cliente = $cliente['id_cliente'];
                                            $consulta_mascotas = "SELECT m.nombre AS mascota_nombre, t.nombre AS tipo_animal, r.nombre AS raza
                                                                 FROM mascota m 
                                                                 INNER JOIN tipo_mascota t ON m.id_tipo_mascota = t.id_tipo_mascota 
                                                                 INNER JOIN raza r ON m.id_raza = r.id_raza 
                                                                 WHERE m.id_cliente = $id_cliente";
                                            $sql_mascotas = mysqli_query($conexion, $consulta_mascotas);

                                            $cantidad_mascotas = mysqli_num_rows($sql_mascotas);

                                            if ($cantidad_mascotas > 0) {
                                                $datos_encontrados = true;
                                                while ($mascota = mysqli_fetch_assoc($sql_mascotas)) {
                                                    echo '<tr style="border: 1px solid black;">';
                                                    echo '<td class="align-middle">' . htmlspecialchars($cliente['nombre_cliente']) . '</td>';
                                                    echo '<td class="align-middle">' . htmlspecialchars($mascota['mascota_nombre']) . '</td>';
                                                    echo '<td class="align-middle">' . htmlspecialchars($mascota['raza']) . '</td>';
                                                    echo '<td class="align-middle">' . htmlspecialchars($mascota['tipo_animal']) . '</td>';
                                                    echo '</tr>';
                                                }
                                            }
                                            $cliente_encontrado = true;
                                        }

                                        if ($cliente_encontrado && !$datos_encontrados) {
                                            echo '<tr><td colspan="4" class="text-center align-middle">El cliente no está vinculado a ninguna mascota.</td></tr>';
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <br>
                <br>
            </div>

        </div>
    </div>
</div>

<?php include("../template_ingreso_admin/pie.php") ?>