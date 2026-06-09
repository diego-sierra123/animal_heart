<?php

if($_SERVER["REQUEST_METHOD"]!="POST"){
header("Location: ../login.php");
exit();
}

session_start();
require_once("../database/conexion.php");

$correo = $_POST["iniciar_correo"];
$contrasena = $_POST["contrasena"];

$mensaje="";

/*  Parte del cliente */

$stmt = $conexion->prepare("SELECT * FROM cliente WHERE correo=?");
$stmt->bind_param("s",$correo);
$stmt->execute();
$resultado = $stmt->get_result();

if($resultado->num_rows > 0){

$usuario = $resultado->fetch_assoc();

if($contrasena == $usuario["contrasena"]){

$_SESSION["id"] = $usuario["id_cliente"];
$_SESSION["nombre"] = $usuario["nombres"];
$_SESSION["apellido"] = $usuario["apellidos"];
$_SESSION["id_rol"] = $usuario["id_rol"];

$mensaje="cliente";

}else{

$mensaje="pass";

}

}else{

/*  Parte del empleado */

$stmt2 = $conexion->prepare("SELECT * FROM empleado WHERE correo=?");
$stmt2->bind_param("s",$correo);
$stmt2->execute();
$resultado2 = $stmt2->get_result();

if($resultado2->num_rows > 0){

$usuario = $resultado2->fetch_assoc();

if($contrasena == $usuario["contrasena"]){

$_SESSION["id"] = $usuario["id_empleado"];
$_SESSION["nombre"] = $usuario["nombre"];
$_SESSION["id_rol"] = $usuario["id_rol"];

if($usuario["id_rol"] == 1){

$mensaje="admin";

}

if($usuario["id_rol"] == 2){

$mensaje="empleado";

}

}else{

$mensaje="pass";

}

}else{

$mensaje="correo";

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

let mensaje="<?php echo $mensaje;?>";

if(mensaje=="cliente"){

Swal.fire({
icon:"success",
title:"Bienvenido cliente"
}).then(()=>{
window.location="../paginas_cliente/bienvenido.php";
});

}

if(mensaje=="admin"){

Swal.fire({
icon:"success",
title:"Bienvenido administrador"
}).then(()=>{
window.location="../paginas_personal/bienvenido.php";
});

}

if(mensaje=="empleado"){

Swal.fire({
icon:"success",
title:"Bienvenido empleado"
}).then(()=>{
window.location="../paginas_personal/bienvenido.php";
});

}

if(mensaje=="pass"){

Swal.fire({
icon:"error",
title:"Contraseña incorrecta"
}).then(()=>{
window.location="../login.php";
});

}

if(mensaje=="correo"){

Swal.fire({
icon:"warning",
title:"Correo no registrado"
}).then(()=>{
window.location="../login.php";
});

}

</script>

</body>
</html>