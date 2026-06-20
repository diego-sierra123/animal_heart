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

            <br>

            <?php
            $editarId = '';
            $nombre = '';
            $telefono = '';
            $ciudad = '';
            $barrio = '';
            $direccion = '';
            $tdocumento = '';
            $ndocumento = '';
            $correo = '';
            $contrasena = '';
            $id_rol = '';

            if (isset($_GET['actualizar'])) {
                $editarId = mysqli_real_escape_string($conexion, $_GET['actualizar']);
                $consulta = "SELECT * FROM empleado WHERE id_empleado = '$editarId'";
                $ejecutar = mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));

                if ($ejecutar && mysqli_num_rows($ejecutar) > 0) {
                    $fila = mysqli_fetch_assoc($ejecutar);
                    $nombre = $fila['nombre'];
                    $telefono = $fila['telefono'];
                    $ciudad = $fila['ciudad'];
                    $barrio = $fila['barrio'];
                    $direccion = $fila['direccion'];
                    $tdocumento = $fila['t_documento'];
                    $ndocumento = $fila['n_documento'];
                    $correo = $fila['correo'];
                    $contrasena = $fila['contrasena'];
                    $id_rol = $fila['id_rol'];
                }
            }
            ?>

            <div class="row justify-content-center mt-5">
                <div class="col-10 col-sm-8 col-md-7 col-lg-6 custom-border background-image">
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>ACTUALIZAR EMPLEADO</b></h2>

                    <form class="row justify-content-center align-content-center g-3 mt-3" name="insert" action="update.php" method="post" enctype="multipart/form-data">
                        <br>

                        <!-- ID Oculto -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light d-none">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Id Empleado:</label>
                            <input type="text" name="txtid" value="<?php echo $editarId; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" readonly>
                        </div>

                        <!-- Nombre -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Nombre:</label>
                            <input type="text" name="txtnombre" minlength="1" maxlength="100" value="<?php echo $nombre; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Teléfono -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Teléfono:</label>
                            <input type="text" name="txttelefono" minlength="1" maxlength="20" value="<?php echo $telefono; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Ciudad -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Ciudad:</label>
                            <input type="text" name="txtciudad" minlength="1" maxlength="50" value="<?php echo $ciudad; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Barrio -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Barrio:</label>
                            <input type="text" name="txtbarrio" minlength="1" maxlength="50" value="<?php echo $barrio; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Dirección -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Dirección:</label>
                            <input type="text" name="txtdireccion" minlength="1" maxlength="100" value="<?php echo $direccion; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Tipo Documento -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Tipo Documento:</label>
                            <select name="txttdocumento" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                <option value="TI" <?php echo ($tdocumento == 'TI') ? 'selected' : ''; ?>>Tarjeta de Identidad</option>
                                <option value="CC" <?php echo ($tdocumento == 'CC') ? 'selected' : ''; ?>>Cédula de Ciudadanía</option>
                                <option value="CE" <?php echo ($tdocumento == 'CE') ? 'selected' : ''; ?>>Cédula de Extranjería</option>
                                <option value="PAS" <?php echo ($tdocumento == 'PAS') ? 'selected' : ''; ?>>Pasaporte</option>
                            </select>
                        </div>

                        <!-- Número Documento -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Número de Documento:</label>
                            <input type="text" name="txtndocumento" minlength="1" maxlength="20" value="<?php echo $ndocumento; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Correo -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Correo:</label>
                            <input type="email" name="txtcorreo" minlength="1" maxlength="100" value="<?php echo $correo; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Contraseña -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Contraseña:</label>
                            <input type="password" name="txtcontrasena" minlength="1" maxlength="255" value="<?php echo $contrasena; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Rol -->
                        <?php
                        if ($id_rol != 1) {
                        ?>
                            <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Rol:</label>
                                <select name="selectrol" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <option value="">Seleccione...</option>
                                    <?php
                                    $consulta = "SELECT * FROM rol WHERE id_rol != 3";
                                    $ejecutar = mysqli_query($conexion, $consulta);
                                    while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                        $selected = ($respuesta['id_rol'] == $id_rol) ? 'selected' : '';
                                        echo "<option value='" . $respuesta['id_rol'] . "' $selected>" . $respuesta['nombre'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        <?php
                        } else {
                            echo '<input type="hidden" name="selectrol" value="1">';
                        }
                        ?>

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
                                    <input type="submit" name="actualizar" value="Actualizar" class="btn btn-primary mb-5 m-2">
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST["actualizar"])) {
                        // Escapar datos
                        $idPac = mysqli_real_escape_string($conexion, $_POST["txtid"]);
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

                        // Validar campos obligatorios
                        if (empty($idPac) || empty($nom) || empty($tel) || empty($ciu) || empty($bar) || empty($dir) || empty($tdoc) || empty($ndoc) || empty($correo) || empty($contrasena) || empty($rol)) {
                            echo '<script type="text/javascript">
                            swal({
                                title: "Mensaje",
                                text: "Por favor, complete todos los campos.",
                                icon: "error",
                                showCancelButton: false,
                                confirmButtonText: "OK"
                            }).then(function() {
                                window.open("update.php?actualizar=' . $idPac . '", "_SELF");
                            });
                            </script>';
                        } else {
                            // ========== VALIDACIÓN DE DUPLICADOS (ignorando valores genéricos) ==========
                            $ignorar_valores = ['N/A', 'NA', 'n/a', 'no tiene', 'sin dato', '0', '', 'ninguno', 'NULL', 'null', '--'];

                            function esGenerico($valor, $ignorar_valores) {
                                $valor_limpio = trim($valor);
                                return in_array($valor_limpio, $ignorar_valores) || empty($valor_limpio);
                            }

                            $check_duplicados = false;
                            $mensaje_error = '';

                            // Verificar documento (si no es genérico)
                            if (!esGenerico($ndoc, $ignorar_valores)) {
                                $checkQuery = "SELECT id_empleado FROM empleado WHERE n_documento = '$ndoc' AND id_empleado != '$idPac'";
                                $checkResult = mysqli_query($conexion, $checkQuery);
                                if (mysqli_num_rows($checkResult) > 0) {
                                    $check_duplicados = true;
                                    $mensaje_error = "El número de documento ya está registrado en otro empleado.";
                                }
                            }

                            // Verificar correo (si no es genérico y no hay duplicado previo)
                            if (!$check_duplicados && !esGenerico($correo, $ignorar_valores)) {
                                $checkQuery = "SELECT id_empleado FROM empleado WHERE correo = '$correo' AND id_empleado != '$idPac'";
                                $checkResult = mysqli_query($conexion, $checkQuery);
                                if (mysqli_num_rows($checkResult) > 0) {
                                    $check_duplicados = true;
                                    $mensaje_error = "El correo ya está registrado en otro empleado.";
                                }
                            }

                            if ($check_duplicados) {
                                echo '<script type="text/javascript">
                                swal({
                                    title: "Mensaje",
                                    text: "' . $mensaje_error . '",
                                    icon: "error",
                                    showCancelButton: false,
                                    confirmButtonText: "OK"
                                }).then(function() {
                                    window.open("update.php?actualizar=' . $idPac . '", "_SELF");
                                });
                                </script>';
                            } else {
                                // No hay duplicados relevantes, proceder con la actualización
                                $sql = "UPDATE empleado SET 
                                        nombre = '$nom',
                                        telefono = '$tel',
                                        ciudad = '$ciu',
                                        barrio = '$bar',
                                        direccion = '$dir',
                                        t_documento = '$tdoc',
                                        n_documento = '$ndoc',
                                        correo = '$correo',
                                        contrasena = '$contrasena',
                                        id_rol = '$rol'
                                        WHERE id_empleado = '$idPac'";

                                $ejecutar = mysqli_query($conexion, $sql) or die(mysqli_error($conexion));

                                if ($ejecutar) {
                                    echo '<script type="text/javascript">
                                    swal({
                                        title: "Mensaje",
                                        text: "Registro actualizado exitosamente.",
                                        icon: "success",
                                        showCancelButton: false,
                                        confirmButtonText: "OK"
                                    }).then(function() {
                                        window.open("select.php", "_SELF");
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