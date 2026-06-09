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

if ($_SESSION["id_rol"] == 2) {
    $_SESSION['error'] = 'sin permiso para ingresar';
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <title>Advertencia</title>
    </head>
    <body>
        <script type="text/javascript">
            swal({
                title: 'Mensaje',
                text: 'No tiene permiso para ingresar.',
                showCancelButton: false, 
                confirmButtonText: 'OK' 
            }).then(function() {
                // Redirigir después de aceptar
                window.location.href = "../paginas_personal/bienvenido.php";
            });
        </script>
    </body>
    </html>
    <?php
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
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>AGREGAR EMPLEADO</b></h2>

                    <form class="row justify-content-center align-content-center g-3 mt-3" name="insert" action="insert.php" method="post" enctype="multipart/form-data">
                        <br>

                        <!-- Nombre -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Nombre:</label>
                            <input type="text" name="txtnombre" minlength="1" maxlength="100" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Teléfono -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Teléfono:</label>
                            <input type="text" name="txttelefono" minlength="1" maxlength="20" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Ciudad -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Ciudad:</label>
                            <input type="text" name="txtciudad" minlength="1" maxlength="50" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Barrio -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Barrio:</label>
                            <input type="text" name="txtbarrio" minlength="1" maxlength="50" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Dirección -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Dirección:</label>
                            <input type="text" name="txtdireccion" minlength="1" maxlength="100" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Tipo Documento -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Tipo Documento:</label>
                            <select name="txttdocumento" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                <option value="">Seleccione...</option>
                                <option value="TI">Tarjeta de Identidad</option>
                                <option value="CC">Cédula de Ciudadanía</option>
                                <option value="CE">Cédula de Extranjería</option>
                                <option value="PAS">Pasaporte</option>
                            </select>
                        </div>

                        <!-- Número Documento -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Número de Documento:</label>
                            <input type="text" name="txtndocumento" minlength="1" maxlength="20" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Correo -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Correo:</label>
                            <input type="email" name="txtcorreo" minlength="1" maxlength="100" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Contraseña -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Contraseña:</label>
                            <input type="password" name="txtcontrasena" minlength="1" maxlength="255" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Rol -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Rol:</label>
                            <select name="selectrol" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                <option value="">Seleccione...</option>
                                <?php
                                $consulta = "SELECT * FROM rol WHERE id_rol != 3";
                                $ejecutar = mysqli_query($conexion, $consulta);
                                while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                    echo "<option value='" . $respuesta['id_rol'] . "'>" . $respuesta['nombre'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <br>
                        <br>
                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 m-4 text-center">
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="../empleado/select.php" class="btn btn-secondary m-2">Atrás</a>
                                </div>
                                <br>
                                <div class="col">
                                    <input type="submit" name="insertar" value="Agregar" class="btn btn-success mb-5 m-2">
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST["insertar"])) {
                        // Escapar datos para evitar inyección SQL
                        $nom = mysqli_real_escape_string($conexion, $_POST["txtnombre"]);
                        $tel = mysqli_real_escape_string($conexion, $_POST["txttelefono"]);
                        $ciu = mysqli_real_escape_string($conexion, $_POST["txtciudad"]);
                        $bar = mysqli_real_escape_string($conexion, $_POST["txtbarrio"]);
                        $dir = mysqli_real_escape_string($conexion, $_POST["txtdireccion"]);
                        $tdoc = mysqli_real_escape_string($conexion, $_POST["txttdocumento"]);
                        $ndoc = mysqli_real_escape_string($conexion, $_POST["txtndocumento"]);
                        $correo = mysqli_real_escape_string($conexion, $_POST["txtcorreo"]);
                        $contrasena = mysqli_real_escape_string($conexion, $_POST["txtcontrasena"]);
                        $rol = mysqli_real_escape_string($conexion, $_POST["selectrol"]);

                        if (empty($nom) || empty($tel) || empty($ciu) || empty($bar) || empty($dir) || empty($tdoc) || empty($ndoc) || empty($correo) || empty($contrasena) || empty($rol)) {
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
                            // Verificar si ya existe el correo o documento
                            $consultaExistencia = "SELECT id_empleado FROM empleado WHERE correo = '$correo'
                                                  UNION SELECT id_cliente FROM cliente WHERE correo = '$correo' OR n_documento = '$ndoc'";
                            $resultadoExistencia = mysqli_query($conexion, $consultaExistencia);

                            if (mysqli_num_rows($resultadoExistencia) > 0) {
                                echo '<script type="text/javascript">
                                swal({
                                    title: "Mensaje",
                                    text: "Ya existe un empleado o cliente con el mismo correo o número de documento.",
                                    icon: "error",
                                    showCancelButton: false,
                                    confirmButtonText: "OK"
                                }).then(function() {
                                    window.open("insert.php", "_SELF");
                                });
                                </script>';
                            } else {
                                // Construir la consulta de inserción
                                $sql = "INSERT INTO empleado (nombre, telefono, ciudad, barrio, direccion, t_documento, n_documento, correo, contrasena, id_rol) 
                                        VALUES ('$nom', '$tel', '$ciu', '$bar', '$dir', '$tdoc', '$ndoc', '$correo', '$contrasena', '$rol')";

                                $ejecutar = mysqli_query($conexion, $sql);

                                if ($ejecutar) {
                                    echo '<script type="text/javascript">
                                    swal({
                                        title: "Mensaje",
                                        text: "Empleado guardado exitosamente.",
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
                                        text: "Hubo un problema al guardar el empleado: ' . addslashes(mysqli_error($conexion)) . '",
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