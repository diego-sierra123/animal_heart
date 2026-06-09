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
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>AGREGAR TRATAMIENTO</b></h2>

                    <?php
                    // Obtener el ID de la mascota desde la URL
                    $id_mascota_filtro = isset($_GET['id']) ? mysqli_real_escape_string($conexion, $_GET['id']) : 0;
                    
                    // Obtener información de la mascota y su dueño
                    $infoMascota = "";
                    if ($id_mascota_filtro > 0) {
                        $queryMascota = "SELECT m.id_mascota, m.nombre as mascota_nombre, c.nombres, c.apellidos 
                                         FROM mascota m 
                                         INNER JOIN cliente c ON m.id_cliente = c.id_cliente 
                                         WHERE m.id_mascota = '$id_mascota_filtro'";
                        $resultMascota = mysqli_query($conexion, $queryMascota);
                        if ($rowMascota = mysqli_fetch_assoc($resultMascota)) {
                            $infoMascota = $rowMascota['mascota_nombre'] . " (Dueño: " . $rowMascota['nombres'] . " " . $rowMascota['apellidos'] . ")";
                        }
                    }
                    ?>

                    <form class="row justify-content-center align-content-center g-3 mt-3" name="insert" action="insertpropio.php" method="post" enctype="multipart/form-data">
                        <br>
                        
                        <!-- Campo oculto para el ID de la mascota -->
                        <input type="hidden" name="txtid_mascota" value="<?php echo $id_mascota_filtro; ?>">

                        <!-- Mascota (solo lectura) -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Mascota:</label>
                            <input type="text" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" value="<?php echo $infoMascota; ?>" readonly disabled>
                        </div>

                        <!-- Medicamentos -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Medicamentos:</label>
                            <textarea name="txtmedicamento" minlength="1" maxlength="255" rows="3" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required></textarea>
                        </div>

                        <!-- Fecha -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha:</label>
                            <?php
                            $hora_actual = date('Y-m-d H:i:s');
                            $horas_a_retrasar = 7;
                            $nueva_fecha = date('Y-m-d', strtotime($hora_actual . ' - ' . $horas_a_retrasar . ' hours'));
                            ?>
                            <input type="date" name="txtfecha" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" min="<?php echo $nueva_fecha; ?>" max="<?php echo $nueva_fecha; ?>" value="<?php echo $nueva_fecha; ?>" required>
                        </div>

                        <!-- Observaciones -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Observaciones:</label>
                            <textarea name="txtobservacion" minlength="1" maxlength="255" rows="3" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required></textarea>
                        </div>

                        <br>
                        <br>
                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 m-4 text-center">
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="selectpropio.php?id=<?php echo $id_mascota_filtro; ?>" class="btn btn-secondary m-2">Atrás</a>
                                </div>
                                <br>
                                <div class="col">
                                    <input type="submit" name="insertar" value="Agregar" class="btn btn-success mb-5 m-2">
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST["insertar"])) {
                        // Escapar datos para evitar inyección SQL
                        $mascota = mysqli_real_escape_string($conexion, $_POST["txtid_mascota"]);
                        $medicamento = mysqli_real_escape_string($conexion, $_POST["txtmedicamento"]);
                        $fecha = mysqli_real_escape_string($conexion, $_POST["txtfecha"]);
                        $observacion = mysqli_real_escape_string($conexion, $_POST["txtobservacion"]);

                        if (empty($mascota) || empty($medicamento) || empty($fecha) || empty($observacion)) {
                            echo '<script type="text/javascript">
                            swal({
                                title: "Mensaje",
                                text: "Por favor, complete todos los campos.",
                                icon: "error",
                                showCancelButton: false,
                                confirmButtonText: "OK"
                            }).then(function() {
                                window.open("insertpropio.php?id=' . $mascota . '", "_SELF");
                            });
                            </script>';
                        } else {
                            // Verificar que la mascota existe
                            $checkMascota = "SELECT id_mascota FROM mascota WHERE id_mascota = '$mascota'";
                            $resultMascota = mysqli_query($conexion, $checkMascota);
                            
                            if (mysqli_num_rows($resultMascota) == 0) {
                                echo '<script type="text/javascript">
                                swal({
                                    title: "Mensaje",
                                    text: "La mascota seleccionada no existe.",
                                    icon: "error",
                                    showCancelButton: false,
                                    confirmButtonText: "OK"
                                }).then(function() {
                                    window.open("insertpropio.php?id=' . $mascota . '", "_SELF");
                                });
                                </script>';
                            } else {
                                // Construir la consulta de inserción
                                $sql = "INSERT INTO tratamiento (id_mascota, medicamentos, fecha, observaciones) 
                                        VALUES ('$mascota', '$medicamento', '$fecha', '$observacion')";

                                $ejecutar = mysqli_query($conexion, $sql);

                                if ($ejecutar) {
                                    echo '<script type="text/javascript">
                                    swal({
                                        title: "Mensaje",
                                        text: "Tratamiento guardado exitosamente.",
                                        icon: "success",
                                        showCancelButton: false,
                                        confirmButtonText: "OK"
                                    }).then(function() {
                                        window.open("selectpropio.php?id=' . $mascota . '", "_SELF");
                                    });
                                    </script>';
                                } else {
                                    echo '<script type="text/javascript">
                                    swal({
                                        title: "Error",
                                        text: "Hubo un problema al guardar el tratamiento: ' . addslashes(mysqli_error($conexion)) . '",
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