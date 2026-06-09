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
<?php include("../template_ingreso_cliente/menu.php") ?>

<!-- Agregar SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid container-main">
    <div class="container">
        <div class="row justify-content-center">

            <br>

            <?php
            $editarId = '';
            $nombres = '';
            $apellidos = '';
            $telefono = '';
            $ciudad = '';
            $barrio = '';
            $direccion = '';
            $tdocumento = '';
            $ndocumento = '';
            $correo = '';
            $contrasena = '';

            if (isset($_GET['id'])) {
                $editarId = mysqli_real_escape_string($conexion, $_GET['id']);
                $consulta = "SELECT * FROM cliente WHERE id_cliente = '$editarId'";
                $ejecutar = mysqli_query($conexion, $consulta);

                if ($ejecutar && mysqli_num_rows($ejecutar) > 0) {
                    $fila = mysqli_fetch_assoc($ejecutar);
                    $nombres = $fila['nombres'];
                    $apellidos = $fila['apellidos'];
                    $telefono = $fila['telefono'];
                    $ciudad = $fila['ciudad'];
                    $barrio = $fila['barrio'];
                    $direccion = $fila['direccion'];
                    $tdocumento = $fila['t_documento'];
                    $ndocumento = $fila['n_documento'];
                    $correo = $fila['correo'];
                    $contrasena = $fila['contrasena'];
                }
            }
            ?>

            <div class="row justify-content-center mt-5">
                <div class="col-10 col-sm-8 col-md-7 col-lg-6 custom-border background-image">
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>ACTUALIZAR DATOS</b></h2>

                    <form class="row justify-content-center align-content-center g-3 mt-3" method="post" enctype="multipart/form-data">
                        <br>

                        <!-- ID Oculto -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light d-none">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Id Cliente:</label>
                            <input type="text" name="txtid" value="<?php echo $editarId; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" readonly>
                        </div>

                        <!-- Nombres -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Nombres:</label>
                            <input type="text" name="txtnombres" minlength="1" maxlength="100" value="<?php echo $nombres; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Apellidos -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Apellidos:</label>
                            <input type="text" name="txtapellidos" minlength="1" maxlength="100" value="<?php echo $apellidos; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Teléfono -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Teléfono:</label>
                            <input type="text" name="txttelefono" minlength="1" maxlength="20" value="<?php echo $telefono; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Ciudad -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Ciudad:</label>
                            <input type="text" name="txtciudad" minlength="1" maxlength="50" value="<?php echo $ciudad; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Barrio -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Barrio:</label>
                            <input type="text" name="txtbarrio" minlength="1" maxlength="50" value="<?php echo $barrio; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Dirección -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Dirección:</label>
                            <input type="text" name="txtdireccion" minlength="1" maxlength="100" value="<?php echo $direccion; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Tipo Documento -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Tipo Documento:</label>
                            <select name="txttdocumento" class="form-select" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                <option value="TI" <?php echo ($tdocumento == 'TI') ? 'selected' : ''; ?>>Tarjeta de Identidad</option>
                                <option value="CC" <?php echo ($tdocumento == 'CC') ? 'selected' : ''; ?>>Cédula de Ciudadanía</option>
                                <option value="CE" <?php echo ($tdocumento == 'CE') ? 'selected' : ''; ?>>Cédula de Extranjería</option>
                                <option value="PAS" <?php echo ($tdocumento == 'PAS') ? 'selected' : ''; ?>>Pasaporte</option>
                            </select>
                        </div>

                        <!-- Número Documento -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Número de Documento:</label>
                            <input type="text" name="txtndocumento" minlength="1" maxlength="20" value="<?php echo $ndocumento; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Correo -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Correo:</label>
                            <input type="email" name="txtcorreo" minlength="1" maxlength="100" value="<?php echo $correo; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <!-- Contraseña -->
                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Contraseña:</label>
                            <input type="text" name="txtcontrasena" minlength="1" maxlength="255" value="<?php echo $contrasena; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                        </div>

                        <br>
                        <br>
                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 m-4 text-center">
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="<?php echo "perfil.php?persona=" . $editarId  ?>" class="btn btn-secondary m-2">Atrás</a>
                                </div>
                                <br>
                                <div class="col">
                                    <input type="submit" id="btnActualizar" name="actualizar" value="Actualizar" class="btn btn-primary mb-5 m-2">
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST["actualizar"])) {
                        // Escapar datos para evitar inyección SQL
                        $id = mysqli_real_escape_string($conexion, $_POST["txtid"]);
                        $nom = mysqli_real_escape_string($conexion, $_POST["txtnombres"]);
                        $ape = mysqli_real_escape_string($conexion, $_POST["txtapellidos"]);
                        $tel = mysqli_real_escape_string($conexion, $_POST["txttelefono"]);
                        $ciu = mysqli_real_escape_string($conexion, $_POST["txtciudad"]);
                        $bar = mysqli_real_escape_string($conexion, $_POST["txtbarrio"]);
                        $dir = mysqli_real_escape_string($conexion, $_POST["txtdireccion"]);
                        $tdoc = mysqli_real_escape_string($conexion, $_POST["txttdocumento"]);
                        $ndoc = mysqli_real_escape_string($conexion, $_POST["txtndocumento"]);
                        $correo = mysqli_real_escape_string($conexion, $_POST["txtcorreo"]);
                        $contrasena = mysqli_real_escape_string($conexion, $_POST["txtcontrasena"]);

                        if (empty($id) || empty($nom) || empty($ape) || empty($tel) || empty($ciu) || empty($bar) || empty($dir) || empty($tdoc) || empty($ndoc) || empty($correo) || empty($contrasena)) {
                            echo '<script type="text/javascript">
                            Swal.fire({
                                title: "Mensaje",
                                text: "Por favor, complete todos los campos",
                                icon: "error",
                                showCancelButton: false,
                                confirmButtonText: "OK"
                            }).then(function() {
                                window.location = "update.php?id=' . $id . '";
                            });
                            </script>';
                        } else {
                            // Verificar si ya existe el correo o documento en OTRO registro
                            $check = "SELECT * FROM cliente 
                                      WHERE (correo = '$correo' OR n_documento = '$ndoc') 
                                      AND id_cliente != '$id'";
                            $result = mysqli_query($conexion, $check);

                            if (mysqli_num_rows($result) > 0) {
                                echo '<script type="text/javascript">
                                Swal.fire({
                                    title: "Mensaje",
                                    text: "Los datos ya existen en otro registro, no se puede actualizar.",
                                    icon: "error",
                                    showCancelButton: false,
                                    confirmButtonText: "OK"
                                }).then(function() {
                                    window.location = "update.php?id=' . $id . '";
                                });
                                </script>';
                            } else {
                                $sql = "UPDATE cliente SET 
                                    nombres='$nom',
                                    apellidos='$ape',
                                    telefono='$tel',
                                    ciudad='$ciu',
                                    barrio='$bar',
                                    direccion='$dir',
                                    t_documento='$tdoc',
                                    n_documento='$ndoc',
                                    correo='$correo',
                                    contrasena='$contrasena'
                                    WHERE id_cliente='$id'";

                                if (mysqli_query($conexion, $sql)) {
                                    echo '<script type="text/javascript">
                                    Swal.fire({
                                        title: "Mensaje",
                                        text: "Registro Actualizado.",
                                        icon: "success",
                                        showCancelButton: false,
                                        confirmButtonText: "OK"
                                    }).then(function() {
                                        window.location = "perfil.php?persona=' . $id . '";
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

<?php include("../template_ingreso_cliente/pie.php") ?>