<?php

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../registrarse.php");
    exit();
}

include("../database/conexion.php");

$nombres = $_POST["nombres"];
$apellidos = $_POST["apellidos"];
$telefono = $_POST["telefono"];
$ciudad = $_POST["ciudad"];
$barrio = $_POST["barrio"];
$direccion = $_POST["direccion"];
$t_documento = $_POST["t_documento"];
$n_documento = $_POST["n_documento"];
$correo = $_POST["correo"];
$contrasena = $_POST["contrasena"];

$verificar_correo_cliente = mysqli_query($conexion, "SELECT * FROM cliente WHERE correo='$correo'");
$verificar_correo_empleado = mysqli_query($conexion, "SELECT * FROM empleado WHERE correo='$correo'");

$verificar_documento_cliente = mysqli_query($conexion, "SELECT * FROM cliente WHERE n_documento='$n_documento'");
$verificar_documento_empleado = mysqli_query($conexion, "SELECT * FROM empleado WHERE n_documento='$n_documento'");

if (mysqli_num_rows($verificar_correo_cliente) > 0 || mysqli_num_rows($verificar_correo_empleado) > 0) {
    $mensaje = "correo";
} elseif (mysqli_num_rows($verificar_documento_cliente) > 0 || mysqli_num_rows($verificar_documento_empleado) > 0) {
    $mensaje = "documento";
} else {
    $sql = "INSERT INTO cliente
(nombres,apellidos,telefono,ciudad,barrio,direccion,t_documento,n_documento,correo,contrasena,id_rol)
VALUES
('$nombres','$apellidos','$telefono','$ciudad','$barrio','$direccion','$t_documento','$n_documento','$correo','$contrasena',3)";

    if (mysqli_query($conexion, $sql)) {
        $mensaje = "ok";
    } else {
        $mensaje = "error";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <script>
        let mensaje = "<?php echo $mensaje; ?>";

        if (mensaje == "ok") {
            Swal.fire({
                icon: "success",
                title: "Registro exitoso"
            }).then(() => {
                window.location = "../login.php";
            });
        }

        if (mensaje == "correo") {
            Swal.fire({
                icon: "warning",
                title: "Correo ya registrado"
            }).then(() => {
                window.location = "../registrarse.php";
            });
        }

        if (mensaje == "documento") {
            Swal.fire({
                icon: "warning",
                title: "Número de documento ya registrado"
            }).then(() => {
                window.location = "../registrarse.php";
            });
        }

        if (mensaje == "error") {
            Swal.fire({
                icon: "error",
                title: "Error al registrar"
            }).then(() => {
                window.location = "../registrarse.php";
            });
        }
    </script>

</body>

</html>