<?php include("./template_inicio/cabecera.php") ?>
<br>
<br>
<br>
<br>

<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="mt-3 mb-2 unico">VETERINARIA ANIMAL HEAR<span class="text-danger">T</span></h1>
            <div style="width: 70%; margin: 0 auto;">
                <hr>
            </div>
            <h1 class="mt-4" style="font-size: 35px;">INICIAR SESIÓN</h1>
        </div>
    </div>
</div>

<br>
<br>

<section class="h-100">
    <div class="container py-5 h-50">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-10 col-lg-8 col-xl-6">
                <div class="card card-registration my-4 shadow-lg project-card" style="border: 2px solid gray; border-radius: 20px; overflow: hidden;">
                    <div class="row g-0">
                        <div class="col-lg-5 d-none d-lg-block p-0" style="min-height: 550px; background: linear-gradient(135deg, #e42323 0%, #ee6464 100%);">
                            <div class="d-flex flex-column justify-content-center align-items-center h-100 text-white p-4" style="background: rgba(0,0,0,0.3);">
                                <i class="fas fa-paw fa-4x mb-4"></i>
                                <h2 class="fw-bold text-center mb-3">¡Bienvenido de nuevo!</h2>
                                <div class="mt-3">
                                    <i class="fas fa-dog mx-2 fa-2x"></i>
                                    <i class="fas fa-cat mx-2 fa-2x"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="card-body p-4 p-md-5 text-black">
                                <div id="login-form">
                                    <div class="text-center mb-4 d-lg-none">
                                        <i class="fas fa-paw text-danger fa-3x mb-3"></i>
                                    </div>
                                    <h3 class="mb-4 text-center text-lg-start text-uppercase text-danger fw-bold">
                                        <i class="fas fa-lock me-2"></i>Acceso
                                    </h3>

                                    <form action="action_login/login.php" method="POST">
                                        <div class="form-floating mb-4">
                                            <input type="email" class="form-control" id="iniciar_correo" name="iniciar_correo" placeholder="" required>
                                            <label for="correo"><i class="fas fa-user me-2"></i>Correo</label>
                                        </div>

                                        <div class="form-floating mb-4">
                                            <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="" required>
                                            <label for="contraseña"><i class="fas fa-key me-2"></i>Contraseña</label>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <a href="#" id="olvide-contraseña" class="text-danger" style="text-decoration: none; font-weight: 500; transition: all 0.3s ease;">
                                                <i class="fas fa-key me-1"></i>¿Olvidaste tu contraseña?
                                            </a>
                                        </div>

                                        <div class="d-flex justify-content-end pt-3">
                                            <button type="reset" class="btn btn-secondary btn-hover borrar">Borrar datos</button>
                                            <button type="submit" class="btn btn-success ms-2 btn-hover">Iniciar Sesión</button>
                                        </div>
                                    </form>
                                </div>

                                <div id="olvide-form" style="display: none;">
                                    <div class="text-center mb-4 d-lg-none">
                                        <i class="fas fa-paw text-danger fa-3x mb-3"></i>
                                    </div>
                                    <h3 class="mb-4 text-center text-lg-start text-uppercase text-danger fw-bold">
                                        <i class="fas fa-key me-2"></i>Restaurar contraseña
                                    </h3>

                                    <form action="action_login/restaurar_contrasena.php" method="POST">
                                        <div class="form-floating mb-4">
                                            <input type="email" class="form-control" id="correo" name="correo" placeholder="" required>
                                            <label for="correo"><i class="fas fa-envelope me-2"></i>Correo</label>
                                        </div>

                                        <div class="form-floating mb-4">
                                            <input type="number" class="form-control" id="telefono" name="telefono" placeholder="" min="1" max="999999999999" required>
                                            <label for="telefono"><i class="fas fa-phone me-2"></i>Teléfono</label>
                                        </div>

                                        <div class="form-floating mb-4">
                                            <input type="number" class="form-control" id="n_documento" name="n_documento" placeholder="" min="1" max="999999999999" required>
                                            <label for="n_documento"><i class="fas fa-id-card me-2"></i>Número documento</label>
                                        </div>

                                        <div class="form-floating mb-4">
                                            <input type="password" class="form-control" id="n_contrasena" name="n_contrasena" placeholder="" required>
                                            <label for="n_contrasena"><i class="fas fa-lock me-2"></i>Nueva contraseña</label>
                                        </div>

                                        <div class="form-floating mb-4">
                                            <input type="password" class="form-control" id="c_contrasena" name="c_contrasena" placeholder="" required>
                                            <label for="c_contrasena"><i class="fas fa-check-circle me-2"></i>Confirmar contraseña</label>
                                        </div>

                                        <div class="text-center mb-4">
                                            <a href="#" id="volver-login" class="text-danger" style="text-decoration: none; font-weight: 500; transition: all 0.3s ease;">
                                                <i class="fas fa-arrow-left me-1"></i>Volver al inicio de sesión
                                            </a>
                                        </div>

                                        <div class="d-flex justify-content-end pt-3">
                                            <button type="reset" class="btn btn-secondary btn-hover borrarDos">Borrar datos</button>
                                            <button type="submit" class="btn btn-success ms-2 btn-hover">Restaurar</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="text-center mt-4 pt-3 border-top">
                                    <p class="mb-0">¿No tienes una cuenta?
                                        <a href="registrarse.php" class="text-danger fw-bold" style="text-decoration: none;">
                                            Regístrate <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('#olvide-contraseña').on('click', function(e) {
            e.preventDefault();
            $('#login-form').hide();
            $('#olvide-form').show();
        });

        $('#volver-login').on('click', function(e) {
            e.preventDefault();
            $('#olvide-form').hide();
            $('#login-form').show();
        });

        $(".borrar").on("click", function(e) {
            e.preventDefault();

            $("#iniciar_correo").val("");
            $("#contrasena").val("");

            // Verificar que Swal esté definido antes de usarlo
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Campos borrados',
                    text: 'Todos los campos han sido limpiados',
                    timer: 1500,
                    showConfirmButton: false,
                    didOpen: () => {
                        // Asegurar que no haya problemas con el target
                        const container = document.querySelector('.swal2-container');
                        if (container) {
                            container.style.zIndex = '9999';
                        }
                    }
                });
            } else {
                console.warn('SweetAlert2 no está disponible');
                alert('Campos borrados');
            }
        });

        $(".borrarDos").on("click", function(e) {
            e.preventDefault();

            $("#correo").val("");
            $("#telefono").val("");
            $("#n_documento").val("");
            $("#n_contrasena").val("");
            $("#c_contrasena").val("");

            // Verificar que Swal esté definido antes de usarlo
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Campos borrados',
                    text: 'Todos los campos han sido limpiados',
                    timer: 1500,
                    showConfirmButton: false,
                    didOpen: () => {
                        // Asegurar que no haya problemas con el target
                        const container = document.querySelector('.swal2-container');
                        if (container) {
                            container.style.zIndex = '9999';
                        }
                    }
                });
            } else {
                console.warn('SweetAlert2 no está disponible');
                alert('Campos borrados');
            }
        });
    });
</script>

<?php include("./template_inicio/pie.php") ?>