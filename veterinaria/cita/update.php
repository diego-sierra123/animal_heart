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
            $id_cita = 0;
            $fecha = '';
            $hora = '';
            $id_cliente = 0;
            $id_mascota = 0;
            $id_estado = 0;
            $id_servicio = 0;
            $descripcion = '';

            if (isset($_GET['actualizar'])) {
                $id_cita = intval($_GET['actualizar']);
                $consulta = "SELECT * FROM cita WHERE id_cita = '$id_cita'";
                $ejecutar = mysqli_query($conexion, $consulta);
                
                if ($ejecutar && mysqli_num_rows($ejecutar) > 0) {
                    $fila = mysqli_fetch_assoc($ejecutar);
                    $fecha = $fila['fecha'];
                    $hora = $fila['hora'];
                    $id_cliente = $fila['id_cliente'];
                    $id_mascota = $fila['id_mascota'];
                    $id_estado = $fila['id_estado_cita'];
                    $id_servicio = $fila['id_nom_servicio'];
                    $descripcion = $fila['descripcion'];
                }
            }
            ?>

            <div class="row justify-content-center mt-5">
                <div class="col-10 col-sm-8 col-md-7 col-lg-6 custom-border background-image">
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>ACTUALIZAR CITA</b></h2>

                    <form class="mt-3" action="update.php" method="post">
                        <br>

                        <div class="row mb-3 d-none">
                            <div class="col-md-12">
                                <label class="form-label">Id Cita:</label>
                                <input type="text" name="txtid" value="<?php echo $id_cita; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha:</label>
                                <input type="date" name="txtfecha" value="<?php echo $fecha; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Hora:</label>
                                <input type="time" name="txthora" value="<?php echo $hora; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Cliente:</label>
                                <select name="txtcliente" id="txtcliente" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <?php
                                    $consulta = "SELECT * FROM cliente";
                                    $ejecutar = mysqli_query($conexion, $consulta);
                                    while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                        $selected = ($respuesta['id_cliente'] == $id_cliente) ? 'selected' : '';
                                        echo "<option value='" . $respuesta['id_cliente'] . "' $selected>" . htmlspecialchars($respuesta['nombres'] . " " . $respuesta['apellidos']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Mascota:</label>
                                <select name="txtmascota" id="txtmascota" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <?php
                                    $consulta = "SELECT * FROM mascota WHERE id_cliente = '$id_cliente'";
                                    $ejecutar = mysqli_query($conexion, $consulta);
                                    while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                        $selected = ($respuesta['id_mascota'] == $id_mascota) ? 'selected' : '';
                                        echo "<option value='" . $respuesta['id_mascota'] . "' $selected>" . htmlspecialchars($respuesta['nombre']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Estado Cita:</label>
                                <select name="txtestado" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <?php
                                    $consulta = "SELECT * FROM estado_cita";
                                    $ejecutar = mysqli_query($conexion, $consulta);
                                    while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                        $selected = ($respuesta['id_estado_cita'] == $id_estado) ? 'selected' : '';
                                        echo "<option value='" . $respuesta['id_estado_cita'] . "' $selected>" . htmlspecialchars($respuesta['nombre']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Servicio:</label>
                                <select name="txtservicio" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <?php
                                    $consulta = "SELECT * FROM nom_servicio";
                                    $ejecutar = mysqli_query($conexion, $consulta);
                                    while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                        $selected = ($respuesta['id_nom_servicio'] == $id_servicio) ? 'selected' : '';
                                        echo "<option value='" . $respuesta['id_nom_servicio'] . "' $selected>" . htmlspecialchars($respuesta['nombre']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Descripción:</label>
                                <textarea name="txtdescripcion" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" rows="3"><?php echo htmlspecialchars($descripcion); ?></textarea>
                            </div>
                        </div>

                        <br>
                        <div class="row justify-content-center">
                            <div class="col-10 col-sm-8 col-md-7 col-lg-6 m-4 text-center">
                                <br>
                                <div class="row">
                                    <div class="col">
                                        <a href="select.php" class="btn btn-secondary m-2">Atrás</a>
                                    </div>
                                    <div class="col">
                                        <input type="submit" name="actualizar" value="Actualizar" class="btn btn-primary mb-5 m-2">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        if (isset($_POST["actualizar"])) {
                            $idPac = intval($_POST["txtid"]);
                            $fec = mysqli_real_escape_string($conexion, $_POST["txtfecha"]);
                            $hor = mysqli_real_escape_string($conexion, $_POST["txthora"]);
                            $cli = intval($_POST["txtcliente"]);
                            $mas = intval($_POST["txtmascota"]);
                            $est = intval($_POST["txtestado"]);
                            $ser = intval($_POST["txtservicio"]);
                            $des = mysqli_real_escape_string($conexion, $_POST["txtdescripcion"]);

                            if (empty($idPac) || empty($fec) || empty($hor) || empty($cli) || empty($mas) || empty($est) || empty($ser)) {
                                echo '<script type="text/javascript">
                                    swal({
                                        title: "Mensaje",
                                        text: "Por favor, complete todos los campos obligatorios.",
                                        icon: "error",
                                        showCancelButton: false,
                                        confirmButtonText: "OK"
                                    }).then(function() {
                                        window.open("update.php?actualizar=' . $idPac . '", "_SELF");
                                    });
                                </script>';
                            } else {
                                // Validar rango de hora
                                $hora_seleccionada = strtotime($hor);
                                $hora_minima_manana = strtotime("09:00:00");
                                $hora_maxima_manana = strtotime("12:00:00");
                                $hora_minima_tarde = strtotime("14:00:00");
                                $hora_maxima_tarde = strtotime("18:00:00");

                                if (
                                    ($hora_seleccionada >= $hora_minima_manana && $hora_seleccionada <= $hora_maxima_manana) ||
                                    ($hora_seleccionada >= $hora_minima_tarde && $hora_seleccionada <= $hora_maxima_tarde)
                                ) {
                                    // Verificar diferencia de 20 minutos con otras citas
                                    $consulta_citas = "SELECT hora FROM cita WHERE fecha = '$fec' AND id_estado_cita = 1 AND id_cita != '$idPac'";
                                    $resultado_citas = mysqli_query($conexion, $consulta_citas);
                                    
                                    $puede_actualizar = true;
                                    while ($fila = mysqli_fetch_assoc($resultado_citas)) {
                                        $hora_existente = strtotime($fila['hora']);
                                        $diferencia = abs($hora_seleccionada - $hora_existente);
                                        if ($diferencia < 1200) {
                                            $puede_actualizar = false;
                                            break;
                                        }
                                    }

                                    if ($puede_actualizar) {
                                        $sql = "UPDATE cita SET 
                                                fecha = '$fec', 
                                                hora = '$hor', 
                                                id_cliente = '$cli', 
                                                id_mascota = '$mas', 
                                                id_estado_cita = '$est', 
                                                id_nom_servicio = '$ser', 
                                                descripcion = '$des' 
                                                WHERE id_cita = '$idPac'";
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
                                                    window.open("select.php", "_SELF");
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
                                    } else {
                                        echo '<script type="text/javascript">
                                            swal({
                                                title: "Mensaje",
                                                text: "La hora seleccionada no cumple con la diferencia de 20 minutos con otras citas en la misma fecha.",
                                                icon: "error",
                                                showCancelButton: false,
                                                confirmButtonText: "OK"
                                            }).then(function() {
                                                window.open("update.php?actualizar=' . $idPac . '", "_SELF");
                                            });
                                        </script>';
                                    }
                                } else {
                                    echo '<script type="text/javascript">
                                        swal({
                                            title: "Mensaje",
                                            text: "La hora seleccionada está fuera del rango permitido (9 AM a 12 PM y 2 PM a 6 PM).",
                                            icon: "error",
                                            showCancelButton: false,
                                            confirmButtonText: "OK"
                                        }).then(function() {
                                            window.open("update.php?actualizar=' . $idPac . '", "_SELF");
                                        });
                                    </script>';
                                }
                            }
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#txtcliente').change(function() {
            var clienteId = $(this).val();
            if (clienteId) {
                $.ajax({
                    url: 'obtener_mascotas.php',
                    type: 'POST',
                    data: { cliente: clienteId },
                    dataType: 'json',
                    success: function(response) {
                        $("#txtmascota").empty();
                        for (var i = 0; i < response.length; i++) {
                            $("#txtmascota").append("<option value='" + response[i].id_mascota + "'>" + response[i].nombre + "</option>");
                        }
                    }
                });
            }
        });
    });
</script>

<?php include("../template_ingreso_admin/pie.php") ?>