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
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>AGREGAR COMPRA PROVEEDOR</b></h2>

                    <form class="row justify-content-center align-content-center g-3 mt-3" name="insert" action="insert.php" method="post" enctype="multipart/form-data">
                        <br>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-light" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff; font-size: 20px;"><b>Fecha de la compra:</b></label>
                                <?php
                                $hora_actual = date('Y-m-d H:i:s');
                                $horas_a_retrasar = 7;
                                $nueva_fecha = date('Y-m-d', strtotime($hora_actual . ' - ' . $horas_a_retrasar . ' hours'));
                                ?>
                                <input type="date" class="form-control" name="txtfecha" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" min="<?php echo $nueva_fecha; ?>" max="<?php echo $nueva_fecha; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-light" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff; font-size: 20px;"><b>Valor Total:</b></label>
                                <input type="number" class="form-control" name="txtvalor" min="0" placeholder="Ingrese el valor total" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-light" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff; font-size: 20px;"><b>Proveedor:</b></label>
                                <select class="form-select" name="selectPro" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <option value="">-----</option>
                                    <?php
                                    $consulta = "SELECT * FROM proveedor";
                                    $ejecutar = mysqli_query($conexion, $consulta);
                                    while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                        echo "<option value='" . $respuesta['id_proveedor'] . "'>" . $respuesta['nombre'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-light" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff; font-size: 20px;"><b>Adjuntar comprobante:</b></label>
                                <input type="file" class="form-control" name="txtfoto" id="id" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" accept="image/*" required>
                            </div>
                        </div>

                        <br>
                        <br>
                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 m-4 text-center">
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="../compra_proveedor/select.php" class="btn btn-secondary m-2">Atrás</a>
                                </div>
                                <br>
                                <div class="col">
                                    <input type="submit" name="enviar" value="Agregar" class="btn btn-success mb-5 m-2">
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST["enviar"])) {
                        $valor = mysqli_real_escape_string($conexion, $_POST["txtvalor"]);
                        $fecha = mysqli_real_escape_string($conexion, $_POST["txtfecha"]);
                        $pro = mysqli_real_escape_string($conexion, $_POST["selectPro"]);

                        if (isset($_FILES['txtfoto']) && $_FILES['txtfoto']['error'] === 0) {
                            
                            if (!empty($valor) && !empty($fecha) && !empty($pro)) {

                                // Validar si ya existe una compra con la misma fecha y proveedor
                                $consultaExistencia = "SELECT id_compra_proveedor FROM compra_proveedor WHERE fecha = '$fecha' AND id_proveedor = '$pro'";
                                $resultadoExistencia = mysqli_query($conexion, $consultaExistencia);

                                if (mysqli_num_rows($resultadoExistencia) > 0) {
                                    echo '<script type="text/javascript">
                                    swal({
                                        title: "Mensaje",
                                        text: "Ya existe una compra registrada con la misma fecha y proveedor.",
                                        icon: "error",
                                        showCancelButton: false, 
                                        confirmButtonText: "OK" 
                                    }).then(function() {
                                        window.open("insert.php", "_SELF");
                                    });
                                    </script>';
                                } else {
                                    // Insertar el registro sin foto primero
                                    $sql = "INSERT INTO compra_proveedor (valor_total, fecha, id_proveedor, foto) 
                                            VALUES ('$valor', '$fecha', '$pro', '')";
                                    $result = mysqli_query($conexion, $sql) or die(mysqli_error($conexion));

                                    $id = mysqli_insert_id($conexion);
                                    
                                    // Crear carpeta img si no existe
                                    if (!file_exists('./img')) {
                                        mkdir('./img', 0777, true);
                                    }
                                    
                                    $extension = pathinfo($_FILES['txtfoto']['name'], PATHINFO_EXTENSION);
                                    $destino = "./img/" . $id . "." . $extension;
                                    $archivo = $_FILES['txtfoto']['tmp_name'];
                                    
                                    if (move_uploaded_file($archivo, $destino)) {
                                        $sql = "UPDATE compra_proveedor SET foto='$destino' WHERE id_compra_proveedor = $id";
                                        $result = mysqli_query($conexion, $sql) or die(mysqli_error($conexion));

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
                                            text: "Error al subir la imagen.",
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
                                    text: "Por favor, complete todos los campos.",
                                    icon: "error",
                                    showCancelButton: false, 
                                    confirmButtonText: "OK" 
                                }).then(function() {
                                    window.open("insert.php", "_SELF");
                                });
                                </script>';
                            }
                        } else {
                            echo '<script type="text/javascript">
                            swal({
                                title: "Mensaje",
                                text: "Por favor, debe agregar el comprobante de la compra.",
                                icon: "error",
                                showCancelButton: false, 
                                confirmButtonText: "OK" 
                            }).then(function() {
                                window.open("insert.php", "_SELF");
                            });
                            </script>';
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