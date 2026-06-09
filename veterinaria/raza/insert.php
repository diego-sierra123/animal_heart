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

if ($_SESSION["id_rol"] == 2) {
    $_SESSION['error'] = 'sin permiso para ingresar';
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <title>Advertencia</title>
    </head>
    <body>
        <script type="text/javascript">
            swal({
                title: 'Mensaje',
                text: 'No tiene permiso para ingresar.',
                showCancelButton: false, 
                confirmButtonText: 'OK' 
            }).then(function() {
                // Redirigir después de aceptar
                window.location.href = "../paginas_personal/bienvenido.php";
            });
        </script>
    </body>
    </html>
    <?php
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
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>AGREGAR RAZA</b></h2>

                    <form class="row justify-content-center align-content-center g-3 mt-3" name="insert" action="insert.php" method="post" enctype="multipart/form-data">
                        <br>

                        <!-- Nombre -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Nombre:</label>
                            <input type="text" name="txtnombre" minlength="1" maxlength="50" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Tipo Mascota -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Tipo Mascota:</label>
                            <select name="selecttipo" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                <option value="">Seleccione...</option>
                                <?php
                                $consulta = "SELECT * FROM tipo_mascota ORDER BY nombre ASC";
                                $ejecutar = mysqli_query($conexion, $consulta);
                                while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                    echo "<option value='" . $respuesta['id_tipo_mascota'] . "'>" . $respuesta['nombre'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <br>
                        <br>
                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 m-4 text-center">
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="../raza/select.php" class="btn btn-secondary m-2">Atrás</a>
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
                        $nom = mysqli_real_escape_string($conexion, $_POST["txtnombre"]);
                        $tipo = mysqli_real_escape_string($conexion, $_POST["selecttipo"]);

                        if (empty($nom) || empty($tipo)) {
                            echo '<script type="text/javascript">
                            swal({
                                title: "Mensaje",
                                text: "Por favor, complete todos los campos.",
                                icon: "error",
                                showCancelButton: false,
                                confirmButtonText: "OK"
                            }).then(function() {
                                window.open("insert.php", "_SELF");
                            });
                            </script>';
                        } else {
                            // Verificar si ya existe la raza con el mismo nombre y tipo
                            $consultaExistencia = "SELECT id_raza FROM raza 
                                                  WHERE nombre = '$nom' 
                                                  AND id_tipo_mascota = '$tipo'";
                            $resultadoExistencia = mysqli_query($conexion, $consultaExistencia);

                            if (mysqli_num_rows($resultadoExistencia) > 0) {
                                echo '<script type="text/javascript">
                                swal({
                                    title: "Mensaje",
                                    text: "Ya existe una raza con el mismo nombre para este tipo de mascota.",
                                    icon: "error",
                                    showCancelButton: false,
                                    confirmButtonText: "OK"
                                }).then(function() {
                                    window.open("insert.php", "_SELF");
                                });
                                </script>';
                            } else {
                                // Construir la consulta de inserción
                                $sql = "INSERT INTO raza (nombre, id_tipo_mascota) 
                                        VALUES ('$nom', '$tipo')";

                                $ejecutar = mysqli_query($conexion, $sql);

                                if ($ejecutar) {
                                    echo '<script type="text/javascript">
                                    swal({
                                        title: "Mensaje",
                                        text: "Raza guardada exitosamente.",
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
                                        text: "Hubo un problema al guardar la raza: ' . addslashes(mysqli_error($conexion)) . '",
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