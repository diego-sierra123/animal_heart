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

<?php include("../template_ingreso_cliente/cabecera.php") ?>

        <?php include("../template_ingreso_cliente/menu.php") ?>


            <div class="container-fluid container-main">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8  center-vertically">
                            <div class="centered-content">
                                <div class="header-content">
                                    <h2 class="header-subtitle">¡Bienvenido de vuelta!</h2>
                                    <h1 class="header-title"><?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ?></h1>
                                    <h4 class="header-mono">
                                        <i class="fas fa-user-circle"></i>
                                        <span class="text-danger">●</span> Cliente
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

<?php include("../template_ingreso_cliente/pie.php") ?>