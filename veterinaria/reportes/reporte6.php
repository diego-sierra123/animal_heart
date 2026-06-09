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

            <div class="row justify-content-center mt-5">
                <div class="col-10 col-sm-8 col-md-7 col-lg-6 custom-border background-image">
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">
                        <b>GANANCIAS POR MES</b>
                    </h2>

                    <form class="row justify-content-center align-content-center g-3 mt-3" action="reportetwo6.php" method="get">
                        <br>
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Mes y Año:</label>
                            <input type="search" name="txtbuscar" placeholder="Ej: Enero 2026" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            <small class="text-light" style="text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);">Formato: Mes Año (ej: Enero 2026)</small>
                        </div>

                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 d-flex justify-content-center align-items-center gap-4 mt-4 mb-4">
                            <a href="reporte.php" class="btn btn-dark">Atrás</a>
                            <input type="submit" name="buscar" value="Consultar" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include("../template_ingreso_admin/pie.php") ?>