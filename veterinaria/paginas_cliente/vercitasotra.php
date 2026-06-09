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

<!-- SweetAlert2 CSS y JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php include("../template_ingreso_cliente/menu.php") ?>

<div class="container-fluid container-main">
    <div class="container">
        <div class="row justify-content-center">

            <div class="row text-center">
                <h1 class="mt-3 text-center titulo-veterinaria">
                    BUSCAR CITAS POR FECHA
                </h1>
            </div>

            <div id="table-container">

                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3" style="margin-left: 0; padding-left: 0;">
                            <a href="vercitas.php" class="btn btn-dark m-2">Ver citas de hoy</a>
                            <a href="historialcita.php" class="btn btn-secondary m-2">Regresar al historial</a>
                        </div>
                    </div>
                </div>

                <form id="search-form" class="search-form" style="justify-content: flex-start; margin-left: 0; padding-left: 0;">
                    <input type="text" id="search-input" 
                        placeholder="Ingrese la fecha (YYYY-MM-DD)..."
                        style="margin-left: 0; width: 500px;">
                    <button type="button" class="btn btn-secondary" id="borrar_contenido">Borrar</button>
                </form>

                <br>
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-sm text-center align-middle w-100 tabla-veterinaria" style="border: 2px solid black; font-size: 0.9rem;">
                        <thead>
                             <tr>
                                <th scope="col">CITA</th>
                                <th scope="col">FECHA</th>
                                <th scope="col">HORA</th>
                             </tr>
                        </thead>
                        <tbody id="tabla-body">
                            <tr>
                                <td colspan="3" class="text-center">Ingrese una fecha para buscar</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var timeoutId = null;

        function realizarBusqueda() {
            var searchTerm = $('#search-input').val();

            if (searchTerm.trim() === '') {
                $('#tabla-body').html('<tr><td colspan="3" class="text-center">Ingrese una fecha para buscar</td></tr>');
                return;
            }

            $.ajax({
                url: 'search_cita_fecha.php',
                type: 'POST',
                data: {
                    search: searchTerm
                },
                success: function(response) {
                    $('#tabla-body').html(response);
                }
            });
        }

        $('#search-input').on('input', function() {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(function() {
                realizarBusqueda();
            }, 500);
        });

        $('#borrar_contenido').click(function() {
            $('#search-input').val('');
            $('#tabla-body').html('<tr><td colspan="3" class="text-center">Ingrese una fecha para buscar</td></tr>');
        });
    });
</script>

<?php include("../template_ingreso_cliente/pie.php") ?>