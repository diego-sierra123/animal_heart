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

            <?php
            $idpac = '';
            $cli = '';
            $mas = '';
            $fec = '';
            $dia = '';
            $tra = '';
            $ins = '';
            $fecpro = '';
            $pul = '';
            $car = '';
            $vac = '';
            $fecvac = '';
            $des = '';
            $fecdes = '';
            $emp = '';
            $id_mascota = 0;
            $id_cliente = 0;
            $serv = '';

            if (isset($_GET['id_mascota']) && isset($_GET['id_cliente']) && isset($_GET['id_historia'])) {
                $id_mascota = intval($_GET['id_mascota']);
                $id_historia = intval($_GET['id_historia']);
                $id_cliente = intval($_GET['id_cliente']);

                $consulta = "SELECT * FROM historial_clinico WHERE id_historial_clinico = '$id_historia'";
                $ejecutar = mysqli_query($conexion, $consulta);
                
                if ($ejecutar && mysqli_num_rows($ejecutar) > 0) {
                    $fila = mysqli_fetch_assoc($ejecutar);
                    $idpac = $fila['id_historial_clinico'];
                    $cli = $fila['id_cliente'];
                    $mas = $fila['id_mascota'];
                    $fec = $fila['fecha_visita'];
                    $dia = $fila['diagnostico'];
                    $tra = $fila['id_tratamiento'];
                    $ins = $fila['instrucciones'];
                    $fecpro = $fila['fecha_proxima_cita'];
                    $pul = $fila['pulso'];
                    $car = $fila['cardio'];
                    $vac = $fila['id_vacuna'];
                    $fecvac = $fila['fecha_vacuna'];
                    $des = $fila['id_desparasitante'];
                    $fecdes = $fila['fecha_desparasitante'];
                    $emp = $fila['id_empleado'];
                    $serv = $fila['id_nom_servicio'];
                }
            }
            
            // Obtener nombres para mostrar
            $nombre_mascota = '';
            $nombre_cliente = '';
            if ($mas > 0) {
                $cons_nom_mas = "SELECT nombre FROM mascota WHERE id_mascota = $mas";
                $res_nom_mas = mysqli_query($conexion, $cons_nom_mas);
                if ($res_nom_mas && mysqli_num_rows($res_nom_mas) > 0) {
                    $nombre_mascota = mysqli_fetch_assoc($res_nom_mas)['nombre'];
                }
            }
            if ($cli > 0) {
                $cons_nom_cli = "SELECT nombres FROM cliente WHERE id_cliente = $cli";
                $res_nom_cli = mysqli_query($conexion, $cons_nom_cli);
                if ($res_nom_cli && mysqli_num_rows($res_nom_cli) > 0) {
                    $nombre_cliente = mysqli_fetch_assoc($res_nom_cli)['nombres'];
                }
            }
            ?>

            <div class="row justify-content-center mt-5">
                <div class="col-10 col-sm-8 col-md-7 col-lg-6 custom-border background-image">
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>ACTUALIZAR HISTORIA CLINICA</b></h2>

                    <form class="mt-3" action="update.php" method="post">
                        <br>

                        <div class="row mb-3 d-none">
                            <div class="col-md-12">
                                <label class="form-label">Id Historia:</label>
                                <input type="text" name="txtid" value="<?php echo $idpac; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Mascota:</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($nombre_mascota); ?>" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" readonly disabled>
                                <input type="hidden" name="txtmascota" value="<?php echo $mas; ?>">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Cliente:</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($nombre_cliente); ?>" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" readonly disabled>
                                <input type="hidden" name="txtcliente" value="<?php echo $cli; ?>">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha:</label>
                                <input type="date" name="txtfecha" value="<?php echo $fec; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Pulso:</label>
                                <input type="number" min="0" name="txtpulso" value="<?php echo $pul; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Cardio:</label>
                                <input type="number" min="0" name="txtcardio" value="<?php echo $car; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Atendido por:</label>
                                <select name="txtempleado" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <?php
                                    $consulta = "SELECT * FROM empleado";
                                    $ejecutar = mysqli_query($conexion, $consulta);
                                    while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                        $selected = ($respuesta['id_empleado'] == $emp) ? 'selected' : '';
                                        echo "<option value='" . $respuesta['id_empleado'] . "' $selected>" . htmlspecialchars($respuesta['nombre']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Diagnóstico:</label>
                                <textarea name="txtdiagnostico" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" rows="3"><?php echo htmlspecialchars($dia); ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Instrucciones:</label>
                                <textarea name="txtinstrucciones" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" rows="3"><?php echo htmlspecialchars($ins); ?></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha Proxima:</label>
                                <input type="date" name="txtfechapro" value="<?php echo $fecpro; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Tratamiento:</label>
                                <select name="txttratamiento" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;">
                                    <?php
                                    // Siempre mostrar la opción N/A
                                    $selected_na = ($tra == 1) ? 'selected' : '';

                                    if ($mas != 1) {
                                    echo "<option value='1' $selected_na>N/A</option>";
                                    }

                                    $consulta_tratamientos = "SELECT id_tratamiento, medicamentos AS tratamiento FROM tratamiento WHERE id_mascota = '$mas'";
                                    $ejecutar_tratamientos = mysqli_query($conexion, $consulta_tratamientos);
                                    if(mysqli_num_rows($ejecutar_tratamientos) > 0) {
                                        while ($respuesta = mysqli_fetch_assoc($ejecutar_tratamientos)) {
                                            $selected = ($respuesta['id_tratamiento'] == $tra) ? 'selected' : '';
                                            echo "<option value='" . $respuesta['id_tratamiento'] . "' $selected>" . htmlspecialchars($respuesta['tratamiento']) . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Servicio:</label>
                                <select name="txtservicio" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <?php
                                    $consulta_servicios = "SELECT * FROM nom_servicio";
                                    $ejecutar_servicios = mysqli_query($conexion, $consulta_servicios);
                                    while ($respuesta = mysqli_fetch_assoc($ejecutar_servicios)) {
                                        $selected = ($respuesta['id_nom_servicio'] == $serv) ? 'selected' : '';
                                        echo "<option value='" . $respuesta['id_nom_servicio'] . "' $selected>" . htmlspecialchars($respuesta['nombre']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Vacuna:</label>
                                <select name="txtvacuna" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;">
                                    <?php
                                    $consulta = "SELECT * FROM vacuna";
                                    $ejecutar = mysqli_query($conexion, $consulta);
                                    while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                        $selected = ($respuesta['id_vacuna'] == $vac) ? 'selected' : '';
                                        echo "<option value='" . $respuesta['id_vacuna'] . "' $selected>" . htmlspecialchars($respuesta['nombre']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha Vacuna:</label>
                                <input type="date" name="txtfechavacuna" value="<?php echo $fecvac; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Desparasitante:</label>
                                <select name="txtdesparasitante" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;">
                                    <?php
                                    $consulta = "SELECT * FROM desparasitante";
                                    $ejecutar = mysqli_query($conexion, $consulta);
                                    while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                        $selected = ($respuesta['id_desparasitante'] == $des) ? 'selected' : '';
                                        echo "<option value='" . $respuesta['id_desparasitante'] . "' $selected>" . htmlspecialchars($respuesta['nombre']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha Desparasitante:</label>
                                <input type="date" name="txtfechadesparasitante" value="<?php echo $fecdes; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;">
                            </div>
                        </div>

                        <br>
                        <div class="row justify-content-center">
                            <div class="col-10 col-sm-8 col-md-7 col-lg-6 m-4 text-center">
                                <br>
                                <div class="row">
                                    <div class="col">
                                        <a href="../historial_clinico/select.php?id=<?php echo $mas; ?>&clienteee=<?php echo $cli; ?>" class="btn btn-secondary m-2">Atrás</a>
                                    </div>
                                    <div class="col">
                                        <input type="submit" name="actualizar" value="Actualizar" class="btn btn-primary mb-5 m-2">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        if (isset($_POST["actualizar"])) {
                            $idPac = mysqli_real_escape_string($conexion, $_POST["txtid"]);
                            $mas = mysqli_real_escape_string($conexion, $_POST["txtmascota"]);
                            $cli = mysqli_real_escape_string($conexion, $_POST["txtcliente"]);
                            $fec = mysqli_real_escape_string($conexion, $_POST["txtfecha"]);
                            $pul = mysqli_real_escape_string($conexion, $_POST["txtpulso"]);
                            $car = mysqli_real_escape_string($conexion, $_POST["txtcardio"]);
                            $emp = $_POST["txtempleado"];
                            $dia = mysqli_real_escape_string($conexion, $_POST["txtdiagnostico"]);
                            $ins = mysqli_real_escape_string($conexion, $_POST["txtinstrucciones"]);
                            $fecpro = !empty($_POST["txtfechapro"]) ? mysqli_real_escape_string($conexion, $_POST["txtfechapro"]) : null;
                            $tra = $_POST["txttratamiento"];
                            $vac = $_POST["txtvacuna"];
                            $fecvac = !empty($_POST["txtfechavacuna"]) ? mysqli_real_escape_string($conexion, $_POST["txtfechavacuna"]) : null;
                            $des = $_POST["txtdesparasitante"];
                            $fecdes = !empty($_POST["txtfechadesparasitante"]) ? mysqli_real_escape_string($conexion, $_POST["txtfechadesparasitante"]) : null;
                            $serv = $_POST["txtservicio"];

                            if (empty($idPac) || empty($mas) || empty($cli) || empty($fec) || empty($pul) || empty($car) || empty($emp)) {
                                echo '<script type="text/javascript">
                                swal({
                                    title: "Mensaje",
                                    text: "Por favor, complete los campos obligatorios.",
                                    icon: "error",
                                    showCancelButton: false,
                                    confirmButtonText: "OK"
                                }).then(function() {
                                    window.open("update.php?id_mascota=' . $mas . '&id_cliente=' . $cli . '&id_historia=' . $idPac . '", "_SELF");
                                });
                                </script>';
                            } else {
                                $sql = "UPDATE historial_clinico SET 
                                        fecha_visita = '$fec', 
                                        diagnostico = '$dia', 
                                        id_tratamiento = '$tra', 
                                        instrucciones = '$ins', 
                                        fecha_proxima_cita = " . ($fecpro ? "'$fecpro'" : "NULL") . ", 
                                        pulso = '$pul', 
                                        cardio = '$car', 
                                        id_vacuna = '$vac', 
                                        fecha_vacuna = " . ($fecvac ? "'$fecvac'" : "NULL") . ", 
                                        id_desparasitante = '$des', 
                                        fecha_desparasitante = " . ($fecdes ? "'$fecdes'" : "NULL") . ", 
                                        id_empleado = '$emp',
                                        id_nom_servicio = '$serv'
                                        WHERE id_historial_clinico = '$idPac'";
                                
                                $ejecutar = mysqli_query($conexion, $sql);
                                
                                if ($ejecutar) {
                                    echo '<script type="text/javascript">
                                        swal({
                                            title: "Mensaje",
                                            text: "Registro Actualizado exitosamente.",
                                            icon: "success",
                                            showCancelButton: false, 
                                            confirmButtonText: "OK" 
                                        }).then(function() {
                                            window.open("select.php?id=' . $mas . '&clienteee=' . $cli . '", "_SELF");
                                        });
                                    </script>';
                                } else {
                                    echo '<script type="text/javascript">
                                        swal({
                                            title: "Error",
                                            text: "Hubo un problema al actualizar el registro: ' . addslashes(mysqli_error($conexion)) . '",
                                            icon: "error",
                                            showCancelButton: false, 
                                            confirmButtonText: "OK" 
                                        });
                                    </script>';
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