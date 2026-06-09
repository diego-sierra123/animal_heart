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
                    REPORTES
                </h1>
            </div>

            <br>
            
            <div class="row justify-content-center mt-5">
                
                <!-- Reporte 1 -->
                <div class="col-md-4 mb-3">
                    <div class="card rounded report-card" style="border: 4px solid var(--border-color); background: linear-gradient(rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.2)); background-color: var(--card-bg); border-radius: 24px !important; transition: all 0.3s ease;">
                        <div class="card-body text-center">
                            <p class="report-title">
                                <i class="fas fa-chart-bar report-icon"></i> 1. Reporte
                            </p>
                            <p class="report-text">
                                ¡Explora el siguiente reporte!
                            </p>
                            <p class="report-text">
                                Cantidad de artículos
                            </p>
                            <br>
                            <a href="../reportes/reporte1.php" class="btn report-btn">
                                Ver Reporte
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Reporte 2 -->
                <div class="col-md-4 mb-3">
                    <div class="card rounded report-card" style="border: 4px solid var(--border-color); background: linear-gradient(rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.2)); background-color: var(--card-bg); border-radius: 24px !important; transition: all 0.3s ease;">
                        <div class="card-body text-center">
                            <p class="report-title">
                                <i class="fas fa-chart-bar report-icon"></i> 2. Reporte
                            </p>
                            <p class="report-text">
                                ¡Explora el siguiente reporte!
                            </p>
                            <p class="report-text">
                                Cantidad de artículos según el tipo
                            </p>
                            <br>
                            <a href="../reportes/reporte2.php" class="btn report-btn">
                                Ver Reporte
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Reporte 3 -->
                <div class="col-md-4 mb-3">
                    <div class="card rounded report-card" style="border: 4px solid var(--border-color); background: linear-gradient(rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.2)); background-color: var(--card-bg); border-radius: 24px !important; transition: all 0.3s ease;">
                        <div class="card-body text-center">
                            <p class="report-title">
                                <i class="fas fa-chart-bar report-icon"></i> 3. Reporte
                            </p>
                            <p class="report-text">
                                ¡Explora el siguiente reporte!
                            </p>
                            <p class="report-text">
                                Mascotas que contiene los clientes
                            </p>
                            <br>
                            <a href="../reportes/reporte3.php" class="btn report-btn">
                                Ver Reporte
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Reporte 4 -->
                <div class="col-md-4 mb-3">
                    <div class="card rounded report-card" style="border: 4px solid var(--border-color); background: linear-gradient(rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.2)); background-color: var(--card-bg); border-radius: 24px !important; transition: all 0.3s ease;">
                        <div class="card-body text-center">
                            <p class="report-title">
                                <i class="fas fa-chart-bar report-icon"></i> 4. Reporte
                            </p>
                            <p class="report-text">
                                ¡Explora el siguiente reporte!
                            </p>
                            <p class="report-text">
                                Cantidad de mascotas
                            </p>
                            <br>
                            <a href="../reportes/reporte4.php" class="btn report-btn">
                                Ver Reporte
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Reporte 5 -->
                <div class="col-md-4 mb-3">
                    <div class="card rounded report-card" style="border: 4px solid var(--border-color); background: linear-gradient(rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.2)); background-color: var(--card-bg); border-radius: 24px !important; transition: all 0.3s ease;">
                        <div class="card-body text-center">
                            <p class="report-title">
                                <i class="fas fa-chart-bar report-icon"></i> 5. Reporte
                            </p>
                            <p class="report-text">
                                ¡Explora el siguiente reporte!
                            </p>
                            <p class="report-text">
                                Cantidad de mascotas según el tipo de animal
                            </p>
                            <br>
                            <a href="../reportes/reporte5.php" class="btn report-btn">
                                Ver Reporte
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Reporte 6 -->
                <div class="col-md-4 mb-3">
                    <div class="card rounded report-card" style="border: 4px solid var(--border-color); background: linear-gradient(rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.2)); background-color: var(--card-bg); border-radius: 24px !important; transition: all 0.3s ease;">
                        <div class="card-body text-center">
                            <p class="report-title">
                                <i class="fas fa-chart-bar report-icon"></i> 6. Reporte
                            </p>
                            <p class="report-text">
                                ¡Explora el siguiente reporte!
                            </p>
                            <p class="report-text">
                                Ganancias del mes
                            </p>
                            <br>
                            <a href="../reportes/reporte6.php" class="btn report-btn">
                                Ver Reporte
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <br>
            <br>
            <br>

        </div>
        <br>
        <br>
    </div>
</div>

<style>
    /* Estilos para los textos de reportes - AHORA USAN LAS VARIABLES CSS */
    .report-title {
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        font-weight: bold;
        font-size: 18px;
        color: var(--text-primary) !important;
        margin-bottom: 10px;
    }
    
    .report-text {
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        font-weight: bold;
        font-size: 14px;
        color: var(--text-secondary) !important;
        margin-bottom: 5px;
    }
    
    .report-icon {
        margin-right: 5px;
        font-size: 16px;
        color: var(--primary-color) !important;
    }
    
    .report-btn {
        font-weight: bold;
        background-color: var(--primary-color) !important;
        color: white !important;
        border: 3px solid var(--border-color) !important;
        transition: all 0.3s ease;
        padding: 8px 20px;
    }
    
    .report-btn:hover {
        color: white !important;
        transform: translateY(-2px);
    }
    
    /* Estilos para hover de cards */
    .report-card {
        transition: all 0.3s ease;
    }
    
    .report-card:hover {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }
    
    /* Asegurar que los textos usen las variables CSS en todos los modos */
    
   
    
    
</style>

<?php include("../template_ingreso_admin/pie.php") ?>