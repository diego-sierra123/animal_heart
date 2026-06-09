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
                    <h2 class="text-light mt-3 text-center" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;"><b>AGREGAR ARTICULO</b></h2>

                    <form class="row justify-content-center align-content-center g-3 mt-3" name="insert" action="insert.php" method="post" enctype="multipart/form-data">
                        <br>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-light" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff; font-size: 20px;"><b>Nombre:</b></label>
                                <input type="text" class="form-control" name="txtnombre" placeholder="Ingrese el nombre" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-light" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff; font-size: 20px;"><b>Descripción:</b></label>
                                <textarea class="form-control" name="txtdescripcion" placeholder="Ingrese la descripción" style="background-color: rgba(255, 255, 255, 0.8); color: #000; height: 38px;" required></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-light" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff; font-size: 20px;"><b>Valor:</b></label>
                                <input type="number" class="form-control" name="txtvalor" min="0" placeholder="Ingrese el valor" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-light" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff; font-size: 20px;"><b>Costo conseguido:</b></label>
                                <input type="number" class="form-control" name="txtcosto" min="0" placeholder="Ingrese el costo conseguido" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-light" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff; font-size: 20px;"><b>Stock:</b></label>
                                <input type="number" class="form-control" name="txtstock" min="0" max="10000" placeholder="Ingrese el stock" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-light" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff; font-size: 20px;"><b>Fecha vencimiento:</b></label>
                                <?php
                                $hora_actual = date('Y-m-d H:i:s');
                                $horas_a_retrasar = 7;
                                $nueva_fecha = date('Y-m-d', strtotime($hora_actual . ' - ' . $horas_a_retrasar . ' hours'));
                                ?>
                                <input type="date" class="form-control" name="txtfecha" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" min="<?php echo $nueva_fecha; ?>">
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
                                <label class="form-label text-light" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff; font-size: 20px;"><b>Tipo artículo:</b></label>
                                <select class="form-select" name="selecttipo" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <option value="">-----</option>
                                    <?php
                                    $consulta = "SELECT * FROM tipo_articulo";
                                    $ejecutar = mysqli_query($conexion, $consulta);
                                    while ($respuesta = mysqli_fetch_assoc($ejecutar)) {
                                        echo "<option value='" . $respuesta['id_tipo_articulo'] . "'>" . $respuesta['nombre'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-light" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff; font-size: 20px;"><b>Marca:</b></label>
                                <input type="text" class="form-control" name="txtmarca" placeholder="Ingrese la marca" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Tipo mascota:</label>
                                <select name="txttipomascota" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <option value="">-----</option>
                                    <option value="Perros">Perros</option>
                                    <option value="Gatos">Gatos</option>
                                    <option value="Roedores">Roedores</option>
                                    <option value="Aves">Aves</option>
                                    <option value="Peces">Peces</option>
                                    <option value="Perros y gatos">Perros y gatos</option>
                                    <option value="Cualquiera">Cualquiera</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="form-label" style="font-size: 20px; font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff;">Tamaño mascota:</label>
                                <select name="txttamano" class="form-control" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                                    <option value="">-----</option>
                                    <option value="Pequeños">Pequeños</option>
                                    <option value="Medianos">Medianos</option>
                                    <option value="Grandes">Grandes</option>
                                    <option value="Cualquiera">Cualquiera</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-light" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff; font-size: 20px;"><b>Etapa de vida:</b></label>
                                <input type="text" class="form-control" name="txtetapa" placeholder="Ingrese la etapa de vida" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label text-light" style="font-weight: bold; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); color: #fff; font-size: 20px;"><b>Adjuntar foto:</b></label>
                                <input type="file" class="form-control" name="txtfoto" id="id" style="background-color: rgba(255, 255, 255, 0.8); color: #000;" accept="image/*" required>
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
                                    <input type="submit" name="enviar" value="Agregar" class="btn btn-success mb-5 m-2">
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST["enviar"])) {
                        $nom = mysqli_real_escape_string($conexion, $_POST["txtnombre"]);
                        $des = mysqli_real_escape_string($conexion, $_POST["txtdescripcion"]);
                        $mar = mysqli_real_escape_string($conexion, $_POST["txtmarca"]);
                        $tip = mysqli_real_escape_string($conexion, $_POST["txttipomascota"]);
                        $tam = mysqli_real_escape_string($conexion, $_POST["txttamano"]);
                        $eta = mysqli_real_escape_string($conexion, $_POST["txtetapa"]);
                        $valor = $_POST["txtvalor"];
                        $costo = $_POST["txtcosto"];
                        $stock = $_POST["txtstock"];
                        $fecha = !empty($_POST["txtfecha"]) ? $_POST["txtfecha"] : null;
                        $pro = $_POST["selectPro"];
                        $tipopro = $_POST['selecttipo'];

                        if (isset($_FILES['txtfoto']) && $_FILES['txtfoto']['error'] === 0) {
                            
                            if (!empty($nom) && !empty($des) && !empty($valor) && !empty($stock) && !empty($pro) && !empty($tipopro) && !empty($mar) && !empty($tip) && !empty($tam) && !empty($eta)) {

                                $consultaExistencia = "SELECT id_articulo FROM articulo WHERE nombre = '$nom' AND id_proveedor = '$pro' AND id_tipo_articulo = '$tipopro'";
                                $resultadoExistencia = mysqli_query($conexion, $consultaExistencia);

                                if (mysqli_num_rows($resultadoExistencia) > 0) {
                                    echo '<script type="text/javascript">
                                    swal({
                                        title: "Mensaje",
                                        text: "Ya existe un artículo con los mismos datos.",
                                        icon: "error",
                                        showCancelButton: false, 
                                        confirmButtonText: "OK" 
                                    }).then(function() {
                                        window.open("insert.php", "_SELF");
                                    });
                                    </script>';
                                } else {
                                    $sql = "INSERT INTO articulo (nombre, descripcion, mascota, marca, tamano_mascota, etapa_vida, valor, costo_conseguido, stock, fecha_vencimiento, id_proveedor, id_tipo_articulo, foto) 
                                            VALUES ('$nom', '$des', '$tip', '$mar', '$tam', '$eta', '$valor', '$costo', '$stock', " . ($fecha ? "'$fecha'" : "NULL") . ", '$pro', '$tipopro', '')";
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
                                        $sql = "UPDATE articulo SET foto='$destino' WHERE id_articulo = $id";
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
                                text: "Por favor, debe agregar la foto del artículo.",
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