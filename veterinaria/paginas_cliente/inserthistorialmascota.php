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
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>AGREGAR MASCOTA</b></h2>

                    <form class="row justify-content-center align-content-center g-3 mt-3" name="inserthistorialmascota" action="inserthistorialmascota.php" method="post" enctype="multipart/form-data">
                        <br>

                        <!-- Nombre -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Nombre:</label>
                            <input type="text" name="txtnombre" minlength="1" maxlength="100" placeholder="Ingrese el nombre" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
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
                                $consulta2 = "SELECT * FROM tipo_mascota";
                                $ejecutar2 = mysqli_query($conexion, $consulta2);
                                while ($respuesta2 = mysqli_fetch_assoc($ejecutar2)) {
                                    echo "<option value='" . $respuesta2['id_tipo_mascota'] . "'>" . $respuesta2['nombre'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Raza -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Raza:</label>
                            <select name="txtraza" id="raza" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                <option value="">Primero seleccione tipo</option>
                            </select>
                        </div>

                        <!-- Fecha Nacimiento -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha Nacimiento:</label>
                            <input type="date" name="txtfecha" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" max="<?php echo date('Y-m-d'); ?>">
                        </div>

                        <!-- Cliente (solo lectura) -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Cliente:</label>
                            <input type="text" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" value="<?php echo $nombre_cliente; ?>" readonly>
                            <input type="hidden" name="txtcliente" value="<?php echo $_SESSION['id']; ?>">
                        </div>

                        <!-- Fecha Registro -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha Registro:</label>
                            <input type="date" name="txtfecharegistro" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" value="<?php echo date('Y-m-d'); ?>" readonly>
                        </div>

                        <!-- Observaciones -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Observaciones:</label>
                            <textarea name="txtobservacion" maxlength="255" placeholder="Ingrese las observaciones" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000; height: 60px;"></textarea>
                        </div>

                        <br>
                        <br>
                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 m-4 text-center">
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="historialmascota.php" class="btn btn-secondary m-2">Atrás</a>
                                </div>
                                <div class="col">
                                    <input type="submit" name="enviar" value="Agregar" class="btn btn-success mb-5 m-2">
                                </div>
                            </div>
                        </div>
                    </form>

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('#tipo_mascota').change(function() {
                                var tipo_mascota = $(this).val();
                                if (tipo_mascota) {
                                    $.ajax({
                                        url: 'obtener_razas.php',
                                        type: 'POST',
                                        data: {
                                            tipo_mascota: tipo_mascota
                                        },
                                        dataType: 'json',
                                        success: function(response) {
                                            var len = response.length;
                                            $("#raza").empty();
                                            if (len > 0) {
                                                $("#raza").append("<option value=''>Seleccione raza...</option>");
                                                for (var i = 0; i < len; i++) {
                                                    var id_raza = response[i].id_raza;
                                                    var nombre = response[i].nombre;
                                                    $("#raza").append("<option value='" + id_raza + "'>" + nombre + "</option>");
                                                }
                                            } else {
                                                $("#raza").append("<option value=''>No hay razas disponibles</option>");
                                            }
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
                    if (isset($_POST["enviar"])) {
                        $nom = mysqli_real_escape_string($conexion, $_POST['txtnombre']);
                        $fec = mysqli_real_escape_string($conexion, $_POST["txtfecha"]);
                        $fecreg = mysqli_real_escape_string($conexion, $_POST["txtfecharegistro"]);
                        $sex = mysqli_real_escape_string($conexion, $_POST["txtsexo"]);
                        $tip = mysqli_real_escape_string($conexion, $_POST['txttipomascota']);
                        $raz = mysqli_real_escape_string($conexion, $_POST['txtraza']);
                        $cli = mysqli_real_escape_string($conexion, $_POST['txtcliente']);
                        $obs = mysqli_real_escape_string($conexion, $_POST['txtobservacion']);

                        // Verificar campos obligatorios
                        if (empty($nom) || empty($sex) || empty($tip) || empty($raz) || empty($cli)) {
                            echo '<script type="text/javascript">
                            Swal.fire({
                                title: "Mensaje",
                                text: "Por favor, complete todos los campos obligatorios.",
                                icon: "error",
                                showCancelButton: false,
                                confirmButtonText: "OK"
                            }).then(function() {
                                window.location.href = "inserthistorialmascota.php";
                            });
                            </script>';
                        } else {
                            // CORRECCIÓN: Manejar correctamente los valores vacíos
                            // Si fecha_nacimiento está vacío, usar NULL (si la tabla lo permite) o usar una fecha por defecto
                            // Como el error dice que no puede ser NULL, vamos a usar una fecha por defecto o hacer el campo requerido
                            
                            // Opción 1: Hacer la fecha requerida (recomendado)
                            if (empty($fec)) {
                                echo '<script type="text/javascript">
                                Swal.fire({
                                    title: "Mensaje",
                                    text: "La fecha de nacimiento es obligatoria.",
                                    icon: "error",
                                    showCancelButton: false,
                                    confirmButtonText: "OK"
                                }).then(function() {
                                    window.location.href = "inserthistorialmascota.php";
                                });
                                </script>';
                                exit();
                            }
                            
                            // Si llegamos aquí, la fecha no está vacía
                            $fecha_nacimiento = "'$fec'";
                            
                            // Para observaciones, si está vacío, usar cadena vacía
                            $observaciones = !empty($obs) ? "'$obs'" : "''";

                            // Verificar si ya existe la mascota
                            $existente = "SELECT id_mascota FROM mascota WHERE nombre = '$nom' AND id_tipo_mascota = '$tip' AND id_raza = '$raz' AND id_cliente = '$cli'";
                            $existencia = mysqli_query($conexion, $existente);

                            if (mysqli_num_rows($existencia) > 0) {
                                echo '<script type="text/javascript">
                                Swal.fire({
                                    title: "Mensaje",
                                    text: "Ya existe una mascota con los mismos datos.",
                                    icon: "error",
                                    showCancelButton: false,
                                    confirmButtonText: "OK"
                                }).then(function() {
                                    window.location.href = "inserthistorialmascota.php";
                                });
                                </script>';
                            } else {
                                // Insertar nueva mascota
                                $sql = "INSERT INTO mascota (nombre, sexo, id_tipo_mascota, id_raza, fecha_nacimiento, id_cliente, fecha_registro, observaciones) 
                                        VALUES ('$nom', '$sex', '$tip', '$raz', $fecha_nacimiento, '$cli', '$fecreg', $observaciones)";
                                
                                $result = mysqli_query($conexion, $sql);

                                if ($result) {
                                    echo '<script type="text/javascript">
                                    Swal.fire({
                                        title: "Mensaje",
                                        text: "Registro exitoso.",
                                        icon: "success",
                                        showCancelButton: false,
                                        confirmButtonText: "OK"
                                    }).then(function() {
                                        window.location.href = "historialmascota.php";
                                    });
                                    </script>';
                                } else {
                                    echo '<script type="text/javascript">
                                    Swal.fire({
                                        title: "Error",
                                        text: "Hubo un problema al registrar: ' . addslashes(mysqli_error($conexion)) . '",
                                        icon: "error",
                                        showCancelButton: false,
                                        confirmButtonText: "OK"
                                    }).then(function() {
                                        window.location.href = "inserthistorialmascota.php";
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

        </div>
        <br>
        <br>
    </div>
</div>

<?php include("../template_ingreso_cliente/pie.php") ?>