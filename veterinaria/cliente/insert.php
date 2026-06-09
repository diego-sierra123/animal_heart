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
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>AGREGAR CLIENTE</b></h2>

                    <form class="mt-3" name="insert" action="insert.php" method="post" enctype="multipart/form-data">
                        <br>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Nombres:</label>
                                <input type="text" name="txtnombre" placeholder="Ingrese los nombres" minlength="1" maxlength="50" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Apellidos:</label>
                                <input type="text" name="txtapellido" placeholder="Ingrese los apellidos" minlength="1" maxlength="50" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Teléfono:</label>
                                <input type="text" name="txttelefono" placeholder="Ingrese el teléfono" minlength="7" maxlength="15" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Ciudad:</label>
                                <input type="text" name="txtciudad" placeholder="Ingrese la ciudad donde vive" minlength="1" maxlength="50" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Barrio:</label>
                                <input type="text" name="txtbarrio" placeholder="Ingrese el barrio donde vive" minlength="1" maxlength="50" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Dirección:</label>
                                <input type="text" name="txtdireccion" placeholder="Ingrese la dirección" minlength="1" maxlength="100" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Tipo Documento:</label>
                                <select name="txttdocumento" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <option value="">Seleccione...</option>
                                    <option value="TI">Tarjeta de identidad</option>
                                    <option value="CC">Cédula</option>
                                    <option value="CE">Cédula de extranjería</option>
                                    <option value="PAS">Pasaporte</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Número de documento:</label>
                                <input type="text" name="txtndocumento" placeholder="Ingrese el número de documento" minlength="5" maxlength="20" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Correo:</label>
                                <input type="email" name="txtcorreo" placeholder="Ingrese el correo" maxlength="100" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Contraseña:</label>
                                <input type="password" name="txtcontrasena" placeholder="Ingrese la contraseña" minlength="6" maxlength="50" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                        </div>

                        <br>
                        <div class="row justify-content-center">
                            <div class="col-10 col-sm-8 col-md-7 col-lg-6 m-4 text-center">
                                <br>
                                <div class="row">
                                    <div class="col">
                                        <a href="../cliente/select.php" class="btn btn-secondary m-2">Atrás</a>
                                    </div>
                                    <br>
                                    <div class="col">
                                        <input type="submit" name="insertar" value="Agregar" class="btn btn-success mb-5 m-2">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        if (isset($_POST["insertar"])) {
                            // Escapar datos para evitar inyección SQL
                            $nom = mysqli_real_escape_string($conexion, $_POST["txtnombre"]);
                            $ape = mysqli_real_escape_string($conexion, $_POST['txtapellido']);
                            $tel = mysqli_real_escape_string($conexion, $_POST['txttelefono']);
                            $ciu = mysqli_real_escape_string($conexion, $_POST['txtciudad']);
                            $bar = mysqli_real_escape_string($conexion, $_POST['txtbarrio']);
                            $dir = mysqli_real_escape_string($conexion, $_POST['txtdireccion']);
                            $tdoc = mysqli_real_escape_string($conexion, $_POST['txttdocumento']);
                            $ndoc = mysqli_real_escape_string($conexion, $_POST['txtndocumento']);
                            $correo = mysqli_real_escape_string($conexion, $_POST['txtcorreo']);
                            $contrasena = mysqli_real_escape_string($conexion, $_POST['txtcontrasena']);

                            if (empty($nom) || empty($ape) || empty($ciu) || empty($bar) || empty($tel) || empty($dir) || empty($tdoc) || empty($ndoc) || empty($correo) || empty($contrasena)) {
                                echo '<script type="text/javascript">
                                swal({
                                    title: "Mensaje",
                                    text: "Por favor, complete todos los campos.",
                                    icon: "error",
                                    showCancelButton: false,
                                    confirmButtonText: "OK"
                                }).then(function() {
                                    window.open("insert.php", "_SELF");
                                });
                                </script>';
                            } else {
                                // Verificar si ya existe el correo o número de documento
                                $consultaExistencia = "SELECT id_cliente FROM cliente WHERE correo = '$correo' OR n_documento = '$ndoc'
                                                       UNION 
                                                       SELECT id_empleado FROM empleado WHERE correo = '$correo' OR n_documento = '$ndoc'";
                                $resultadoExistencia = mysqli_query($conexion, $consultaExistencia);

                                if (mysqli_num_rows($resultadoExistencia) > 0) {
                                    echo '<script type="text/javascript">
                                    swal({
                                        title: "Mensaje",
                                        text: "Ya existe un cliente o empleado con el mismo correo o número de documento.",
                                        icon: "error",
                                        showCancelButton: false,
                                        confirmButtonText: "OK"
                                    }).then(function() {
                                        window.open("insert.php", "_SELF");
                                    });
                                    </script>';
                                } else {
                                    $sql = "INSERT INTO cliente (nombres, apellidos, telefono, ciudad, barrio, direccion, t_documento, n_documento, correo, contrasena, id_rol) 
                                            VALUES ('$nom', '$ape', '$tel', '$ciu', '$bar', '$dir', '$tdoc', '$ndoc', '$correo', '$contrasena', 3)";
                                    $result = mysqli_query($conexion, $sql);

                                    if ($result) {
                                        echo '<script type="text/javascript">
                                        swal({
                                            title: "Mensaje",
                                            text: "Cliente guardado exitosamente.",
                                            icon: "success",
                                            showCancelButton: false,
                                            confirmButtonText: "OK"
                                        }).then(function() {
                                            window.open("select.php", "_SELF");
                                        });
                                        </script>';
                                    } else {
                                        echo '<script type="text/javascript">
                                        swal({
                                            title: "Error",
                                            text: "Hubo un problema al guardar el cliente: ' . addslashes(mysqli_error($conexion)) . '",
                                            icon: "error",
                                            showCancelButton: false,
                                            confirmButtonText: "OK"
                                        });
                                        </script>';
                                    }
                                }
                            }
                        }
                        ?>
                    </form>
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