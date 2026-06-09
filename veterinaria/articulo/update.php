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
            $nombre = '';
            $descripcion = '';
            $mascota = '';
            $marca = '';
            $tamano_mascota = '';
            $etapa_vida = '';
            $valor = '';
            $costo_conseguido = '';
            $stock = '';
            $fecha_vencimiento = '';
            $foto = '';
            $id_proveedor = '';
            $id_tipo_articulo = '';

            if (isset($_GET['actualizar'])) {
                $editarId = mysqli_real_escape_string($conexion, $_GET['actualizar']);
                $consulta = "SELECT * FROM articulo WHERE id_articulo = '$editarId'";
                $ejecutar = mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));

                if ($ejecutar && mysqli_num_rows($ejecutar) > 0) {
                    $fila = mysqli_fetch_assoc($ejecutar);
                    $nombre = $fila['nombre'];
                    $descripcion = $fila['descripcion'];
                    $mascota = $fila['mascota'];
                    $marca = $fila['marca'];
                    $tamano_mascota = $fila['tamano_mascota'];
                    $etapa_vida = $fila['etapa_vida'];
                    $valor = $fila['valor'];
                    $costo_conseguido = $fila['costo_conseguido'];
                    $stock = $fila['stock'];
                    $fecha_vencimiento = $fila['fecha_vencimiento'];
                    $foto = $fila['foto'];
                    $id_proveedor = $fila['id_proveedor'];
                    $id_tipo_articulo = $fila['id_tipo_articulo'];
                }
            }
            ?>

            <div class="row justify-content-center mt-5">
                <div class="col-10 col-sm-8 col-md-7 col-lg-6 custom-border background-image">
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>ACTUALIZAR ARTICULO</b></h2>

                    
                    <div class="row justify-content-center mt-3">
                        <div class="col-8 text-center">
                            <img src="<?php echo $foto; ?>" style="width: 200px; height: 200px; border: 2px solid white; border-radius: 8px; object-fit: cover;">
                            <br>
                        </div>
                    </div>
                    

                    <form class="row justify-content-center align-content-center g-3 mt-3" name="insert" action="update.php" method="post" enctype="multipart/form-data">
                        <br>

                        <div class="col-10 col-sm-8 col-md-7 col-lg-7 text-light d-none">
                            <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Id Artículo:</label>
                            <input type="text" name="txtid" value="<?php echo $editarId; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" readonly>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Nombre:</label>
                                <input type="text" name="txtnombre" value="<?php echo $nombre; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Descripción:</label>
                                <textarea name="txtdescripcion" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required><?php echo $descripcion; ?></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Valor:</label>
                                <input type="number" name="txtvalor" value="<?php echo $valor; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" min="0" required>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Costo conseguido:</label>
                                <input type="number" name="txtcostoconseguido" value="<?php echo $costo_conseguido; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" min="0" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Stock:</label>
                                <?php if (($editarId >= 190 && $editarId <= 192) || ($editarId >= 210 && $editarId <= 221)): ?>
                                    <input type="number" name="txtstock" value="<?php echo $stock; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" readonly>
                                <?php else: ?>
                                    <input type="number" name="txtstock" value="<?php echo $stock; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" min="0" max="10000" required>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Marca:</label>
                                <?php if (($editarId >= 190 && $editarId <= 192) || ($editarId >= 210 && $editarId <= 221)): ?>
                                    <input type="text" name="txtmarca" value="<?php echo $marca; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" readonly>
                                <?php else: ?>
                                    <input type="text" name="txtmarca" value="<?php echo $marca; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Tipo mascota:</label>
                                <select name="txtmascota" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <option value="">-----</option>
                                    <option value="Perros" <?php echo ($mascota == 'Perros') ? 'selected' : ''; ?>>Perros</option>
                                    <option value="Gatos" <?php echo ($mascota == 'Gatos') ? 'selected' : ''; ?>>Gatos</option>
                                    <option value="Roedores" <?php echo ($mascota == 'Roedores') ? 'selected' : ''; ?>>Roedores</option>
                                    <option value="Aves" <?php echo ($mascota == 'Aves') ? 'selected' : ''; ?>>Aves</option>
                                    <option value="Peces" <?php echo ($mascota == 'Peces') ? 'selected' : ''; ?>>Peces</option>
                                    <option value="Perros y gatos" <?php echo ($mascota == 'Perros y gatos') ? 'selected' : ''; ?>>Perros y gatos</option>
                                    <option value="Cualquiera" <?php echo ($mascota == 'Cualquiera') ? 'selected' : ''; ?>>Cualquiera</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Tamaño mascota:</label>
                                <select name="txttamano" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <option value="">-----</option>
                                    <option value="Pequeños" <?php echo ($tamano_mascota == 'Pequeños') ? 'selected' : ''; ?>>Pequeños</option>
                                    <option value="Medianos" <?php echo ($tamano_mascota == 'Medianos') ? 'selected' : ''; ?>>Medianos</option>
                                    <option value="Grandes" <?php echo ($tamano_mascota == 'Grandes') ? 'selected' : ''; ?>>Grandes</option>
                                    <option value="Cualquiera" <?php echo ($tamano_mascota == 'Cualquiera') ? 'selected' : ''; ?>>Cualquiera</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Etapa de vida:</label>
                                <input type="text" name="txtetapa" value="<?php echo $etapa_vida; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Fecha de vencimiento:</label>
                                <?php if (($editarId >= 190 && $editarId <= 192) || ($editarId >= 210 && $editarId <= 221)): ?>
                                    <input type="text" class="form-control" value="No contiene fecha" style="background-color: rgba(255, 255, 255, 0.8); color: red;" readonly>
                                    <input type="hidden" name="txtfecha" value="">
                                <?php else: ?>
                                    <input type="date" name="txtfecha" value="<?php echo $fecha_vencimiento; ?>" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" min="<?php echo date('Y-m-d'); ?>">
                                <?php endif; ?>
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
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Tipo Artículo:</label>
                                <select name="txttipo" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <option value="">-----</option>
                                    <?php
                                    $consulta = "SELECT * FROM tipo_articulo";
                                    $ejecutar_tipo = mysqli_query($conexion, $consulta);
                                    while ($respuesta = mysqli_fetch_assoc($ejecutar_tipo)) {
                                        $selected = ($respuesta['id_tipo_articulo'] == $id_tipo_articulo) ? 'selected' : '';
                                        echo "<option value='" . $respuesta['id_tipo_articulo'] . "' $selected>" . $respuesta['nombre'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Cambiar foto (opcional):</label>
                                <?php if ($editarId > 221): ?>
                                    <input type="file" name="txtfoto" id="id" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" accept="image/*">
                                <?php else: ?>
                                    <input type="text" class="form-control" value="Imagen predeterminada - No se puede cambiar" style="background-color: rgba(255, 255, 255, 0.8); color: red;" readonly>
                                <?php endif; ?>
                            </div>
                        </div>

                        <br>
                        <br>
                        <div class="col-10 col-sm-8 col-md-7 col-lg-6 m-4 text-center">
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="../articulo/select.php" class="btn btn-secondary m-2">Atrás</a>
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
                        $nom = mysqli_real_escape_string($conexion, $_POST["txtnombre"]);
                        $des = mysqli_real_escape_string($conexion, $_POST["txtdescripcion"]);
                        $mar = mysqli_real_escape_string($conexion, $_POST["txtmarca"]);
                        $tip = mysqli_real_escape_string($conexion, $_POST["txtmascota"]);
                        $tam = mysqli_real_escape_string($conexion, $_POST["txttamano"]);
                        $eta = mysqli_real_escape_string($conexion, $_POST["txtetapa"]);
                        $valor = $_POST["txtvalor"];
                        $costo = $_POST["txtcostoconseguido"];
                        $stock = $_POST["txtstock"];
                        $fecha = !empty($_POST["txtfecha"]) ? $_POST["txtfecha"] : null;
                        $provee = $_POST["txtproveedor"];
                        $tipo = $_POST["txttipo"];

                        if (empty($idPac) || empty($nom) || empty($des) || empty($valor) || empty($provee) || empty($tipo) || empty($mar) || empty($tip) || empty($tam) || empty($eta)) {
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

                            $consulta_existencia = "SELECT COUNT(*) AS existe FROM articulo WHERE nombre='$nom' AND id_proveedor='$provee' AND id_tipo_articulo='$tipo' AND id_articulo != '$idPac'";
                            $ejecutar_existencia = mysqli_query($conexion, $consulta_existencia) or die(mysqli_error($conexion));
                            $resultado_existencia = mysqli_fetch_assoc($ejecutar_existencia);

                            if ($resultado_existencia['existe'] > 0) {
                                echo '<script type="text/javascript">
                                    swal({
                                        title: "Mensaje",
                                        text: "Los nuevos datos ya existen en la base de datos.",
                                        icon: "error",
                                        showCancelButton: false, 
                                        confirmButtonText: "OK" 
                                    }).then(function() {
                                        window.open("update.php?actualizar=' . $idPac . '", "_SELF");
                                    });
                                </script>';
                            } else {
                                
                                if ($fecha) {
                                    $sql = "UPDATE articulo SET 
                                            nombre='$nom', 
                                            descripcion='$des', 
                                            mascota='$tip', 
                                            marca='$mar', 
                                            tamano_mascota='$tam', 
                                            etapa_vida='$eta', 
                                            fecha_vencimiento='$fecha', 
                                            valor='$valor', 
                                            costo_conseguido='$costo', 
                                            stock='$stock', 
                                            id_proveedor='$provee', 
                                            id_tipo_articulo='$tipo'";
                                } else {
                                    $sql = "UPDATE articulo SET 
                                            nombre='$nom', 
                                            descripcion='$des', 
                                            mascota='$tip', 
                                            marca='$mar', 
                                            tamano_mascota='$tam', 
                                            etapa_vida='$eta', 
                                            fecha_vencimiento=NULL, 
                                            valor='$valor', 
                                            costo_conseguido='$costo', 
                                            stock='$stock', 
                                            id_proveedor='$provee', 
                                            id_tipo_articulo='$tipo'";
                                }

                                // Procesar nueva imagen si se subió
                                if ($_FILES['txtfoto']['size'] > 0 && $_FILES['txtfoto']['error'] == 0 && $idPac >= 222) {
                                    
                                    // Eliminar imagen anterior
                                    $consulta_imagen = "SELECT foto FROM articulo WHERE id_articulo = '$idPac'";
                                    $ejecutar_imagen = mysqli_query($conexion, $consulta_imagen);
                                    $fila_imagen = mysqli_fetch_assoc($ejecutar_imagen);
                                    $imagenAnterior = $fila_imagen['foto'];
                                    
                                    if (!empty($imagenAnterior) && file_exists($imagenAnterior) && $imagenAnterior != './img/' . $idPac . '.jpg' && $imagenAnterior != './img/' . $idPac . '.png' && $imagenAnterior != './img/' . $idPac . '.jpeg' && $imagenAnterior != './img/' . $idPac . '.gif') {
                                        unlink($imagenAnterior);
                                    }
                                    
                                    $archivo = $_FILES['txtfoto']['tmp_name'];
                                    $extension = pathinfo($_FILES['txtfoto']['name'], PATHINFO_EXTENSION);
                                    $destino = "./img/" . $idPac . "." . $extension;
                                    
                                    if (move_uploaded_file($archivo, $destino)) {
                                        $sql .= ", foto='$destino'";
                                    }
                                }

                                $sql .= " WHERE id_articulo='$idPac'";

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