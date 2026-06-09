<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION["id_rol"] != 3) {
    header("Location: ../login.php");
    exit();
}
?>

<?php include("../database/conexion.php") ?>

<?php include("../template_ingreso_cliente/cabecera.php") ?>

<!-- SweetAlert2 CSS y JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php include("../template_ingreso_cliente/menu.php") ?>

<div class="container-fluid container-main">
    <div class="container">
        <div class="row justify-content-center">

            <?php
            // Variable para almacenar el ID de la cita
            $idpac = null;
            
            // Verificar si ya tenemos el ID por GET (primera carga) o por POST (después de un error)
            if (isset($_GET['actualizar'])) {
                $idpac = mysqli_real_escape_string($conexion, $_GET['actualizar']);
            } elseif (isset($_POST['txtid'])) {
                $idpac = mysqli_real_escape_string($conexion, $_POST['txtid']);
            }
            
            if ($idpac) {
                $consulta = "SELECT ci.*, m.nombre AS mascota_nombre 
                             FROM cita ci
                             INNER JOIN mascota m ON ci.id_mascota = m.id_mascota
                             WHERE ci.id_cita = '$idpac' AND ci.id_cliente = '" . $_SESSION['id'] . "'";
                $ejecutar = mysqli_query($conexion, $consulta);

                if ($ejecutar && mysqli_num_rows($ejecutar) > 0) {
                    $fila = mysqli_fetch_assoc($ejecutar);
                    $fec = $fila['fecha'];
                    $hor = $fila['hora'];
                    $mas = $fila['id_mascota'];
                    $ser = $fila['id_nom_servicio'];
                    $des = $fila['descripcion'];
                    $mascota_nombre = $fila['mascota_nombre'];
                } else {
                    echo '<div class="alert alert-danger">Cita no encontrada o no tienes permisos para editarla.</div>';
                    echo '<a href="historialcita.php" class="btn btn-secondary">Volver</a>';
                    exit;
                }
            } else {
                echo '<div class="alert alert-warning">No se especificó qué cita actualizar.</div>';
                echo '<a href="historialcita.php" class="btn btn-secondary">Volver a citas</a>';
                exit;
            }
            ?>

            <div class="row justify-content-center mt-5">
                <div class="col-10 col-sm-8 col-md-7 col-lg-6 custom-border background-image">
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>ACTUALIZAR CITA</b></h2>

                    <form class="row justify-content-center align-content-center g-3 mt-3" name="insert" action="updatehistorialcita.php" method="post">
                        <br>

                        <!-- ID Oculto -->
                        <input type="hidden" name="txtid" value="<?php echo $idpac; ?>">

                        <!-- Fecha -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha:</label>
                            <input type="date" name="txtfecha" value="<?php echo $fec; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Hora -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Hora:</label>
                            <input type="time" name="txthora" value="<?php echo $hor; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Cliente (solo lectura) -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Cliente:</label>
                            <?php
                            $consulta_cliente = "SELECT nombres, apellidos FROM cliente WHERE id_cliente = " . $_SESSION['id'];
                            $resultado_cliente = mysqli_query($conexion, $consulta_cliente);
                            $cliente = mysqli_fetch_assoc($resultado_cliente);
                            ?>
                            <input type="text" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" value="<?php echo $cliente['nombres'] . ' ' . $cliente['apellidos']; ?>" readonly>
                            <input type="hidden" name="txtcliente" value="<?php echo $_SESSION['id']; ?>">
                        </div>

                        <!-- Mascota -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Mascota:</label>
                            <select name="txtmascota" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                <?php
                                $consulta_mascotas = "SELECT id_mascota, nombre FROM mascota WHERE id_cliente = " . $_SESSION['id'];
                                $resultado_mascotas = mysqli_query($conexion, $consulta_mascotas);
                                while ($mascota = mysqli_fetch_assoc($resultado_mascotas)) {
                                    $selected = ($mascota['id_mascota'] == $mas) ? 'selected' : '';
                                    echo "<option value='" . $mascota['id_mascota'] . "' $selected>" . $mascota['nombre'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Estado Cita (solo lectura) -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Estado Cita:</label>
                            <input type="text" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" value="Pendiente" readonly>
                            <input type="hidden" name="txtestado" value="1">
                        </div>

                        <!-- Servicio -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Servicio:</label>
                            <select name="txtservicio" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                <?php
                                $consulta_servicios = "SELECT * FROM nom_servicio";
                                $resultado_servicios = mysqli_query($conexion, $consulta_servicios);
                                while ($servicio = mysqli_fetch_assoc($resultado_servicios)) {
                                    $selected = ($servicio['id_nom_servicio'] == $ser) ? 'selected' : '';
                                    echo "<option value='" . $servicio['id_nom_servicio'] . "' $selected>" . $servicio['nombre'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Descripción -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Descripción:</label>
                            <textarea name="txtdescripcion" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000; height: 60px;"><?php echo htmlspecialchars($des); ?></textarea>
                        </div>

                        <br>
                        <br>
                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 m-4 text-center">
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="historialcita.php" class="btn btn-secondary m-2">Atrás</a>
                                </div>
                                <div class="col">
                                    <input type="submit" name="actualizar" value="Actualizar" class="btn btn-primary mb-5 m-2">
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST["actualizar"])) {
                        $idPac = mysqli_real_escape_string($conexion, $_POST["txtid"]);
                        $fec = mysqli_real_escape_string($conexion, $_POST["txtfecha"]);
                        $hor = mysqli_real_escape_string($conexion, $_POST["txthora"]);
                        $cli = mysqli_real_escape_string($conexion, $_POST["txtcliente"]);
                        $mas = mysqli_real_escape_string($conexion, $_POST["txtmascota"]);
                        $est = mysqli_real_escape_string($conexion, $_POST["txtestado"]);
                        $ser = mysqli_real_escape_string($conexion, $_POST["txtservicio"]);
                        $dess = mysqli_real_escape_string($conexion, $_POST["txtdescripcion"]);

                        if (empty($idPac) || empty($fec) || empty($hor) || empty($cli) || empty($mas) || empty($est) || empty($ser)) {
                            echo '<script type="text/javascript">
                            Swal.fire({
                                title: "Mensaje",
                                text: "Por favor, complete todos los campos obligatorios.",
                                icon: "error",
                                showCancelButton: false,
                                confirmButtonText: "OK"
                            }).then(function() {
                                window.location.href = "updatehistorialcita.php?actualizar=' . $idPac . '";
                            });
                            </script>';
                        } else {
                            // Verificar rango de hora
                            $hora_seleccionada = strtotime($hor);
                            $hora_minima_manana = strtotime("09:00:00");
                            $hora_maxima_manana = strtotime("12:00:00");
                            $hora_minima_tarde = strtotime("14:00:00");
                            $hora_maxima_tarde = strtotime("18:00:00");

                            if (
                                ($hora_seleccionada >= $hora_minima_manana && $hora_seleccionada <= $hora_maxima_manana) ||
                                ($hora_seleccionada >= $hora_minima_tarde && $hora_seleccionada <= $hora_maxima_tarde)
                            ) {
                                // Verificar citas existentes con diferencia de 20 minutos
                                $consulta_citas_anteriores = "SELECT hora FROM cita WHERE fecha = '$fec' AND id_estado_cita = 1 AND id_cita != '$idPac'";
                                $resultado_citas_anteriores = mysqli_query($conexion, $consulta_citas_anteriores);

                                $puede_actualizar = true;
                                while ($fila = mysqli_fetch_assoc($resultado_citas_anteriores)) {
                                    $hora_existente = strtotime($fila['hora']);
                                    $diferencia = abs($hora_seleccionada - $hora_existente);
                                    if ($diferencia < 1200) {
                                        $puede_actualizar = false;
                                        break;
                                    }
                                }

                                if ($puede_actualizar) {
                                    $sql = "UPDATE cita SET fecha='$fec', hora='$hor', id_cliente='$cli', id_mascota='$mas', id_estado_cita='$est', id_nom_servicio='$ser', descripcion='$dess' WHERE id_cita='$idPac'";
                                    $ejecutar = mysqli_query($conexion, $sql);

                                    if ($ejecutar) {
                                        echo '<script type="text/javascript">
                                        Swal.fire({
                                            title: "Mensaje",
                                            text: "Cita actualizada exitosamente.",
                                            icon: "success",
                                            showCancelButton: false,
                                            confirmButtonText: "OK"
                                        }).then(function() {
                                            window.location.href = "historialcita.php";
                                        });
                                        </script>';
                                    } else {
                                        echo '<script type="text/javascript">
                                        Swal.fire({
                                            title: "Error",
                                            text: "Hubo un problema al actualizar la cita.",
                                            icon: "error",
                                            showCancelButton: false,
                                            confirmButtonText: "OK"
                                        }).then(function() {
                                            window.location.href = "updatehistorialcita.php?actualizar=' . $idPac . '";
                                        });
                                        </script>';
                                    }
                                } else {
                                    echo '<script type="text/javascript">
                                    Swal.fire({
                                        title: "Mensaje",
                                        text: "La hora seleccionada no cumple con la diferencia de 20 minutos con otras citas en la misma fecha.",
                                        icon: "error",
                                        showCancelButton: false,
                                        confirmButtonText: "OK"
                                    }).then(function() {
                                        window.location.href = "updatehistorialcita.php?actualizar=' . $idPac . '";
                                    });
                                    </script>';
                                }
                            } else {
                                echo '<script type="text/javascript">
                                Swal.fire({
                                    title: "Mensaje",
                                    text: "La hora seleccionada está fuera del rango permitido (9 AM a 12 PM y 2 PM a 6 PM).",
                                    icon: "error",
                                    showCancelButton: false,
                                    confirmButtonText: "OK"
                                }).then(function() {
                                    window.location.href = "updatehistorialcita.php?actualizar=' . $idPac . '";
                                });
                                </script>';
                            }
                        }
                    }
                    ?>
                </div>
                <br>
                <br>
            </div>

        </div>
        <br>
        <br>
    </div>
</div>

<?php include("../template_ingreso_cliente/pie.php") ?>