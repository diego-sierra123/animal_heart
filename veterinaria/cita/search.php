<?php
session_start();
include("../database/conexion.php");

if (!isset($_SESSION["id"])) {
    exit();
}

if ($_SESSION["id_rol"] != 1 && $_SESSION["id_rol"] != 2) {
    exit();
}

$searchTerm = isset($_GET['search']) 
    ? mysqli_real_escape_string($conexion, $_GET['search']) 
    : '';

if ($searchTerm === '') {
    echo '<td><td colspan="10" class="text-center">Escribe algo para buscar</td></tr>';
    exit();
}

$query = "SELECT c.id_cita, c.fecha, c.hora, 
                CONCAT(cl.nombres,' ',cl.apellidos) AS cliente, 
                m.nombre AS mascota, 
                es.id_estado_cita, es.nombre AS estado_cita, 
                nom.nombre AS servicio, 
                c.descripcion 
        FROM cita c
        LEFT JOIN cliente cl ON c.id_cliente = cl.id_cliente
        LEFT JOIN mascota m ON c.id_mascota = m.id_mascota
        LEFT JOIN estado_cita es ON c.id_estado_cita = es.id_estado_cita
        LEFT JOIN nom_servicio nom ON c.id_nom_servicio = nom.id_nom_servicio
        WHERE cl.nombres LIKE '%$searchTerm%' 
           OR cl.apellidos LIKE '%$searchTerm%' 
           OR cl.n_documento LIKE '%$searchTerm%' 
           OR c.fecha LIKE '%$searchTerm%'
        ORDER BY c.id_cita DESC";

$result = mysqli_query($conexion, $query);

if (!$result) {
    echo '<tr><td colspan="10" class="text-danger text-center">Error en la consulta</td></tr>';
    exit();
}

$contador = 1;
$html = '';

if (mysqli_num_rows($result) > 0) {
    while ($fila = mysqli_fetch_assoc($result)) {

        $id_cita = $fila['id_cita'];
        $fecha = $fila['fecha'] ?? '-----';
        $hora = $fila['hora'] ?? '';
        $hora_formateada = !empty($hora) ? date("h:i A", strtotime($hora)) : '-----';
        $cliente = $fila['cliente'] ?? '-----';
        $mascota = $fila['mascota'] ?? '-----';
        $estado = $fila['estado_cita'] ?? '-----';
        $servicio = $fila['servicio'] ?? '-----';
        $descripcion = $fila['descripcion'] ?? '-----';
        $idest = $fila['id_estado_cita'];

        $html .= '<tr style="border: 1px solid black;">';
        $html .= '<td class="align-middle"><b>' . $contador . '</b></td>';
        $html .= '<td class="align-middle">' . htmlspecialchars($fecha) . '</td>';
        $html .= '<td class="align-middle">' . htmlspecialchars($hora_formateada) . '</td>';
        $html .= '<td class="align-middle">' . htmlspecialchars($cliente) . '</td>';
        $html .= '<td class="align-middle">' . htmlspecialchars($mascota) . '</td>';
        $html .= '<td class="align-middle">' . htmlspecialchars($estado) . '</td>';
        $html .= '<td class="align-middle">' . htmlspecialchars($servicio) . '</td>';
        $html .= '<td class="align-middle">' . htmlspecialchars($descripcion) . '</td>';
        
        $html .= '<td class="align-middle">';
        if ($idest == 1) {
            $html .= '<a class="btn btn-primary btn-sm py-0 px-1" href="update.php?actualizar=' . $id_cita . '">
                        <i class="fas fa-sync"></i>
                      </a>';
        } else {
            $html .= '<span class="text-primary" style="font-size: 0.7rem;">N/A</span>';
        }
        $html .= '</td>';

        $html .= '<td class="align-middle">';
        if ($idest == 1) {
            $html .= '<button type="button" class="btn btn-danger btn-sm py-0 px-1" style="font-size: 0.7rem;"
                        onclick="confirmarEliminacionBusqueda(' . $id_cita . ')">
                        <i class="fas fa-trash"></i>
                      </button>';
        } else {
            $html .= '<span class="text-danger" style="font-size: 0.7rem;">N/A</span>';
        }
        $html .= '</td>';

        $html .= '</tr>';

        $contador++;
    }
} else {
    $html .= '<tr><td colspan="10" class="text-center align-middle">No se encontraron resultados.</td></tr>';
}

echo $html;
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
                window.location.href = 'select.php?eliminar=' + id_cita;
            }
        });
    }
</script>