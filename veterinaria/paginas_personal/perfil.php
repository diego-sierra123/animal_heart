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

<?php
$id_empleado = isset($_GET['persona']) ? mysqli_real_escape_string($conexion, $_GET['persona']) : $_SESSION['id'];

$consulta = "SELECT e.*, r.nombre as nombre_rol 
             FROM empleado e 
             INNER JOIN rol r ON e.id_rol = r.id_rol 
             WHERE e.id_empleado = '$id_empleado'";
$ejecutar = mysqli_query($conexion, $consulta);
$empleado = mysqli_fetch_assoc($ejecutar);

if (!$empleado) {
    header("Location: select.php");
    exit();
}
?>

<div class="container-fluid container-main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="row justify-content-center mt-5">
                <div class="col-10 col-sm-8 col-md-7 col-lg-6 custom-border background-image">
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>PERFIL DEL EMPLEADO</b></h2>

                    <div class="row justify-content-center align-content-center g-3 mt-3">
                        <br>

                        <!-- Fila 1: Nombre y Teléfono -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Nombre:</label>
                            <input type="text" class="form-control" style="background-color: rgba(200, 200, 200, 0.8); color: #000;" 
                                   value="<?php echo htmlspecialchars($empleado['nombre']); ?>" readonly disabled>
                        </div>

                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Teléfono:</label>
                            <input type="text" class="form-control" style="background-color: rgba(200, 200, 200, 0.8); color: #000;" 
                                   value="<?php echo htmlspecialchars($empleado['telefono']); ?>" readonly disabled>
                        </div>

                        <!-- Fila 2: Ciudad y Barrio -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Ciudad:</label>
                            <input type="text" class="form-control" style="background-color: rgba(200, 200, 200, 0.8); color: #000;" 
                                   value="<?php echo htmlspecialchars($empleado['ciudad']); ?>" readonly disabled>
                        </div>

                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Barrio:</label>
                            <input type="text" class="form-control" style="background-color: rgba(200, 200, 200, 0.8); color: #000;" 
                                   value="<?php echo htmlspecialchars($empleado['barrio']); ?>" readonly disabled>
                        </div>

                        <!-- Fila 3: Dirección (ocupa las dos columnas) -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-12 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Dirección:</label>
                            <input type="text" class="form-control" style="background-color: rgba(200, 200, 200, 0.8); color: #000;" 
                                   value="<?php echo htmlspecialchars($empleado['direccion']); ?>" readonly disabled>
                        </div>

                        <!-- Fila 4: Tipo Documento y Número Documento -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Tipo Documento:</label>
                            <input type="text" class="form-control" style="background-color: rgba(200, 200, 200, 0.8); color: #000;" 
                                   value="<?php echo htmlspecialchars($empleado['t_documento']); ?>" readonly disabled>
                        </div>

                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Número de Documento:</label>
                            <input type="text" class="form-control" style="background-color: rgba(200, 200, 200, 0.8); color: #000;" 
                                   value="<?php echo htmlspecialchars($empleado['n_documento']); ?>" readonly disabled>
                        </div>

                        <!-- Fila 5: Correo y Contraseña -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Correo:</label>
                            <input type="email" class="form-control" style="background-color: rgba(200, 200, 200, 0.8); color: #000;" 
                                   value="<?php echo htmlspecialchars($empleado['correo']); ?>" readonly disabled>
                        </div>

                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Contraseña:</label>
                            <input type="password" class="form-control" style="background-color: rgba(200, 200, 200, 0.8); color: #000;" 
                                   value="********" readonly disabled>
                        </div>

                        <!-- Fila 6: Rol -->
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Rol:</label>
                            <input type="text" class="form-control" style="background-color: rgba(200, 200, 200, 0.8); color: #000;" 
                                   value="<?php echo htmlspecialchars($empleado['nombre_rol']); ?>" readonly disabled>
                        </div>

                        <br>
                        <br>
                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 m-4 text-center">
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="bienvenido.php" class="btn btn-secondary m-2">Atrás</a>
                                </div>
                                <?php if ($_SESSION['id_rol'] == 1): ?>
                                <div class="col">
                                    <a href="update.php?id=<?php echo $empleado['id_empleado']; ?>" class="btn btn-primary mb-5 m-2">Editar</a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
            </div>
            <br>
            <br>
            <br>
        </div>
        <br>
        <br>
    </div>
</div>

<?php include("../template_ingreso_admin/pie.php") ?>