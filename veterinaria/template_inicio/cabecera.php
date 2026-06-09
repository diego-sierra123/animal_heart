<?php include("./database/conexion.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VETERINARIA HEART</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./style/paginas_de_inicio.css">
    <link rel="icon" href="./img/logo.png">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            // Cargar modo guardado
            if (localStorage.getItem("modo") === "oscuro") {
                $("body").addClass("modo-oscuro");
                $("#modo-icon").removeClass("fa-sun").addClass("fa-moon");
                $("#modo-btn").removeClass("btn-outline-dark").addClass("btn-outline-light")
            } else {
                $("body").addClass("modo-claro");
                $("#modo-btn").removeClass("btn-outline-light").addClass("btn-outline-dark")
            }

            $("#modo-btn").click(function() {

                $("body").toggleClass("modo-claro modo-oscuro");

                if ($("body").hasClass("modo-oscuro")) {
                    $("#modo-icon").removeClass("fa-sun").addClass("fa-moon");
                    $("#modo-btn").removeClass("btn-outline-dark").addClass("btn-outline-light")
                    localStorage.setItem("modo", "oscuro");
                    $('.container-main').css('background', 'linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url("./img/fondo2.png")');
                    $('.pagination a').css('color', 'white');
                    $('.pagination a').css('border-color', 'white');
                    $('#unico').css('color', 'white');
                    $('.unico').css('color', 'white');
                    $('.unicoo:hover').css('color', 'black');
                    $('#pp').css('color', 'white');
                    $('hr').css('border-color', 'white');
                    $('email-link:hover').css('color', '#d9534f');
                } else {
                    $("#modo-icon").removeClass("fa-moon").addClass("fa-sun");
                    $("#modo-btn").removeClass("btn-outline-light").addClass("btn-outline-dark")
                    localStorage.setItem("modo", "claro");
                    $('.container-main').css('background', 'linear-gradient(rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.8)), url("./img/fondo2.png")');
                    $('#unico').css('color', 'black');
                    $('.unico').css('color', 'black');
                    $('.unicoo:hover').css('color', 'black');
                    $('#pp').css('color', 'black');
                    $('hr').css('border-color', 'black');
                    $('.pagination a').css('color', 'black');
                    $('.pagination a').css('border-color', 'black');
                    $('hr').css('color', 'black');
                    $('email-link:hover').css('color', '#d9534f');
                }

            });

        });

        $(document).ready(function() {
            $("#olvide-contraseña").click(function(e) {
                e.preventDefault();

                $("#login-form").fadeOut(300, function() {
                    $("#olvide-form").fadeIn(300);
                });
            });

            $("#volver-login").click(function(e) {
                e.preventDefault();

                $("#olvide-form").fadeOut(300, function() {
                    $("#login-form").fadeIn(300);
                });
            });
        });
    </script>


</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
            <div class="container">
                <a class="navbar-brand" href="index.php"><img src="./img/logo.png" alt="" width="50px"></a>
                <a href="index.php" class="navbar-brand"> <span class="text-light" style="font-size: 20px;"> <b class="titulo"> ANIMAL </b> </span> <b class="titulo">HEAR</b><span class="text-danger" style="font-size: 20px;"><b>T</b></span></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navegador" aria-controls="navegador" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navegador">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 text-center">
                        <li class="nav-item borde" style="margin-right: 20px; margin-bottom: 2px;">
                            <a href="index.php" class="nav-link aumentar" style="font-size: 20px; color:white;"> <b> Inicio </b> </a>
                        </li>

                        <li class="nav-item borde" style="margin-right: 20px; margin-bottom: 2px;">
                            <a href="servicio.php" class="nav-link aumentar" style="font-size: 20px; color:white;"> <b> Servicios </b> </a>
                        </li>

                        <li class="nav-item borde" style="margin-right: 20px; margin-bottom: 2px;">
                            <a href="ubicacion.php" class="nav-link aumentar" style="font-size: 20px; color:white;"> <b> Ubicación </b> </a>
                        </li>

                        <li class="nav-item borde" style="margin-right: 20px; margin-bottom: 2px;">
                            <a href="articulo/catalogo.php" class="nav-link aumentar" style="font-size: 20px; color:white;"> <b> Artículos </b> </a>
                        </li>

                        <li class="nav-item borde" style="margin-right: 20px; margin-bottom: 2px;">
                            <a href="registrarse.php" class="nav-link aumentar" style="font-size: 20px; color:white;"> <b> Registrarse </b> </a>
                        </li>

                        <li class="nav-item borde" style="margin-right: 20px; margin-bottom: 2px;">
                            <a href="login.php" class="nav-link aumentar" style="font-size: 20px; color:white;"> <b> Iniciar Sesión </b> </a>
                        </li>

                        <li class="nav-item" style="margin-right: 20px; margin-top: 8px; margin-bottom: 8px;">
                            <button id="modo-btn" class="btn btn-outline-light border-0">
                                <i id="modo-icon" class="fas fa-sun"></i>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="cuerpo">