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

            <br>

            <?php
            $editarId = '';
            $id_mascota = '';
            $medicamentos = '';
            $fecha = '';
            $observaciones = '';

            if (isset($_GET['actualizar'])) {
                $editarId = mysqli_real_escape_string($conexion, $_GET['actualizar']);
                
                // No permitir modificar el tratamiento con ID 1
                if ($editarId == 1) {
                    echo '<script>
                            swal({
                                title:"Advertencia",
                                text:"No se puede modificar el tratamiento por defecto del sistema.",
                                icon:"warning"
                            }).then(function(){
                                window.open("select.php","_SELF");
                            });
                          </script>';
                    exit();
                }
                
                $consulta = "SELECT * FROM tratamiento WHERE id_tratamiento = '$editarId'";
                $ejecutar = mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));

                if ($ejecutar && mysqli_num_rows($ejecutar) > 0) {
                    $fila = mysqli_fetch_assoc($ejecutar);
                    $id_mascota = $fila['id_mascota'];
                    $medicamentos = $fila['medicamentos'];
                    $fecha = $fila['fecha'];
                    $observaciones = $fila['observaciones'];
                }
            }
            ?>

            <div class="row justify-content-center mt-5">
                <div class="col-10 col-sm-8 col-md-7 col-lg-6 custom-border background-image">
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>ACTUALIZAR TRATAMIENTO</b></h2>

                    <form class="row justify-content-center align-content-center g-3 mt-3" name="insert" action="update.php" method="post" enctype="multipart/form-data">
                        <br>

                        <!-- ID Oculto -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light d-none">
                            <label for="" class="form-label">Id Tratamiento:</label>
                            <input type="text" name="txtid" value="<?php echo $editarId; ?>" class="form-control" readonly>
                        </div>

                        <!-- Mascota -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Mascota:</label>
                            <select name="txtmascota" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                <option value="">Seleccione...</option>
                                <?php
                                $consulta = "SELECT m.id_mascota, m.nombre, c.nombres AS cliente 
                                           FROM mascota m 
                                           INNER JOIN cliente c ON m.id_cliente = c.id_cliente 
                                           ORDER BY m.nombre ASC";
                                $ejecutar = mysqli_query($conexion, $consulta);
                                while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                    $selected = ($respuesta['id_mascota'] == $id_mascota) ? 'selected' : '';
                                    echo "<option value='" . $respuesta['id_mascota'] . "' $selected>" . $respuesta['nombre'] . " (Cliente: " . $respuesta['cliente'] . ")</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Medicamentos -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Medicamentos:</label>
                            <textarea name="txtmedicamentos" minlength="1" maxlength="255" rows="3" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required><?php echo $medicamentos; ?></textarea>
                        </div>

                        <!-- Fecha -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha:</label>
                            <input type="date" name="txtfecha" value="<?php echo $fecha; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" max="<?php echo date('Y-m-d'); ?>" required>
                        </div>

                        <!-- Observaciones -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Observaciones:</label>
                            <textarea name="txtobservaciones" minlength="1" maxlength="255" rows="3" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required><?php echo $observaciones; ?></textarea>
                        </div>

                        <br>
                        <br>
                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 m-4 text-center">
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="../tratamiento/select.php" class="btn btn-secondary m-2">Atrás</a>
                                </div>
                                <br>
                                <div class="col">
                                    <input type="submit" name="actualizar" value="Actualizar" class="btn btn-primary mb-5 m-2">
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST["actualizar"])) {
                        // Escapar datos para evitar inyección SQL
                        $idPac = mysqli_real_escape_string($conexion, $_POST["txtid"]);
                        $mascota = mysqli_real_escape_string($conexion, $_POST["txtmascota"]);
                        $medicamentos = mysqli_real_escape_string($conexion, $_POST["txtmedicamentos"]);
                        $fecha = mysqli_real_escape_string($conexion, $_POST["txtfecha"]);
                        $observaciones = mysqli_real_escape_string($conexion, $_POST["txtobservaciones"]);

                        if (empty($idPac) || empty($mascota) || empty($medicamentos) || empty($fecha) || empty($observaciones)) {
                            echo '<script type="text/javascript">
                            swal({
                                title: "Mensaje",
                                text: "Por favor, complete los campos que modificaste y dejaste vacíos.",
                                icon: "error",
                                showCancelButton: false,
                                confirmButtonText: "OK"
                            }).then(function() {
                                window.open("update.php?actualizar=' . $idPac . '", "_SELF");
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
                                    window.open("update.php?actualizar=' . $idPac . '", "_SELF");
                                });
                                </script>';
                            } else {
                                // Proceder con la actualización
                                $sql = "UPDATE tratamiento SET 
                                        id_mascota = '$mascota',
                                        medicamentos = '$medicamentos',
                                        fecha = '$fecha',
                                        observaciones = '$observaciones'
                                        WHERE id_tratamiento = '$idPac'";

                                $ejecutar = mysqli_query($conexion, $sql) or die(mysqli_error($conexion));

                                if ($ejecutar) {
                                    echo '<script type="text/javascript">
                                    swal({
                                        title: "Mensaje",
                                        text: "Registro Actualizado.",
                                        icon: "success",
                                        showCancelButton: false,
                                        confirmButtonText: "OK"
                                    }).then(function() {
                                        window.open("select.php", "_SELF");
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