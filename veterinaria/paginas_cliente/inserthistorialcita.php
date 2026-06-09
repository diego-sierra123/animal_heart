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
            // Obtener datos del cliente
            $id_cliente = $_SESSION['id'];
            $consulta_cliente = "SELECT nombres, apellidos FROM cliente WHERE id_cliente = $id_cliente";
            $resultado_cliente = mysqli_query($conexion, $consulta_cliente);
            $cliente = mysqli_fetch_assoc($resultado_cliente);
            $nombre_cliente = $cliente['nombres'] . ' ' . $cliente['apellidos'];
            ?>

            <div class="row justify-content-center mt-5">
                <div class="col-10 col-sm-8 col-md-7 col-lg-6 custom-border background-image">
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>AGREGAR CITA</b></h2>

                    <form class="row justify-content-center align-content-center g-3 mt-3" name="inserthistorialcita" action="inserthistorialcita.php" method="post">
                        <br>

                        <!-- Fecha -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha:</label>
                            <?php
                            $hora_actual = date('Y-m-d H:i:s');
                            $horas_a_retrasar = 7;
                            $nueva_fecha = date('Y-m-d', strtotime($hora_actual . ' - ' . $horas_a_retrasar . ' hours'));
                            ?>
                            <input type="date" name="txtfecha" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" min="<?php echo $nueva_fecha; ?>" required>
                        </div>

                        <!-- Hora -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Hora:</label>
                            <input type="time" name="txthora" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Cliente -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Cliente:</label>
                            <input type="text" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" value="<?php echo $nombre_cliente; ?>" readonly>
                            <input type="hidden" name="txtcliente" value="<?php echo $_SESSION['id']; ?>">
                        </div>

                        <!-- Mascota -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Mascota:</label>
                            <select name="txtmascota" id="mascotaa" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                <option value="">Seleccione la mascota</option>
                                <?php
                                $consulta_mascotas = "SELECT id_mascota, nombre FROM mascota WHERE id_cliente = " . $_SESSION['id'];
                                $resultado_mascotas = mysqli_query($conexion, $consulta_mascotas);
                                while ($mascota = mysqli_fetch_assoc($resultado_mascotas)) {
                                    echo "<option value='" . $mascota['id_mascota'] . "'>" . $mascota['nombre'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Estado Cita (oculto, siempre pendiente) -->
                        <input type="hidden" name="txtestado" value="1">

                        <!-- Servicio -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Servicio:</label>
                            <select name="txtservicio" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                <option value="">Seleccione un servicio...</option>
                                <?php
                                $consulta = "SELECT * FROM nom_servicio";
                                $ejecutar = mysqli_query($conexion, $consulta);
                                while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                    echo "<option value='" . $respuesta['id_nom_servicio'] . "'>" . $respuesta['nombre'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Descripción -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Descripción:</label>
                            <textarea name="txtdescripcion" placeholder="Ingrese la descripción" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000; height: 60px;"></textarea>
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
                                    <input type="submit" name="enviar" value="Agregar" class="btn btn-success mb-5 m-2">
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST["enviar"])) {
                        $fecha = mysqli_real_escape_string($conexion, $_POST["txtfecha"]);
                        $hor = mysqli_real_escape_string($conexion, $_POST['txthora']);
                        $cli = $_POST['txtcliente'];
                        $mas = $_POST['txtmascota'];
                        $est = $_POST['txtestado'];
                        $ser = $_POST['txtservicio'];
                        $des = mysqli_real_escape_string($conexion, $_POST['txtdescripcion']);

                        if (!empty($fecha) && !empty($hor) && !empty($cli) && !empty($mas) && !empty($est) && !empty($ser)) {
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
                                $consulta_citas_anteriores = "SELECT hora FROM cita WHERE fecha = '$fecha' AND id_estado_cita = 1";
                                $resultado_citas_anteriores = mysqli_query($conexion, $consulta_citas_anteriores);

                                $puede_insertar = true;
                                while ($fila = mysqli_fetch_assoc($resultado_citas_anteriores)) {
                                    $hora_existente = strtotime($fila['hora']);
                                    $diferencia = abs($hora_seleccionada - $hora_existente);
                                    if ($diferencia < 1200) { // 20 minutos en segundos
                                        $puede_insertar = false;
                                        break;
                                    }
                                }

                                if ($puede_insertar) {
                                    $sql = "INSERT INTO cita (fecha, hora, id_cliente, id_mascota, id_estado_cita, id_nom_servicio, descripcion, id_ver) 
                                            VALUES ('$fecha', '$hor', '$cli', '$mas', '$est', '$ser', '$des', 2)";
                                    $result = mysqli_query($conexion, $sql);

                                    if ($result) {
                                        echo '<script type="text/javascript">
                                        Swal.fire({
                                            title: "Mensaje",
                                            text: "Cita agendada exitosamente.",
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
                                            text: "Hubo un problema al agendar la cita.",
                                            icon: "error",
                                            showCancelButton: false,
                                            confirmButtonText: "OK"
                                        });
                                        </script>';
                                    }
                                } else {
                                    echo '<script type="text/javascript">
                                    Swal.fire({
                                        title: "Mensaje",
                                        text: "La hora seleccionada no cumple con la diferencia de 20 minutos con otras citas ya existentes.",
                                        icon: "error",
                                        showCancelButton: false,
                                        confirmButtonText: "OK"
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
                                });
                                </script>';
                            }
                        } else {
                            echo '<script type="text/javascript">
                            Swal.fire({
                                title: "Mensaje",
                                text: "Por favor, complete todos los campos obligatorios.",
                                icon: "error",
                                showCancelButton: false,
                                confirmButtonText: "OK"
                            });
                            </script>';
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