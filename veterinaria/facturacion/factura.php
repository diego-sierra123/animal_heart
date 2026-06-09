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

            <div class="row text-center">
                <h1 id="unico" class="mt-3 text-center titulo-veterinaria">
                    FACTURACIÓN
                </h1>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <a href="../cliente/select.php" class="btn btn-dark m-2">
                        Regresar a Clientes
                    </a>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h4 class="mb-0">Nueva Factura</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_GET['facturar'])) {
                            $id_generarfactura = $_GET['facturar'];
                            $consultagenfac = "SELECT * FROM cliente WHERE id_cliente = '$id_generarfactura'";
                            $executegenfac = mysqli_query($conexion, $consultagenfac);
                            $fila = mysqli_fetch_assoc($executegenfac);

                            $idp = $fila['id_cliente'];
                            $nom = $fila['nombres'];
                            $ape = $fila['apellidos'];
                            $tdoc = $fila['t_documento'];
                            $ndoc = $fila['n_documento'];
                            $dir = $fila['direccion'];
                            $tel = $fila['telefono'];
                            $ciu = $fila['ciudad'];
                            $bar = $fila['barrio'];
                        }
                        ?>

                        <form name="update" action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" value="<?php echo $idp; ?>" name="txtnumdoc" disabled>
                            
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="" class="form-label fw-bold">Tipo Documento:</label>
                                    <input class="form-control" type="text" value="<?php echo $tdoc; ?>" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="form-label fw-bold">Número Documento:</label>
                                    <input class="form-control" type="text" value="<?php echo $ndoc; ?>" name="txtnumdoc" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="form-label fw-bold">Teléfono:</label>
                                    <input class="form-control" type="text" value="<?php echo $tel; ?>" name="txttelefono" disabled>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Nombres:</label>
                                    <input class="form-control" type="text" value="<?php echo $nom; ?>" name="txtnombre" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Apellidos:</label>
                                    <input class="form-control" type="text" value="<?php echo $ape; ?>" name="txtapellido" disabled>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Ciudad:</label>
                                    <input class="form-control" type="text" value="<?php echo $ciu; ?>" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Barrio:</label>
                                    <input class="form-control" type="text" value="<?php echo $bar; ?>" disabled>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Dirección:</label>
                                    <input class="form-control" type="text" value="<?php echo $dir; ?>" name="txtdireccion" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Fecha factura:</label>
                                    <?php
                                    $hora_actual = date('Y-m-d H:i:s');
                                    $horas_a_retrasar = 7;
                                    $nueva_fecha = date('Y-m-d', strtotime($hora_actual . ' - ' . $horas_a_retrasar . ' hours'));
                                    ?>
                                    <input class="form-control" type="date" name="txtfecha" min="<?php echo $nueva_fecha; ?>" max="<?php echo $nueva_fecha; ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Atendido por:</label>
                                    <select name="selectempleado" class="form-control" required>
                                        <option value="">Seleccione un empleado</option>
                                        <?php
                                        $consulta = "SELECT * FROM empleado";
                                        $ejecutar = mysqli_query($conexion, $consulta);
                                        while ($res = mysqli_fetch_assoc($ejecutar)) {
                                            echo "<option value='" . $res['id_empleado'] . "'>" . $res['nombre'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 text-center">
                                    <button type="submit" name="insertarp" class="btn btn-success">
                                        Insertar Datos
                                    </button>
                                </div>
                            </div>

                            <?php
                            if (isset($_POST['insertarp'])) {
                                $selecte = $_POST['selectempleado'];
                                $fecha = $_POST['txtfecha'];

                                $sql = "INSERT INTO factura(id_cliente, fecha, id_empleado, id_veterinaria, id_estado_factura, total_factura) 
                                        VALUES ('$id_generarfactura', '$fecha', '$selecte', 1, 1, 0)";
                                $result = mysqli_query($conexion, $sql) or die(mysqli_error($conexion));

                                $idp = mysqli_insert_id($conexion);
                                $_SESSION['id_factura'] = $idp;

                                echo '<script type="text/javascript">
                                    swal({
                                        title: "Mensaje",
                                        text: "Factura creada exitosamente.",
                                        icon: "success",
                                        showCancelButton: false,
                                        confirmButtonText: "OK"
                                    }).then(function() {
                                        window.location = "detallefactura.php";
                                    });
                                </script>';
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../template_ingreso_admin/pie.php") ?>