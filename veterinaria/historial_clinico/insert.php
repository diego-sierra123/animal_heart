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
$id_mascotaa = intval($_GET['id_mascotaa'] ?? 0);
$id_clientee = intval($_GET['id_clientee'] ?? 0);
?>

<div class="container-fluid container-main">
    <div class="container">
        <div class="row justify-content-center">

            <div class="row justify-content-center mt-5">
                <div class="col-10 col-sm-8 col-md-7 col-lg-6 custom-border background-image">
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>AGREGAR HISTORIA CLINICA</b></h2>

                    <form class="mt-3" name="insert" action="insert.php?id_mascotaa=<?php echo $id_mascotaa; ?>&id_clientee=<?php echo $id_clientee; ?>" method="post" enctype="multipart/form-data">
                        <br>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Mascota:</label>
                                <select name="txtmascota" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" disabled>
                                    <?php
                                    $consulta = "SELECT * FROM mascota";
                                    $ejecutar = mysqli_query($conexion, $consulta);
                                    while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                        $selected = ($respuesta['id_mascota'] == $id_mascotaa) ? 'selected' : '';
                                        echo "<option value='" . $respuesta['id_mascota'] . "' $selected>" . htmlspecialchars($respuesta['nombre']) . "</option>";
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="txtmascota" value="<?php echo $id_mascotaa; ?>">
                            </div>

                            <div class="col-md-4">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Cliente:</label>
                                <select name="txtcliente" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" disabled>
                                    <?php
                                    $consulta = "SELECT * FROM cliente";
                                    $ejecutar = mysqli_query($conexion, $consulta);
                                    while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                        $selected = ($respuesta['id_cliente'] == $id_clientee) ? 'selected' : '';
                                        echo "<option value='" . $respuesta['id_cliente'] . "' $selected>" . htmlspecialchars($respuesta['nombres']) . "</option>";
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="txtcliente" value="<?php echo $id_clientee; ?>">
                            </div>

                            <div class="col-md-4">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha:</label>
                                <?php
                                $hora_actual = date('Y-m-d H:i:s');
                                $horas_a_retrasar = 7;
                                $nueva_fecha = date('Y-m-d', strtotime($hora_actual . ' - ' . $horas_a_retrasar . ' hours'));
                                ?>
                                <input type="date" name="txtfecha" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" min="<?php echo $nueva_fecha; ?>" max="<?php echo $nueva_fecha; ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Pulso:</label>
                                <input type="number" min="0" name="txtpulso" placeholder="Ingrese el pulso" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Cardio:</label>
                                <input type="number" min="0" name="txtcardio" placeholder="Ingrese el cardio" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Atendido por:</label>
                                <select name="selectempleado" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <?php
                                    $consulta = "SELECT * FROM empleado";
                                    $ejecutar = mysqli_query($conexion, $consulta);
                                    while ($res = mysqli_fetch_assoc($ejecutar)) {
                                        echo "<option value = '" . $res['id_empleado'] . "'>" . htmlspecialchars($res['nombre']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"> Diagnóstico:</label>
                                <textarea name="txtdiagnostico" placeholder="Ingrese los diagnósticos" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" rows="3"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Instrucciones:</label>
                                <textarea name="txtinstrucciones" placeholder="Ingrese las instrucciones" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" rows="3"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Peso (kg):</label>
                                <input type="number" step="0.01" min="0" name="txtpeso" placeholder="Ingrese el peso" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha Proxima:</label>
                                <input type="date" name="txtfechapro" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" min="<?php echo $nueva_fecha; ?>">
                            </div>
                            <div class="col-md-12">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Tratamiento:</label>
                                <select name="txttratamiento" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;">
                                    <?php
                                    // Siempre mostrar la opción N/A

                                    if ($id_mascotaa != 1) {
                                        echo "<option value='1'>N/A</option>";
                                    }

                                    $consulta = "SELECT t.id_tratamiento, t.medicamentos AS tratamiento
                                                 FROM tratamiento t
                                                 WHERE t.id_mascota = $id_mascotaa";
                                    $ejecutar = mysqli_query($conexion, $consulta);
                                    if (mysqli_num_rows($ejecutar) > 0) {
                                        while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                            echo "<option value='" . $respuesta['id_tratamiento'] . "'>" . htmlspecialchars($respuesta['tratamiento']) . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; color: #fff;">
                                    Servicio:
                                </label>
                                <select name="txtservicio" class="form-control" style="background-color: rgba(255,255,255,0.8);" required>
                                    <?php
                                    $consulta = "SELECT * FROM nom_servicio";
                                    $ejecutar = mysqli_query($conexion, $consulta);
                                    while ($res = mysqli_fetch_assoc($ejecutar)) {
                                        echo "<option value='" . $res['id_nom_servicio'] . "'>" . htmlspecialchars($res['nombre']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Vacuna:</label>
                                <select name="selectvacuna" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;">
                                    <?php
                                    $consulta = "SELECT * FROM vacuna";
                                    $ejecutar = mysqli_query($conexion, $consulta);
                                    while ($res = mysqli_fetch_assoc($ejecutar)) {
                                        echo "<option value = '" . $res['id_vacuna'] . "'>" . htmlspecialchars($res['nombre']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha de la vacuna:</label>
                                <input type="date" name="txtfechavacuna" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" min="<?php echo $nueva_fecha; ?>" max="<?php echo $nueva_fecha; ?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Desparasitante:</label>
                                <select name="selectdesparasitante" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;">
                                    <?php
                                    $consulta = "SELECT * FROM desparasitante";
                                    $ejecutar = mysqli_query($conexion, $consulta);
                                    while ($res = mysqli_fetch_assoc($ejecutar)) {
                                        echo "<option value = '" . $res['id_desparasitante'] . "'>" . htmlspecialchars($res['nombre']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha del desparasitante:</label>
                                <input type="date" name="txtfechadesparasitante" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" min="<?php echo $nueva_fecha; ?>" max="<?php echo $nueva_fecha; ?>">
                            </div>
                        </div>

                        <br>
                        <div class="row justify-content-center">
                            <div class="col-10 col-sm-8 col-md-7 col-lg-6 m-4 text-center">
                                <br>
                                <div class="row">
                                    <div class="col">
                                        <a href="../historial_clinico/select.php?id=<?php echo $id_mascotaa; ?>&clienteee=<?php echo $id_clientee; ?>" class="btn btn-secondary m-2">Atrás</a>
                                    </div>
                                    <br>
                                    <div class="col">
                                        <input type="submit" name="enviar" value="Agregar" class="btn btn-success mb-5 m-2">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        if (isset($_POST["enviar"])) {
                            $fec = mysqli_real_escape_string($conexion, $_POST["txtfecha"]);
                            $pul = mysqli_real_escape_string($conexion, $_POST["txtpulso"]);
                            $car = mysqli_real_escape_string($conexion, $_POST["txtcardio"]);
                            $emp = $_POST['selectempleado'];
                            $cli = $_POST['txtcliente'];
                            $mas = $_POST['txtmascota'];
                            $serv = $_POST['txtservicio'];
                            $pes = mysqli_real_escape_string($conexion, $_POST["txtpeso"]);
                            $dia = mysqli_real_escape_string($conexion, $_POST["txtdiagnostico"]);
                            $ins = mysqli_real_escape_string($conexion, $_POST["txtinstrucciones"]);
                            $fecpro = !empty($_POST["txtfechapro"]) ? mysqli_real_escape_string($conexion, $_POST["txtfechapro"]) : null;
                            $tra = $_POST['txttratamiento'];
                            $vac = $_POST['selectvacuna'];
                            $fecvac = !empty($_POST["txtfechavacuna"]) ? mysqli_real_escape_string($conexion, $_POST["txtfechavacuna"]) : null;
                            $des = $_POST['selectdesparasitante'];
                            $fecdes = !empty($_POST["txtfechadesparasitante"]) ? mysqli_real_escape_string($conexion, $_POST["txtfechadesparasitante"]) : null;

                            $consultaProveedor = "SELECT id_mascota FROM mascota WHERE id_mascota = '$mas'";
                            $resultadoProveedor = mysqli_query($conexion, $consultaProveedor);

                            if (mysqli_num_rows($resultadoProveedor) > 0 && !empty($mas) && !empty($fec) && !empty($pul) && !empty($car) && !empty($emp)) {
                                $sql = "INSERT INTO historial_clinico (id_cliente, id_mascota, fecha_visita, diagnostico, id_tratamiento, instrucciones, fecha_proxima_cita, pulso, cardio, id_vacuna, fecha_vacuna, id_desparasitante, fecha_desparasitante, id_empleado, id_nom_servicio, peso) 
                                        VALUES ('$cli', '$mas', '$fec', '$dia', '$tra', '$ins', " . ($fecpro ? "'$fecpro'" : "NULL") . ", '$pul', '$car', '$vac', " . ($fecvac ? "'$fecvac'" : "NULL") . ", '$des', " . ($fecdes ? "'$fecdes'" : "NULL") . ", '$emp', '$serv', '$pes')";
                                $result = mysqli_query($conexion, $sql);

                                if ($result) {
                                    echo '<script type="text/javascript">
                                        swal({
                                            title: "Mensaje",
                                            text: "Registro exitoso.",
                                            icon: "success",
                                            showCancelButton: false, 
                                            confirmButtonText: "OK" 
                                        }).then(function() {
                                            window.open("../historial_clinico/select.php?id=' . $id_mascotaa . '&clienteee=' . $id_clientee . '", "_SELF");
                                        });
                                    </script>';
                                } else {
                                    echo '<script type="text/javascript">
                                        swal({
                                            title: "Error",
                                            text: "Hubo un problema al guardar el registro: ' . addslashes(mysqli_error($conexion)) . '",
                                            icon: "error",
                                            showCancelButton: false, 
                                            confirmButtonText: "OK" 
                                        });
                                    </script>';
                                }
                            } else {
                                echo '<script type="text/javascript">
                                    swal({
                                        title: "Mensaje",
                                        text: "Por favor, complete los campos obligatorios (Mascota, Cliente, Fecha, Pulso, Cardio y Atendido por).",
                                        icon: "error",
                                        showCancelButton: false, 
                                        confirmButtonText: "OK" 
                                    }).then(function() {
                                        window.open("insert.php?id_mascotaa=' . $id_mascotaa . '&id_clientee=' . $id_clientee . '", "_SELF");
                                    });
                                </script>';
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