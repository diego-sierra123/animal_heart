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

            <br>

            <?php
            $editarId = '';
            $fecha = '';
            $valor = '';
            $id_proveedor = '';
            $foto = '';

            if (isset($_GET['actualizar'])) {
                $editarId = mysqli_real_escape_string($conexion, $_GET['actualizar']);
                $consulta = "SELECT * FROM compra_proveedor WHERE id_compra_proveedor = '$editarId'";
                $ejecutar = mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));

                if ($ejecutar && mysqli_num_rows($ejecutar) > 0) {
                    $fila = mysqli_fetch_assoc($ejecutar);
                    $fecha = $fila['fecha'];
                    $valor = $fila['valor_total'];
                    $id_proveedor = $fila['id_proveedor'];
                    $foto = $fila['foto'];
                }
            }
            ?>

            <div class="row justify-content-center mt-5">
                <div class="col-10 col-sm-8 col-md-7 col-lg-6 custom-border background-image">
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>ACTUALIZAR COMPRA</b></h2>

                    <div class="row justify-content-center mt-3">
                        <div class="col-8 text-center">
                            <?php if (!empty($foto) && file_exists($foto)): ?>
                                <img src="<?php echo $foto; ?>" style="width: 200px; height: 200px; border: 2px solid white; border-radius: 8px; object-fit: cover;">
                            <?php else: ?>
                                <p class="text-light">Sin imagen disponible</p>
                            <?php endif; ?>
                            <br>
                        </div>
                    </div>

                    <form class="row justify-content-center align-content-center g-3 mt-3" name="insert" action="update.php" method="post" enctype="multipart/form-data">
                        <br>

                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light d-none">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Id Compra:</label>
                            <input type="text" name="txtid" value="<?php echo $editarId; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" readonly>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha de la compra:</label>
                                <input type="date" name="txtfecha" value="<?php echo $fecha; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Valor Total:</label>
                                <input type="number" name="txtvalor" value="<?php echo $valor; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" min="0" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Proveedor:</label>
                                <select name="txtproveedor" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <option value="">-----</option>
                                    <?php
                                    $consulta = "SELECT * FROM proveedor";
                                    $ejecutar_prov = mysqli_query($conexion, $consulta);
                                    while ($respuesta = mysqli_fetch_assoc($ejecutar_prov)) {
                                        $selected = ($respuesta['id_proveedor'] == $id_proveedor) ? 'selected' : '';
                                        echo "<option value='" . $respuesta['id_proveedor'] . "' $selected>" . $respuesta['nombre'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Cambiar comprobante (opcional):</label>
                                <input type="file" name="txtfoto" id="id" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" accept="image/*">
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
                                    <input type="submit" name="actualizar" value="Actualizar" class="btn btn-primary mb-5 m-2">
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST["actualizar"])) {
                        $idPac = mysqli_real_escape_string($conexion, $_POST["txtid"]);
                        $fecha = mysqli_real_escape_string($conexion, $_POST["txtfecha"]);
                        $valor = mysqli_real_escape_string($conexion, $_POST["txtvalor"]);
                        $provee = mysqli_real_escape_string($conexion, $_POST["txtproveedor"]);

                        if (empty($idPac) || empty($fecha) || empty($valor) || empty($provee)) {
                            echo '<script type="text/javascript">
                            swal({
                                title: "Mensaje",
                                text: "Por favor, complete los campos obligatorios.",
                                icon: "error",
                                showCancelButton: false,
                                confirmButtonText: "OK"
                            }).then(function() {
                                window.open("update.php?actualizar=' . $idPac . '", "_SELF");
                            });
                            </script>';
                        } else {

                            $consulta_existencia = "SELECT COUNT(*) AS existe FROM compra_proveedor WHERE fecha='$fecha' AND id_proveedor='$provee' AND id_compra_proveedor != '$idPac'";
                            $ejecutar_existencia = mysqli_query($conexion, $consulta_existencia) or die(mysqli_error($conexion));
                            $resultado_existencia = mysqli_fetch_assoc($ejecutar_existencia);

                            if ($resultado_existencia['existe'] > 0) {
                                echo '<script type="text/javascript">
                                    swal({
                                        title: "Mensaje",
                                        text: "Ya existe una compra con la misma fecha y proveedor.",
                                        icon: "error",
                                        showCancelButton: false, 
                                        confirmButtonText: "OK" 
                                    }).then(function() {
                                        window.open("update.php?actualizar=' . $idPac . '", "_SELF");
                                    });
                                </script>';
                            } else {
                                
                                $sql = "UPDATE compra_proveedor SET 
                                        fecha='$fecha', 
                                        valor_total='$valor', 
                                        id_proveedor='$provee'";

                                // Procesar nueva imagen si se subió
                                if ($_FILES['txtfoto']['size'] > 0 && $_FILES['txtfoto']['error'] == 0) {
                                    
                                    // Eliminar imagen anterior
                                    $consulta_imagen = "SELECT foto FROM compra_proveedor WHERE id_compra_proveedor = '$idPac'";
                                    $ejecutar_imagen = mysqli_query($conexion, $consulta_imagen);
                                    $fila_imagen = mysqli_fetch_assoc($ejecutar_imagen);
                                    $imagenAnterior = $fila_imagen['foto'];
                                    
                                    if (!empty($imagenAnterior) && file_exists($imagenAnterior)) {
                                        unlink($imagenAnterior);
                                    }
                                    
                                    $archivo = $_FILES['txtfoto']['tmp_name'];
                                    $extension = pathinfo($_FILES['txtfoto']['name'], PATHINFO_EXTENSION);
                                    $destino = "./img/" . $idPac . "." . $extension;
                                    
                                    if (move_uploaded_file($archivo, $destino)) {
                                        $sql .= ", foto='$destino'";
                                    }
                                }

                                $sql .= " WHERE id_compra_proveedor='$idPac'";

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