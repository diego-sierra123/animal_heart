<?php
include("../database/conexion.php");

$searchTerm = mysqli_real_escape_string($conexion, $_POST['search']);

// Función para convertir hora ingresada por el usuario al formato de base de datos
function convertirHora($horaUsuario) {
    $horaTimestamp = strtotime($horaUsuario);
    return date('H:i:s', $horaTimestamp);
}

$horaBusqueda = convertirHora($searchTerm);

$hora_actual = date('Y-m-d H:i:s');
$horas_a_retrasar = 7;
$nueva_fecha = date('Y-m-d', strtotime($hora_actual . ' - ' . $horas_a_retrasar . ' hours'));

$query = "SELECT c.id_cita, c.fecha, c.hora, CONCAT(cl.nombres,' ',cl.apellidos) AS cliente, 
                m.nombre AS mascota, es.id_estado_cita, es.nombre AS estado_cita, 
                nom.nombre AS servicio, c.descripcion 
        FROM cita c
        LEFT JOIN cliente cl ON c.id_cliente = cl.id_cliente
        LEFT JOIN mascota m ON c.id_mascota = m.id_mascota
        LEFT JOIN estado_cita es ON c.id_estado_cita = es.id_estado_cita
        LEFT JOIN nom_servicio nom ON c.id_nom_servicio = nom.id_nom_servicio
        WHERE c.fecha = '$nueva_fecha' 
        AND c.hora LIKE '%$horaBusqueda%'
        ORDER BY c.hora ASC";

$result = mysqli_query($conexion, $query);

$contador = 1;
if (mysqli_num_rows($result) > 0) {
    while ($fila = mysqli_fetch_assoc($result)) {
        $id_cita = $fila['id_cita'];
        $fecha = $fila['fecha'] ?? '-----';
        $hora = $fila['hora'] ?? '-----';
        $hora_formateada = !empty($hora) ? date("h:i A", strtotime($hora)) : '-----';
        $cliente = $fila['cliente'] ?? '-----';
        $mascota = $fila['mascota'] ?? '-----';
        $estado = $fila['estado_cita'] ?? '-----';
        $servicio = $fila['servicio'] ?? '-----';
        $descripcion = $fila['descripcion'] ?? '-----';
        $idest = $fila['id_estado_cita'];
?>
        <tr style="border: 1px solid black;">
            <td class="align-middle"><b><?php echo $contador; ?></b></td>
            <td class="align-middle"><?php echo htmlspecialchars($fecha); ?></td>
            <td class="align-middle"><?php echo htmlspecialchars($hora_formateada); ?></td>
            <td class="align-middle"><?php echo htmlspecialchars($cliente); ?></td>
            <td class="align-middle"><?php echo htmlspecialchars($mascota); ?></td>
            <td class="align-middle"><?php echo htmlspecialchars($estado); ?></td>
            <td class="align-middle"><?php echo htmlspecialchars($servicio); ?></td>
            <td class="align-middle"><?php echo htmlspecialchars($descripcion); ?></td>
            <td class="align-middle">
                <?php if ($idest == 1) { ?>
                    <a class="btn btn-primary btn-sm py-0 px-1" href="updatedia.php?actualizar=<?php echo $id_cita; ?>" style="font-size: 0.7rem;">
                        <i class="fas fa-sync"></i>
                    </a>
                <?php } else { ?>
                    <span class="text-primary" style="font-size: 0.7rem;">N/A</span>
                <?php } ?>
            </td>
            <td class="align-middle">
                <?php if ($idest == 1) { ?>
                    <button type="button" class="btn btn-danger btn-sm py-0 px-1" style="font-size: 0.7rem;"
                        onclick="confirmarEliminacionBusqueda(<?php echo $id_cita; ?>)">
                        <i class="fas fa-trash"></i>
                    </button>
                <?php } else { ?>
                    <span class="text-danger" style="font-size: 0.7rem;">N/A</span>
                <?php } ?>
            </td>
        </tr>
<?php
        $contador++;
    }
} else {
    echo '<tr><td colspan="10" class="text-center align-middle">No se encontraron resultados para la hora ingresada.</td></tr>';
}
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmarEliminacionBusqueda(id_cita) {
        Swal.fire({
            title: '¿Está seguro?',
            text: "¡Esta acción cancelará la cita!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#3085d6',
            confirmButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sí, cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `selectdia.php?eliminar=${id_cita}`;
            }
        });
    }
</script>