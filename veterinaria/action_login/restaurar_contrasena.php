<?php

if($_SERVER["REQUEST_METHOD"]!="POST"){
    header("Location: ../login.php");
    exit();
}

include("../database/conexion.php");

$correo = $_POST["correo"];
$telefono = $_POST["telefono"];
$documento = $_POST["n_documento"];
$nueva = $_POST["n_contrasena"];
$confirmar = $_POST["c_contrasena"];

// Verificar que las contraseñas coincidan
if($nueva != $confirmar){
    $mensaje = "nocoincide";
} else {
    // Primero buscar en tabla cliente
    $stmt_cliente = $conexion->prepare("SELECT * FROM cliente WHERE correo = ? AND telefono = ? AND n_documento = ?");
    $stmt_cliente->bind_param("sss", $correo, $telefono, $documento);
    $stmt_cliente->execute();
    $resultado_cliente = $stmt_cliente->get_result();
    
    if($resultado_cliente->num_rows > 0){
        // Es un cliente, actualizar contraseña
        
        $update = "UPDATE cliente SET contrasena = ? WHERE correo = ? AND telefono = ? AND n_documento = ?";
        $stmt_update = $conexion->prepare($update);
        $stmt_update->bind_param("ssss", $nueva, $correo, $telefono, $documento);
        
        if($stmt_update->execute()){
            $mensaje = "ok";
        } else {
            $mensaje = "error";
        }
        $stmt_update->close();
    } else {
        // Si no es cliente, buscar en tabla empleado
        $stmt_empleado = $conexion->prepare("SELECT * FROM empleado WHERE correo = ? AND telefono = ? AND n_documento = ?");
        $stmt_empleado->bind_param("sss", $correo, $telefono, $documento);
        $stmt_empleado->execute();
        $resultado_empleado = $stmt_empleado->get_result();
        
        if($resultado_empleado->num_rows > 0){
            $update = "UPDATE empleado SET contrasena = ? WHERE correo = ? AND telefono = ? AND n_documento = ?";
            $stmt_update = $conexion->prepare($update);
            $stmt_update->bind_param("ssss", $nueva, $correo, $telefono, $documento);
            
            if($stmt_update->execute()){
                $mensaje = "ok";
            } else {
                $mensaje = "error";
            }
            $stmt_update->close();
        } else {
            // No se encontraron coincidencias con los 3 datos
            $mensaje = "datos_incorrectos";
        }
        $stmt_empleado->close();
    }
    $stmt_cliente->close();
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

    if(mensaje == "ok"){
        Swal.fire({
            icon: "success",
            title: "Contraseña actualizada",
            text: "Tu contraseña ha sido cambiada exitosamente"
        }).then(() => {
            window.location = "../login.php";
        });
    }

    if(mensaje == "datos_incorrectos"){
        Swal.fire({
            icon: "error",
            title: "Datos incorrectos",
            text: "El correo, teléfono o documento no coinciden con nuestros registros"
        }).then(() => {
            window.location = "../login.php";
        });
    }

    if(mensaje == "nocoincide"){
        Swal.fire({
            icon: "warning",
            title: "Las contraseñas no coinciden",
            text: "Verifica que las contraseñas sean iguales"
        }).then(() => {
            window.location = "../login.php";
        });
    }

    if(mensaje == "error"){
        Swal.fire({
            icon: "error",
            title: "Error al actualizar",
            text: "Ocurrió un error al actualizar la contraseña"
        }).then(() => {
            window.location = "../login.php";
        });
    }
</script>

</body>
</html>