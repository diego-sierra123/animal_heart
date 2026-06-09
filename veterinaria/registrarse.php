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
            <h1 class="mt-4" style="font-size: 35px;">REGISTRARSE</h1>
        </div>
    </div>
</div>

<section class="h-100">
    <div class="container py-5 h-50">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col">
                <div class="card card-registration my-4 shadow-lg project-card" style="border: 2px solid gray; border-radius: 15px; overflow: hidden;">
                    <div class="row g-0" style="min-height: 800px;">
                        <div class="col-xl-6 p-0">
                            <img src="./img/registrarse.jpg"
                                alt="Sample photo"
                                class="img-fluid w-100 h-100"
                                style="object-fit: cover; object-position: center; min-height: 100%;" />
                        </div>
                        <div class="col-xl-6">
                            <div class="card-body p-md-5 text-black" style="max-height: 800px; overflow-y: auto;">
                                <h3 class="mb-5 text-uppercase text-danger fw-bold">Formulario de registro</h3>

                                <form action="action_login/registrarse.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-outline">
                                                <input type="text" id="nombres" name="nombres" class="form-control" placeholder="Ingrese sus nombres" minlength="1" maxlength="50" required />
                                                <label class="form-label" for="nombres">Nombres</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-outline">
                                                <input type="text" id="apellidos" name="apellidos" class="form-control" placeholder="Ingrese sus apellidos" minlength="1" maxlength="50" required />
                                                <label class="form-label" for="apellidos">Apellidos</label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-outline">
                                                <input type="number" id="telefono" name="telefono" class="form-control" placeholder="Ingrese su número de teléfono"   min="1" max="999999999999" required />
                                                <label class="form-label" for="telefono">Teléfono</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-outline">
                                                <input type="text" id="ciudad" name="ciudad" class="form-control" placeholder="Ingrese su ciudad" minlength="1" maxlength="25" required />
                                                <label class="form-label" for="ciudad">Ciudad</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-outline">
                                                <input type="text" id="barrio" name="barrio" class="form-control" placeholder="Ingrese su barrio" minlength="1" maxlength="25" required />
                                                <label class="form-label" for="barrio">Barrio</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-outline">
                                                <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Ingrese su dirección" minlength="1" maxlength="25" required />
                                                <label class="form-label" for="direccion">Dirección</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <select class="form-select" name="t_documento">
                                                <option value="N/A">-----</option>
                                                <option value="TI">Tarjeta de identidad</option>
                                                <option value="CC">Cédula de ciudadanía</option>
                                                <option value="CE">Cédula de extranjería</option>
                                                <option value="PAS">Pasaporte</option>
                                            </select>
                                            <label class="form-label" for="t_documento">Tipo de documento</label>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-outline">
                                                <input type="number" id="n_documento" name="n_documento" class="form-control" placeholder="Ingrese el número de documento" min="1" max="999999999999" required />
                                                <label class="form-label" for="n_documento">Número de documento</label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-outline mb-4">
                                        <input type="email" id="correo" name="correo" class="form-control" placeholder="Ingrese su correo" minlength="1" maxlength="50" required />
                                        <label class="form-label" for="correo">Correo electrónico</label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" id="contrasena" name="contrasena" class="form-control" placeholder="Ingrese su contraseña" minlength="1" maxlength="50" required />
                                        <label class="form-label" for="contrasena">Contraseña</label>
                                    </div>

                                    <div class="d-flex justify-content-end pt-3">
                                        <button type="button" class="btn btn-secondary btn-lg btn-hover borrar">Borrar datos</button>
                                        <button type="submit" class="btn btn-success btn-lg ms-2 btn-hover">Registrarse</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".borrar").on("click", function(e) {
                e.preventDefault();

                $("#nombres").val("");
                $("#apellidos").val("");
                $("#telefono").val("");
                $("#ciudad").val("");
                $("#barrio").val("");
                $("#direccion").val("");
                $("#n_documento").val("");
                $("#correo").val("");
                $("#contrasena").val("");
                $("select[name='t_documento']").val("N/A");

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
</section>

<?php include("./template_inicio/pie.php") ?>