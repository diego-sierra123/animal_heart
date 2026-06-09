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

<?php include("../template_ingreso_admin/cabecera.php") ?>

        <?php include("../template_ingreso_admin/menu.php") ?>

            <div class="container-fluid container-main">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8  center-vertically">
                            <div class="centered-content">
                                <div class="header-content">
                                    <h2 class="header-subtitle">¡Bienvenido!</h2>
                                    <h1 class="header-title"><?php echo $_SESSION['nombre'] ?></h1>
                                    <h4 class="header-mono">
                                        <i class="fas fa-user-circle"></i>
                                        <span class="text-danger">●</span> <?php if($_SESSION["id_rol"] == 1){ echo "Administrador";} else{ echo "Empleado";} ?>
                                    </h4>
                                    <div class="d-flex gap-3">
                                        <a href="./perfil.php?persona=<?php echo $_SESSION['id'] ?>" class="btn-perfil">
                                            <i class="fas fa-user"></i>
                                            Ver Perfil
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<?php include("../template_ingreso_admin/pie.php") ?>