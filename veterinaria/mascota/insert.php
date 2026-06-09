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
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>AGREGAR MASCOTA</b></h2>

                    <form class="row justify-content-center align-content-center g-3 mt-3" name="insert" action="insert.php" method="post" enctype="multipart/form-data">
                        <br>

                        <!-- Nombre -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Nombre:</label>
                            <input type="text" name="txtnombre" minlength="1" maxlength="100" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Sexo -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Sexo:</label>
                            <select name="txtsexo" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                <option value="">Seleccione...</option>
                                <option value="Macho">Macho</option>
                                <option value="Hembra">Hembra</option>
                                <option value="Sin definir">Sin definir</option>
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
                                    echo "<option value='" . $respuesta['id_tipo_mascota'] . "'>" . $respuesta['nombre'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Raza (dependiente del tipo mascota) -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Raza:</label>
                            <select name="txtraza" id="raza" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                <option value="">Primero seleccione un tipo</option>
                            </select>
                        </div>

                        <!-- Fecha Nacimiento -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha Nacimiento:</label>
                            <?php
                            $hora_actual = date('Y-m-d H:i:s');
                            $horas_a_retrasar = 7;
                            $nueva_fecha = date('Y-m-d', strtotime($hora_actual . ' - ' . $horas_a_retrasar . ' hours'));
                            ?>
                            <input type="date" name="txtfecha" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" max="<?php echo $nueva_fecha; ?>" required>
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
                                    echo "<option value='" . $respuesta['id_cliente'] . "'>" . $respuesta['nombres'] . " " . $respuesta['apellidos'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Fecha Registro -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha Registro:</label>
                            <input type="date" name="txtfecharegistro" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" min="<?php echo $nueva_fecha; ?>" max="<?php echo $nueva_fecha; ?>" value="<?php echo $nueva_fecha; ?>" required>
                        </div>

                        <!-- Observaciones -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Observaciones:</label>
                            <textarea name="txtobservacion" maxlength="255" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000; height: 60px;" required></textarea>
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
                                    <input type="submit" name="insertar" value="Agregar" class="btn btn-success mb-5 m-2">
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
                    if (isset($_POST["insertar"])) {
                        // Escapar datos para evitar inyección SQL
                        $nom = mysqli_real_escape_string($conexion, $_POST["txtnombre"]);
                        $sex = mysqli_real_escape_string($conexion, $_POST["txtsexo"]);
                        $tip = mysqli_real_escape_string($conexion, $_POST["txttipomascota"]);
                        $raz = mysqli_real_escape_string($conexion, $_POST["txtraza"]);
                        $fec = mysqli_real_escape_string($conexion, $_POST["txtfecha"]);
                        $cli = mysqli_real_escape_string($conexion, $_POST["txtcliente"]);
                        $fecreg = mysqli_real_escape_string($conexion, $_POST["txtfecharegistro"]);
                        $obs = mysqli_real_escape_string($conexion, $_POST["txtobservacion"]);

                        if (empty($nom) || empty($sex) || empty($tip) || empty($raz) || empty($fec) || empty($cli) || empty($fecreg) || empty($obs)) {
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
                            // Verificar si ya existe la mascota con los mismos datos
                            $consultaExistencia = "SELECT id_mascota FROM mascota 
                                                  WHERE nombre = '$nom' 
                                                  AND id_tipo_mascota = '$tip' 
                                                  AND id_raza = '$raz' 
                                                  AND id_cliente = '$cli'";
                            $resultadoExistencia = mysqli_query($conexion, $consultaExistencia);

                            if (mysqli_num_rows($resultadoExistencia) > 0) {
                                echo '<script type="text/javascript">
                                swal({
                                    title: "Mensaje",
                                    text: "Ya existe una mascota con los mismos datos para este cliente.",
                                    icon: "error",
                                    showCancelButton: false,
                                    confirmButtonText: "OK"
                                }).then(function() {
                                    window.open("insert.php", "_SELF");
                                });
                                </script>';
                            } else {
                                // Construir la consulta de inserción
                                $sql = "INSERT INTO mascota (nombre, sexo, id_tipo_mascota, id_raza, fecha_nacimiento, id_cliente, fecha_registro, observaciones) 
                                        VALUES ('$nom', '$sex', '$tip', '$raz', '$fec', '$cli', '$fecreg', '$obs')";

                                $ejecutar = mysqli_query($conexion, $sql);

                                if ($ejecutar) {
                                    echo '<script type="text/javascript">
                                    swal({
                                        title: "Mensaje",
                                        text: "Mascota guardada exitosamente.",
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
                                        text: "Hubo un problema al guardar la mascota: ' . addslashes(mysqli_error($conexion)) . '",
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