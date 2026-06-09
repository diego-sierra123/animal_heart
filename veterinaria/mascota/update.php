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
            $sexo = '';
            $id_tipo_mascota = '';
            $id_raza = '';
            $fecha_nacimiento = '';
            $id_cliente = '';
            $fecha_registro = '';
            $observaciones = '';

            if (isset($_GET['actualizar'])) {
                $editarId = mysqli_real_escape_string($conexion, $_GET['actualizar']);
                $consulta = "SELECT * FROM mascota WHERE id_mascota = '$editarId'";
                $ejecutar = mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));

                if ($ejecutar && mysqli_num_rows($ejecutar) > 0) {
                    $fila = mysqli_fetch_assoc($ejecutar);
                    $nombre = $fila['nombre'];
                    $sexo = $fila['sexo'];
                    $id_tipo_mascota = $fila['id_tipo_mascota'];
                    $id_raza = $fila['id_raza'];
                    $fecha_nacimiento = $fila['fecha_nacimiento'];
                    $id_cliente = $fila['id_cliente'];
                    $fecha_registro = $fila['fecha_registro'];
                    $observaciones = $fila['observaciones'];
                }
            }
            ?>

            <div class="row justify-content-center mt-5">
                <div class="col-10 col-sm-8 col-md-7 col-lg-6 custom-border background-image">
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>ACTUALIZAR MASCOTA</b></h2>

                    <form class="row justify-content-center align-content-center g-3 mt-3" name="insert" action="update.php" method="post" enctype="multipart/form-data">
                        <br>

                        <!-- ID Oculto -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light d-none">
                            <label for="" class="form-label">Id Mascota:</label>
                            <input type="text" name="txtid" value="<?php echo $editarId; ?>" class="form-control" readonly>
                        </div>

                        <!-- Nombre -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Nombre:</label>
                            <input type="text" name="txtnombre" minlength="1" maxlength="100" value="<?php echo $nombre; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Sexo -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Sexo:</label>
                            <select name="txtsexo" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                <option value="Macho" <?php echo ($sexo == 'Macho') ? 'selected' : ''; ?>>Macho</option>
                                <option value="Hembra" <?php echo ($sexo == 'Hembra') ? 'selected' : ''; ?>>Hembra</option>
                                <option value="Sin definir" <?php echo ($sexo == 'Sin definir') ? 'selected' : ''; ?>>Sin definir</option>
                            </select>
                        </div>

                        <!-- Tipo Mascota -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Tipo Mascota:</label>
                            <select name="txttipomascota" id="tipo_mascota" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                <option value="">Seleccione...</option>
                                <?php
                                $consulta = "SELECT * FROM tipo_mascota";
                                $ejecutar = mysqli_query($conexion, $consulta);
                                while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                    $selected = ($respuesta['id_tipo_mascota'] == $id_tipo_mascota) ? 'selected' : '';
                                    echo "<option value='" . $respuesta['id_tipo_mascota'] . "' $selected>" . $respuesta['nombre'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Raza -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Raza:</label>
                            <select name="txtraza" id="raza" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                <option value="">Seleccione...</option>
                                <?php
                                if ($id_tipo_mascota) {
                                    $consulta_razas = "SELECT * FROM raza WHERE id_tipo_mascota = '$id_tipo_mascota'";
                                    $ejecutar_razas = mysqli_query($conexion, $consulta_razas);
                                    while ($raza = mysqli_fetch_assoc($ejecutar_razas)) {
                                        $selected = ($raza['id_raza'] == $id_raza) ? 'selected' : '';
                                        echo "<option value='" . $raza['id_raza'] . "' $selected>" . $raza['nombre'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Fecha Nacimiento -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha Nacimiento:</label>
                            <input type="date" name="txtfecha" value="<?php echo $fecha_nacimiento; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" max="<?php echo date('Y-m-d'); ?>" required>
                        </div>

                        <!-- Cliente -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Cliente:</label>
                            <select name="txtcliente" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                <option value="">Seleccione...</option>
                                <?php
                                $consulta = "SELECT * FROM cliente ORDER BY nombres ASC";
                                $ejecutar = mysqli_query($conexion, $consulta);
                                while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                    $selected = ($respuesta['id_cliente'] == $id_cliente) ? 'selected' : '';
                                    echo "<option value='" . $respuesta['id_cliente'] . "' $selected>" . $respuesta['nombres'] . " " . $respuesta['apellidos'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Fecha Registro -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha Registro:</label>
                            <input type="date" name="txtfecharegistro" value="<?php echo $fecha_registro; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Observaciones -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Observaciones:</label>
                            <textarea name="txtobservacion" maxlength="255" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000; height: 60px;" required><?php echo $observaciones; ?></textarea>
                        </div>

                        <br>
                        <br>
                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 m-4 text-center">
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="../mascota/select.php" class="btn btn-secondary m-2">Atrás</a>
                                </div>
                                <br>
                                <div class="col">
                                    <input type="submit" name="actualizar" value="Actualizar" class="btn btn-primary mb-5 m-2">
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Script para cargar razas según tipo de mascota -->
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                    $(document).ready(function() {
                        $('#tipo_mascota').change(function() {
                            var tipo_mascota = $(this).val();
                            if (tipo_mascota) {
                                $.ajax({
                                    url: 'obtener_razas.php',
                                    type: 'POST',
                                    data: { tipo_mascota: tipo_mascota },
                                    dataType: 'json',
                                    success: function(response) {
                                        $("#raza").empty();
                                        $("#raza").append("<option value=''>Seleccione una raza</option>");
                                        $.each(response, function(index, raza) {
                                            $("#raza").append("<option value='" + raza.id_raza + "'>" + raza.nombre + "</option>");
                                        });
                                    }
                                });
                            } else {
                                $("#raza").empty();
                                $("#raza").append("<option value=''>Primero seleccione un tipo</option>");
                            }
                        });
                    });
                    </script>

                    <?php
                    if (isset($_POST["actualizar"])) {
                        // Escapar datos para evitar inyección SQL
                        $idPac = mysqli_real_escape_string($conexion, $_POST["txtid"]);
                        $nom = mysqli_real_escape_string($conexion, $_POST["txtnombre"]);
                        $sex = mysqli_real_escape_string($conexion, $_POST["txtsexo"]);
                        $tip = mysqli_real_escape_string($conexion, $_POST["txttipomascota"]);
                        $raz = mysqli_real_escape_string($conexion, $_POST["txtraza"]);
                        $fec = mysqli_real_escape_string($conexion, $_POST["txtfecha"]);
                        $cli = mysqli_real_escape_string($conexion, $_POST["txtcliente"]);
                        $fecreg = mysqli_real_escape_string($conexion, $_POST["txtfecharegistro"]);
                        $obs = mysqli_real_escape_string($conexion, $_POST["txtobservacion"]);

                        if (empty($idPac) || empty($nom) || empty($sex) || empty($tip) || empty($raz) || empty($fec) || empty($cli) || empty($fecreg) || empty($obs)) {
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
                            // Verificar si ya existe la mascota con los mismos datos en OTRO registro
                            $checkQuery = "SELECT id_mascota FROM mascota 
                                          WHERE nombre = '$nom' 
                                          AND id_tipo_mascota = '$tip' 
                                          AND id_raza = '$raz' 
                                          AND id_cliente = '$cli' 
                                          AND id_mascota != '$idPac'";
                            $checkResult = mysqli_query($conexion, $checkQuery);

                            if (mysqli_num_rows($checkResult) > 0) {
                                echo '<script type="text/javascript">
                                    swal({
                                        title: "Mensaje",
                                        text: "Los datos ya existen en otro registro, no se puede actualizar.",
                                        icon: "error",
                                        showCancelButton: false,
                                        confirmButtonText: "OK"
                                    }).then(function() {
                                        window.open("update.php?actualizar=' . $idPac . '", "_SELF");
                                    });
                                    </script>';
                            } else {
                                // No hay duplicados, proceder con la actualización
                                $sql = "UPDATE mascota SET 
                                        nombre = '$nom',
                                        sexo = '$sex',
                                        id_tipo_mascota = '$tip',
                                        id_raza = '$raz',
                                        fecha_nacimiento = '$fec',
                                        id_cliente = '$cli',
                                        fecha_registro = '$fecreg',
                                        observaciones = '$obs'
                                        WHERE id_mascota = '$idPac'";

                                $ejecutar = mysqli_query($conexion, $sql) or die(mysqli_error($conexion));

                                if ($ejecutar) {
                                    echo '<script type="text/javascript">
                                    swal({
                                        title: "Mensaje",
                                        text: "Registro Actualizado.",
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