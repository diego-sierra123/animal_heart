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

            <br>

            <?php
            $editarId = '';
            $nombre = '';
            $apellido = '';
            $telefono = '';
            $ciudad = '';
            $barrio = '';
            $direccion = '';
            $tdocumento = '';
            $ndocumento = '';
            $correo = '';

            if (isset($_GET['actualizar'])) {
                $editarId = mysqli_real_escape_string($conexion, $_GET['actualizar']);
                $consulta = "SELECT * FROM cliente WHERE id_cliente = '$editarId'";
                $ejecutar = mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));

                if ($ejecutar && mysqli_num_rows($ejecutar) > 0) {
                    $fila = mysqli_fetch_assoc($ejecutar);
                    $nombre = $fila['nombres'];
                    $apellido = $fila['apellidos'];
                    $telefono = $fila['telefono'];
                    $ciudad = $fila['ciudad'];
                    $barrio = $fila['barrio'];
                    $direccion = $fila['direccion'];
                    $tdocumento = $fila['t_documento'];
                    $ndocumento = $fila['n_documento'];
                    $correo = $fila['correo'];
                }
            }
            ?>

            <div class="row justify-content-center mt-5">
                <div class="col-10 col-sm-8 col-md-7 col-lg-6 custom-border background-image">
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>ACTUALIZAR CLIENTE</b></h2>

                    <form class="mt-3" name="insert" action="update.php" method="post" enctype="multipart/form-data">
                        <br>

                        <div class="row mb-3 d-none">
                            <div class="col-md-12">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Id Cliente:</label>
                                <input type="text" name="txtid" value="<?php echo $editarId; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Nombres:</label>
                                <input type="text" name="txtnombre" minlength="1" maxlength="50" value="<?php echo $nombre; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Apellidos:</label>
                                <input type="text" name="txtapellido" minlength="1" maxlength="50" value="<?php echo $apellido; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Teléfono:</label>
                                <input type="text" name="txttelefono" minlength="7" maxlength="15" value="<?php echo $telefono; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Ciudad:</label>
                                <input type="text" name="txtciudad" minlength="1" maxlength="50" value="<?php echo $ciudad; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Barrio:</label>
                                <input type="text" name="txtbarrio" minlength="1" maxlength="50" value="<?php echo $barrio; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Dirección:</label>
                                <input type="text" name="txtdireccion" minlength="1" maxlength="100" value="<?php echo $direccion; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Tipo Documento:</label>
                                <select name="txttdocumento" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <option value="TI" <?php echo ($tdocumento == 'TI') ? 'selected' : ''; ?>>Tarjeta de identidad</option>
                                    <option value="CC" <?php echo ($tdocumento == 'CC') ? 'selected' : ''; ?>>Cédula</option>
                                    <option value="CE" <?php echo ($tdocumento == 'CE') ? 'selected' : ''; ?>>Cédula de extranjería</option>
                                    <option value="PAS" <?php echo ($tdocumento == 'PAS') ? 'selected' : ''; ?>>Pasaporte</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Número de documento:</label>
                                <input type="text" name="txtndocumento" minlength="5" maxlength="20" value="<?php echo $ndocumento; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Correo:</label>
                                <input type="email" name="txtcorreo" maxlength="100" value="<?php echo $correo; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Contraseña (dejar vacío para no cambiar):</label>
                                <input type="password" name="txtcontrasena" placeholder="Ingrese nueva contraseña" minlength="6" maxlength="50" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;">
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
                                        <input type="submit" name="actualizar" value="Actualizar" class="btn btn-primary mb-5 m-2">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        if (isset($_POST["actualizar"])) {
                            // Escapar datos para evitar inyección SQL
                            $idPac = mysqli_real_escape_string($conexion, $_POST["txtid"]);
                            $nom = mysqli_real_escape_string($conexion, $_POST["txtnombre"]);
                            $ape = mysqli_real_escape_string($conexion, $_POST["txtapellido"]);
                            $tel = mysqli_real_escape_string($conexion, $_POST["txttelefono"]);
                            $ciu = mysqli_real_escape_string($conexion, $_POST["txtciudad"]);
                            $bar = mysqli_real_escape_string($conexion, $_POST["txtbarrio"]);
                            $dir = mysqli_real_escape_string($conexion, $_POST["txtdireccion"]);
                            $tdoc = mysqli_real_escape_string($conexion, $_POST["txttdocumento"]);
                            $ndoc = mysqli_real_escape_string($conexion, $_POST["txtndocumento"]);
                            $cor = mysqli_real_escape_string($conexion, $_POST["txtcorreo"]);
                            $contrasena = mysqli_real_escape_string($conexion, $_POST["txtcontrasena"]);

                            if (empty($idPac) || empty($nom) || empty($ape) || empty($tel) || empty($ciu) || empty($bar) || empty($dir) || empty($tdoc) || empty($ndoc) || empty($cor)) {
                                echo '<script type="text/javascript">
                                swal({
                                    title: "Mensaje",
                                    text: "Por favor, complete los campos que modificaste y dejaste vacíos.",
                                    icon: "error",
                                    showCancelButton: false,
                                    confirmButtonText: "OK"
                                }).then(function() {
                                    window.open("update.php?actualizar=' . $idPac . '", "_SELF");
                                });
                                </script>';
                            } else {
                                // Verificar si ya existe el correo o número de documento en otro registro
                                $checkQuery = "SELECT id_cliente FROM cliente WHERE (n_documento = '$ndoc' OR correo = '$cor') AND id_cliente != '$idPac' 
                                               UNION 
                                               SELECT id_empleado FROM empleado WHERE n_documento = '$ndoc' OR correo = '$cor'";
                                $checkResult = mysqli_query($conexion, $checkQuery);

                                if (mysqli_num_rows($checkResult) > 0) {
                                    echo '<script type="text/javascript">
                                    swal({
                                        title: "Mensaje",
                                        text: "El correo o número de documento ya existe en otro registro.",
                                        icon: "error",
                                        showCancelButton: false,
                                        confirmButtonText: "OK"
                                    }).then(function() {
                                        window.open("update.php?actualizar=' . $idPac . '", "_SELF");
                                    });
                                    </script>';
                                } else {
                                    if (!empty($contrasena)) {
                                        // Si se proporcionó nueva contraseña, actualizar todo incluyendo contraseña
                                        $sql = "UPDATE cliente SET 
                                                nombres='$nom', 
                                                apellidos='$ape', 
                                                telefono='$tel', 
                                                ciudad='$ciu', 
                                                barrio='$bar', 
                                                direccion='$dir', 
                                                t_documento='$tdoc', 
                                                n_documento='$ndoc', 
                                                correo='$cor',
                                                contrasena='$contrasena'
                                                WHERE id_cliente='$idPac'";
                                    } else {
                                        // Si no se proporcionó contraseña, actualizar todo excepto contraseña
                                        $sql = "UPDATE cliente SET 
                                                nombres='$nom', 
                                                apellidos='$ape', 
                                                telefono='$tel', 
                                                ciudad='$ciu', 
                                                barrio='$bar', 
                                                direccion='$dir', 
                                                t_documento='$tdoc', 
                                                n_documento='$ndoc', 
                                                correo='$cor'
                                                WHERE id_cliente='$idPac'";
                                    }
                                    
                                    $ejecutar = mysqli_query($conexion, $sql);

                                    if ($ejecutar) {
                                        echo '<script type="text/javascript">
                                        swal({
                                            title: "Mensaje",
                                            text: "Cliente actualizado exitosamente.",
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
                                            text: "Hubo un problema al actualizar el cliente: ' . addslashes(mysqli_error($conexion)) . '",
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