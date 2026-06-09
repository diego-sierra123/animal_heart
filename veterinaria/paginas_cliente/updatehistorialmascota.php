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
            $editarId = '';
            $nombre = '';
            $sex = '';
            $tip = '';
            $raz = '';
            $fec = '';
            $obs = '';

            // Depuración: Verificar qué se está recibiendo
            // echo "<!-- GET actualizar: " . (isset($_GET['actualizar']) ? $_GET['actualizar'] : 'NO') . " -->";
            
            // Verificar si se recibió el parámetro 'actualizar' por GET o por POST
            if (isset($_GET['actualizar']) && !empty($_GET['actualizar'])) {
                $editarId = mysqli_real_escape_string($conexion, $_GET['actualizar']);
                
                $consulta = "SELECT * FROM mascota WHERE id_mascota = '$editarId' AND id_cliente = '" . $_SESSION['id'] . "'";
                $ejecutar = mysqli_query($conexion, $consulta);

                if ($ejecutar && mysqli_num_rows($ejecutar) > 0) {
                    $fila = mysqli_fetch_assoc($ejecutar);
                    $nombre = $fila['nombre'];
                    $sex = $fila['sexo'];
                    $tip = $fila['id_tipo_mascota'];
                    $raz = $fila['id_raza'];
                    $fec = $fila['fecha_nacimiento'];
                    $obs = $fila['observaciones'];
                } else {
                    echo '<div class="alert alert-danger">Mascota no encontrada o no tienes permisos para editarla.</div>';
                    echo '<a href="historialmascota.php" class="btn btn-secondary">Volver</a>';
                    exit;
                }
            } elseif (isset($_POST['txtid']) && !empty($_POST['txtid'])) {
                // Si viene de un POST (después de un error)
                $editarId = mysqli_real_escape_string($conexion, $_POST['txtid']);
                $consulta = "SELECT * FROM mascota WHERE id_mascota = '$editarId' AND id_cliente = '" . $_SESSION['id'] . "'";
                $ejecutar = mysqli_query($conexion, $consulta);

                if ($ejecutar && mysqli_num_rows($ejecutar) > 0) {
                    $fila = mysqli_fetch_assoc($ejecutar);
                    $nombre = $fila['nombre'];
                    $sex = $fila['sexo'];
                    $tip = $fila['id_tipo_mascota'];
                    $raz = $fila['id_raza'];
                    $fec = $fila['fecha_nacimiento'];
                    $obs = $fila['observaciones'];
                } else {
                    echo '<div class="alert alert-danger">Mascota no encontrada o no tienes permisos para editarla.</div>';
                    echo '<a href="historialmascota.php" class="btn btn-secondary">Volver</a>';
                    exit;
                }
            } else {
                echo '<div class="alert alert-warning">No se especificó qué mascota actualizar.</div>';
                echo '<a href="historialmascota.php" class="btn btn-secondary">Volver a mis mascotas</a>';
                exit;
            }
            ?>

            <div class="row justify-content-center mt-5">
                <div class="col-10 col-sm-8 col-md-7 col-lg-6 custom-border background-image">
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>ACTUALIZAR MASCOTA</b></h2>

                    <form class="row justify-content-center align-content-center g-3 mt-3" name="insert" action="updatehistorialmascota.php" method="post" enctype="multipart/form-data">
                        <br>

                        <!-- ID Oculto - SIEMPRE visible para depuración, pero lo dejamos visible temporalmente -->
                        <div style="display: none;" class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">ID Mascota (oculto):</label>
                            <input type="text" name="txtid" value="<?php echo $editarId; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" readonly>
                        </div>

                        <!-- Nombre -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Nombre:</label>
                            <input type="text" name="txtnombre" minlength="1" maxlength="100" value="<?php echo htmlspecialchars($nombre); ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Sexo -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Sexo:</label>
                            <select name="txtsexo" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                <option value="Macho" <?php echo ($sex == 'Macho') ? 'selected' : ''; ?>>Macho</option>
                                <option value="Hembra" <?php echo ($sex == 'Hembra') ? 'selected' : ''; ?>>Hembra</option>
                                <option value="Sin definir" <?php echo ($sex == 'Sin definir') ? 'selected' : ''; ?>>Sin definir</option>
                            </select>
                        </div>

                        <!-- Tipo Mascota -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Tipo Mascota:</label>
                            <select name="txttipo" id="txttipo" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                <?php
                                $consulta2 = "SELECT * FROM tipo_mascota";
                                $ejecutar2 = mysqli_query($conexion, $consulta2);
                                while ($res = mysqli_fetch_assoc($ejecutar2)) {
                                    $idp = $res['id_tipo_mascota'];
                                    $NP = $res['nombre'];
                                    $selected = ($idp == $tip) ? 'selected' : '';
                                    echo "<option value='$idp' $selected> $NP </option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Raza -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Raza:</label>
                            <select name="txtraza" id="txtraza" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                <?php
                                $consulta2 = "SELECT * FROM raza WHERE id_tipo_mascota = '$tip'";
                                $ejecutar2 = mysqli_query($conexion, $consulta2);
                                while ($res = mysqli_fetch_assoc($ejecutar2)) {
                                    $idp = $res['id_raza'];
                                    $NP = $res['nombre'];
                                    $selected = ($idp == $raz) ? 'selected' : '';
                                    echo "<option value='$idp' $selected> $NP </option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Fecha Nacimiento -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha Nacimiento:</label>
                            <input type="date" name="txtfecha" value="<?php echo $fec; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" max="<?php echo date('Y-m-d'); ?>" required>
                        </div>

                        <!-- Cliente -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Cliente:</label>
                            <input type="text" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" value="<?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ?>" readonly>
                            <input type="hidden" name="txtcliente" value="<?php echo $_SESSION['id']; ?>">
                        </div>

                        <!-- Observaciones -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Observaciones:</label>
                            <textarea name="txtobservacion" maxlength="255" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000; height: 60px;"><?php echo htmlspecialchars($obs); ?></textarea>
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
                                    <input type="submit" name="actualizar" value="Actualizar" class="btn btn-primary mb-5 m-2">
                                </div>
                            </div>
                        </div>
                    </form>

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('#txttipo').change(function() {
                                var tipoMascotaId = $(this).val();
                                if (tipoMascotaId) {
                                    $.ajax({
                                        url: 'obtener_razas.php',
                                        type: 'post',
                                        data: {
                                            tipo_mascota: tipoMascotaId
                                        },
                                        dataType: 'json',
                                        success: function(response) {
                                            var len = response.length;
                                            $("#txtraza").empty();
                                            if (len > 0) {
                                                for (var i = 0; i < len; i++) {
                                                    var id = response[i]['id_raza'];
                                                    var name = response[i]['nombre'];
                                                    $("#txtraza").append("<option value='" + id + "'>" + name + "</option>");
                                                }
                                            } else {
                                                $("#txtraza").append("<option value=''>No hay razas disponibles</option>");
                                            }
                                        }
                                    });
                                } else {
                                    $("#txtraza").empty();
                                    $("#txtraza").append("<option value=''>Primero seleccione un tipo</option>");
                                }
                            });
                        });
                    </script>

                    <?php
                    if (isset($_POST["actualizar"])) {
                        $idPac = mysqli_real_escape_string($conexion, $_POST["txtid"]);
                        $nom = mysqli_real_escape_string($conexion, $_POST["txtnombre"]);
                        $sex = mysqli_real_escape_string($conexion, $_POST["txtsexo"]);
                        $tip = mysqli_real_escape_string($conexion, $_POST["txttipo"]);
                        $raz = mysqli_real_escape_string($conexion, $_POST["txtraza"]);
                        $fec = mysqli_real_escape_string($conexion, $_POST["txtfecha"]);
                        $cli = mysqli_real_escape_string($conexion, $_POST["txtcliente"]);
                        $obs = mysqli_real_escape_string($conexion, $_POST["txtobservacion"]);

                        // Verificar campos obligatorios
                        if (empty($nom) || empty($sex) || empty($tip) || empty($raz) || empty($cli)) {
                            echo '<script type="text/javascript">
                            Swal.fire({
                                title: "Mensaje",
                                text: "Por favor, complete los campos obligatorios.",
                                icon: "error",
                                showCancelButton: false,
                                confirmButtonText: "OK"
                            }).then(function() {
                                window.location.href = "updatehistorialmascota.php?actualizar=' . $idPac . '";
                            });
                            </script>';
                        } else {
                            // Validar que la fecha no esté vacía
                            if (empty($fec)) {
                                echo '<script type="text/javascript">
                                Swal.fire({
                                    title: "Mensaje",
                                    text: "La fecha de nacimiento es obligatoria.",
                                    icon: "error",
                                    showCancelButton: false,
                                    confirmButtonText: "OK"
                                }).then(function() {
                                    window.location.href = "updatehistorialmascota.php?actualizar=' . $idPac . '";
                                });
                                </script>';
                                exit();
                            }
                            
                            // Si llegamos aquí, la fecha no está vacía
                            $fecha_nacimiento = "'$fec'";
                            
                            // Para observaciones, si está vacío, usar cadena vacía
                            $observaciones = !empty($obs) ? "'$obs'" : "''";

                            // Verificar si ya existe la mascota con los mismos datos (excluyendo la actual)
                            $checkQuery = "SELECT id_mascota FROM mascota WHERE nombre = '$nom' AND id_tipo_mascota = '$tip' AND id_raza = '$raz' AND id_cliente = '$cli' AND id_mascota != '$idPac'";
                            $checkResult = mysqli_query($conexion, $checkQuery);

                            if (mysqli_num_rows($checkResult) > 0) {
                                echo '<script type="text/javascript">
                                Swal.fire({
                                    title: "Mensaje",
                                    text: "Ya existe una mascota con los mismos datos.",
                                    icon: "error",
                                    showCancelButton: false,
                                    confirmButtonText: "OK"
                                }).then(function() {
                                    window.location.href = "updatehistorialmascota.php?actualizar=' . $idPac . '";
                                });
                                </script>';
                            } else {
                                // Actualizar mascota
                                $sql = "UPDATE mascota SET 
                                        nombre='$nom', 
                                        sexo='$sex', 
                                        id_tipo_mascota='$tip', 
                                        id_raza='$raz', 
                                        fecha_nacimiento=$fecha_nacimiento, 
                                        observaciones=$observaciones 
                                        WHERE id_mascota='$idPac' AND id_cliente='$cli'";
                                
                                $ejecutar = mysqli_query($conexion, $sql);

                                if ($ejecutar) {
                                    echo '<script type="text/javascript">
                                    Swal.fire({
                                        title: "Mensaje",
                                        text: "Registro Actualizado exitosamente.",
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
                                        text: "Hubo un problema al actualizar: ' . addslashes(mysqli_error($conexion)) . '",
                                        icon: "error",
                                        showCancelButton: false,
                                        confirmButtonText: "OK"
                                    }).then(function() {
                                        window.location.href = "updatehistorialmascota.php?actualizar=' . $idPac . '";
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