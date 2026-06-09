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
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>AGREGAR CITA</b></h2>

                    <form class="mt-3" name="insert" action="insert.php" method="post">
                        <br>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha:</label>
                                <?php
                                $hora_actual = date('Y-m-d H:i:s');
                                $horas_a_retrasar = 7;
                                $nueva_fecha = date('Y-m-d', strtotime($hora_actual . ' - ' . $horas_a_retrasar . ' hours'));
                                ?>
                                <input type="date" name="txtfecha" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" min="<?php echo $nueva_fecha; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Hora:</label>
                                <input type="time" name="txthora" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Cliente:</label>
                                <select name="txtcliente" id="clientee" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <option value="">Seleccione un cliente</option>
                                    <?php
                                    $consulta = "SELECT * FROM cliente";
                                    $ejecutar = mysqli_query($conexion, $consulta);
                                    while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                        echo "<option value='" . $respuesta['id_cliente'] . "'>" . htmlspecialchars($respuesta['nombres'] . " " . $respuesta['apellidos']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Mascota:</label>
                                <select name="txtmascota" id="mascotaa" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <option value="">Seleccione una mascota</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Estado Cita:</label>
                                <select name="txtestado" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <option value="">Seleccione un estado</option>
                                    <?php
                                    $consulta = "SELECT * FROM estado_cita";
                                    $ejecutar = mysqli_query($conexion, $consulta);
                                    while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                        if ($respuesta['id_estado_cita'] == 1) {
                                            echo "<option value='" . $respuesta['id_estado_cita'] . "'>" . htmlspecialchars($respuesta['nombre']) . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Servicio:</label>
                                <select name="txtservicio" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <option value="">Seleccione un servicio</option>
                                    <?php
                                    $consulta = "SELECT * FROM nom_servicio";
                                    $ejecutar = mysqli_query($conexion, $consulta);
                                    while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                        echo "<option value='" . $respuesta['id_nom_servicio'] . "'>" . htmlspecialchars($respuesta['nombre']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Descripción:</label>
                                <textarea name="txtdescripcion" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" rows="3"></textarea>
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
                                        <input type="submit" name="enviar" value="Agregar" class="btn btn-success mb-5 m-2">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        if (isset($_POST["enviar"])) {
                            $fecha = mysqli_real_escape_string($conexion, $_POST["txtfecha"]);
                            $hora = mysqli_real_escape_string($conexion, $_POST["txthora"]);
                            $cliente = intval($_POST["txtcliente"]);
                            $mascota = intval($_POST["txtmascota"]);
                            $estado = intval($_POST["txtestado"]);
                            $servicio = intval($_POST["txtservicio"]);
                            $descripcion = mysqli_real_escape_string($conexion, $_POST["txtdescripcion"]);

                            if (empty($fecha) || empty($hora) || empty($cliente) || empty($mascota) || empty($estado) || empty($servicio)) {
                                echo '<script type="text/javascript">
                                    swal({
                                        title: "Mensaje",
                                        text: "Por favor, complete todos los campos obligatorios.",
                                        icon: "error",
                                        showCancelButton: false, 
                                        confirmButtonText: "OK" 
                                    });
                                </script>';
                            } else {
                                // Validar rango de hora (9 AM a 12 PM y 2 PM a 7 PM)
                                $hora_seleccionada = strtotime($hora);
                                $hora_minima_manana = strtotime("09:00:00");
                                $hora_maxima_manana = strtotime("12:00:00");
                                $hora_minima_tarde = strtotime("14:00:00");
                                $hora_maxima_tarde = strtotime("18:00:00");

                                if (
                                    ($hora_seleccionada >= $hora_minima_manana && $hora_seleccionada <= $hora_maxima_manana) ||
                                    ($hora_seleccionada >= $hora_minima_tarde && $hora_seleccionada <= $hora_maxima_tarde)
                                ) {
                                    // Verificar si ya existe una cita en la misma fecha y hora exacta
                                    $consulta_existente = "SELECT id_cita FROM cita WHERE fecha = '$fecha' AND hora = '$hora' AND id_estado_cita = 1";
                                    $resultado_existente = mysqli_query($conexion, $consulta_existente);

                                    if (mysqli_num_rows($resultado_existente) > 0) {
                                        echo '<script type="text/javascript">
                                            swal({
                                                title: "Mensaje",
                                                text: "Ya existe una cita en la misma fecha y hora.",
                                                icon: "error",
                                                showCancelButton: false, 
                                                confirmButtonText: "OK" 
                                            });
                                        </script>';
                                    } else {
                                        // Verificar diferencia de 20 minutos con otras citas
                                        $consulta_citas = "SELECT hora FROM cita WHERE fecha = '$fecha' AND id_estado_cita = 1";
                                        $resultado_citas = mysqli_query($conexion, $consulta_citas);
                                        
                                        $puede_insertar = true;
                                        while ($fila = mysqli_fetch_assoc($resultado_citas)) {
                                            $hora_existente = strtotime($fila['hora']);
                                            $diferencia = abs($hora_seleccionada - $hora_existente);
                                            if ($diferencia < 1200) { // 20 minutos en segundos
                                                $puede_insertar = false;
                                                break;
                                            }
                                        }

                                        if ($puede_insertar) {
                                            $sql = "INSERT INTO cita (fecha, hora, id_cliente, id_mascota, id_estado_cita, id_nom_servicio, descripcion, id_ver) 
                                                    VALUES ('$fecha', '$hora', '$cliente', '$mascota', '$estado', '$servicio', '$descripcion', 1)";
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
                                                        window.open("select.php", "_SELF");
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
                                                    text: "La hora seleccionada no cumple con la diferencia de 20 minutos con otras citas ya existentes.",
                                                    icon: "error",
                                                    showCancelButton: false, 
                                                    confirmButtonText: "OK" 
                                                });
                                            </script>';
                                        }
                                    }
                                } else {
                                    echo '<script type="text/javascript">
                                        swal({
                                            title: "Mensaje",
                                            text: "La hora seleccionada está fuera del rango permitido (9 AM a 12 PM y 2 PM a 6 PM).",
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
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#clientee').change(function() {
            var clienteSeleccionado = $(this).val();
            if (clienteSeleccionado) {
                $.ajax({
                    url: 'obtener_mascotas.php',
                    type: 'POST',
                    data: { cliente: clienteSeleccionado },
                    dataType: 'json',
                    success: function(response) {
                        $("#mascotaa").empty();
                        $("#mascotaa").append("<option value=''>Seleccione la mascota</option>");
                        for (var i = 0; i < response.length; i++) {
                            $("#mascotaa").append("<option value='" + response[i].id_mascota + "'>" + response[i].nombre + "</option>");
                        }
                    }
                });
            } else {
                $("#mascotaa").empty();
                $("#mascotaa").append("<option value=''>Seleccione una mascota</option>");
            }
        });
    });
</script>

<?php include("../template_ingreso_admin/pie.php") ?>