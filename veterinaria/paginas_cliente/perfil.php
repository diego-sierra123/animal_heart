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

<?php include("../template_ingreso_cliente/menu.php") ?>

<?php
$id_cliente = isset($_GET['persona']) ? mysqli_real_escape_string($conexion, $_GET['persona']) : $_SESSION['id'];

$consulta = "SELECT c.*, r.nombre as nombre_rol 
             FROM cliente c 
             INNER JOIN rol r ON c.id_rol = r.id_rol 
             WHERE c.id_cliente = '$id_cliente'";
$ejecutar = mysqli_query($conexion, $consulta);
$cliente = mysqli_fetch_assoc($ejecutar);

if (!$cliente) {
    header("Location: bienvenido.php");
    exit();
}
?>

<div class="container-fluid container-main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="row justify-content-center mt-5">
                <div class="col-10 col-sm-8 col-md-7 col-lg-6 custom-border background-image">
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>PERFIL DEL CLIENTE</b></h2>

                    <div class="row justify-content-center align-content-center g-3 mt-3">
                        <br>

                        <!-- Fila 1: Nombre y Apellido -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Nombre:</label>
                            <input type="text" class="form-control" style="background-color: rgba(200, 200, 200, 0.8); color: #000;" 
                                   value="<?php echo htmlspecialchars($cliente['nombres']); ?>" readonly disabled>
                        </div>

                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Apellido:</label>
                            <input type="text" class="form-control" style="background-color: rgba(200, 200, 200, 0.8); color: #000;" 
                                   value="<?php echo htmlspecialchars($cliente['apellidos']); ?>" readonly disabled>
                        </div>

                        <!-- Fila 2: Teléfono y Correo -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Teléfono:</label>
                            <input type="text" class="form-control" style="background-color: rgba(200, 200, 200, 0.8); color: #000;" 
                                   value="<?php echo htmlspecialchars($cliente['telefono']); ?>" readonly disabled>
                        </div>

                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Correo:</label>
                            <input type="email" class="form-control" style="background-color: rgba(200, 200, 200, 0.8); color: #000;" 
                                   value="<?php echo htmlspecialchars($cliente['correo']); ?>" readonly disabled>
                        </div>

                        <!-- Fila 3: Ciudad y Barrio -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Ciudad:</label>
                            <input type="text" class="form-control" style="background-color: rgba(200, 200, 200, 0.8); color: #000;" 
                                   value="<?php echo htmlspecialchars($cliente['ciudad']); ?>" readonly disabled>
                        </div>

                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Barrio:</label>
                            <input type="text" class="form-control" style="background-color: rgba(200, 200, 200, 0.8); color: #000;" 
                                   value="<?php echo htmlspecialchars($cliente['barrio']); ?>" readonly disabled>
                        </div>

                        <!-- Fila 4: Dirección -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-12 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Dirección:</label>
                            <input type="text" class="form-control" style="background-color: rgba(200, 200, 200, 0.8); color: #000;" 
                                   value="<?php echo htmlspecialchars($cliente['direccion']); ?>" readonly disabled>
                        </div>

                        <!-- Fila 5: Tipo Documento y Número Documento -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Tipo Documento:</label>
                            <input type="text" class="form-control" style="background-color: rgba(200, 200, 200, 0.8); color: #000;" 
                                   value="<?php echo htmlspecialchars($cliente['t_documento']); ?>" readonly disabled>
                        </div>

                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Número de Documento:</label>
                            <input type="text" class="form-control" style="background-color: rgba(200, 200, 200, 0.8); color: #000;" 
                                   value="<?php echo htmlspecialchars($cliente['n_documento']); ?>" readonly disabled>
                        </div>

                        <!-- Fila 6: Contraseña -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-12 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Contraseña:</label>
                            <input type="password" class="form-control" style="background-color: rgba(200, 200, 200, 0.8); color: #000;" 
                                   value="********" readonly disabled>
                        </div>

                        <!-- Fila 7: Rol -->
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 text-light">
                            <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Rol:</label>
                            <input type="text" class="form-control" style="background-color: rgba(200, 200, 200, 0.8); color: #000;" 
                                   value="<?php echo htmlspecialchars($cliente['nombre_rol']); ?>" readonly disabled>
                        </div>

                        <br>
                        <br>
                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 m-4 text-center">
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="bienvenido.php" class="btn btn-secondary m-2">Atrás</a>
                                </div>
                                <div class="col">
                                    <a href="update.php?id=<?php echo $cliente['id_cliente']; ?>" class="btn btn-primary mb-5 m-2">Editar</a>
                                </div>
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

<?php include("../template_ingreso_cliente/pie.php") ?>