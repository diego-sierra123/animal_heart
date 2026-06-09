<?php
session_start();
include("../database/conexion.php");

if (!isset($_SESSION["id"])) {
    exit();
}

if ($_SESSION["id_rol"] != 1 && $_SESSION["id_rol"] != 2) {
    exit();
}

$id_mascota = isset($_GET['id']) ? intval($_GET['id']) : 0;
$searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conexion, $_GET['search']) : '';


// Construir la consulta con búsqueda mejorada - AGREGADO nom_servicio
$query = "SELECT h.id_historial_clinico, c.id_cliente, c.nombres AS cliente, m.id_mascota, m.nombre AS mascota, 
          h.fecha_visita, h.diagnostico, t.id_tratamiento, t.medicamentos AS tratamiento, h.instrucciones, 
          h.fecha_proxima_cita, h.pulso, h.cardio, v.id_vacuna, v.nombre AS vacuna, h.fecha_vacuna, 
          d.id_desparasitante, d.nombre AS desparasitante, h.fecha_desparasitante, e.id_empleado, e.nombre AS empleado,
          ns.nombre AS nombre_servicio
          FROM historial_clinico h 
          LEFT JOIN cliente c ON h.id_cliente = c.id_cliente
          LEFT JOIN mascota m ON h.id_mascota = m.id_mascota
          LEFT JOIN nom_servicio ns ON h.id_nom_servicio = ns.id_nom_servicio
          LEFT JOIN tratamiento t ON h.id_tratamiento = t.id_tratamiento
          LEFT JOIN vacuna v ON h.id_vacuna = v.id_vacuna
          LEFT JOIN desparasitante d ON h.id_desparasitante = d.id_desparasitante
          LEFT JOIN empleado e ON h.id_empleado = e.id_empleado
          WHERE h.id_mascota = $id_mascota 
          AND h.fecha_visita LIKE '%$searchTerm%'
          ORDER BY h.fecha_visita DESC";

$result = mysqli_query($conexion, $query);

if (!$result) {
    echo '<tr><td colspan="11" class="text-center text-danger">Error en la consulta: ' . mysqli_error($conexion) . '</td></tr>';
    exit();
}

$contador = 1;
$html = '';

if (mysqli_num_rows($result) > 0) {
    while ($fila = mysqli_fetch_assoc($result)) {
        $idpac = $fila['id_historial_clinico'];
        $mas = $fila['mascota'] ?? '-----';
        $cli = $fila['cliente'] ?? '-----';
        $servicio = $fila['nombre_servicio'] ?? '-----';  // NUEVO: variable para el servicio
        $fecvi = $fila['fecha_visita'] ?? '-----';
        $pul = !empty($fila['pulso']) ? $fila['pulso'] . ' ppm' : '-----';
        $car = !empty($fila['cardio']) ? $fila['cardio'] . ' lpm' : '-----';
        $fecpr = $fila['fecha_proxima_cita'] ?? '-----';
        $id_cliente = $fila['id_cliente'];

        $html .= '<tr style="border: 1px solid black;">';
        $html .= '<td class="align-middle"><b>' . $contador . '</b></td>';
        $html .= '<td class="align-middle">' . htmlspecialchars($mas) . '</td>';
        $html .= '<td class="align-middle">' . htmlspecialchars($cli) . '</td>';
        $html .= '<td class="align-middle">' . htmlspecialchars($servicio) . '</td>';  // NUEVO: columna servicio
        $html .= '<td class="align-middle">' . htmlspecialchars($fecvi) . '</td>';
        $html .= '<td class="align-middle">' . htmlspecialchars($pul) . '</td>';
        $html .= '<td class="align-middle">' . htmlspecialchars($car) . '</td>';
        $html .= '<td class="align-middle">' . htmlspecialchars($fecpr) . '</td>';
        $html .= '<td class="align-middle">';
        $html .= '<a class="btn btn-primary btn-sm py-0 px-1" href="update.php?id_mascota=' . $id_mascota . '&id_cliente=' . $id_cliente . '&id_historia=' . $idpac . '" style="font-size: 0.7rem;"><i class="fas fa-sync"></i></a>';
        $html .= '</td>';
        $html .= '<td class="align-middle">';
        $html .= '<button type="button" class="btn btn-danger btn-sm py-0 px-1" style="font-size: 0.7rem;" onclick="confirmarEliminacion(' . $id_mascota . ', ' . $id_cliente . ', ' . $idpac . ')"><i class="fas fa-trash"></i></button>';
        $html .= '</td>';
        $html .= '<td class="align-middle">';
        $html .= '<a href="../historial_clinico/historial.php?animal=' . $id_mascota . '&historia=' . $idpac . '" class="btn btn-info btn-sm py-0 px-1" style="font-size: 0.7rem;" target="_blank"><i class="fas fa-file-pdf"></i></a>';
        $html .= '</td>';
        $html .= '</tr>';
        
        $contador++;
    }
} else {
    $html .= '<tr><td colspan="11" class="text-center align-middle">No se encontraron resultados en la búsqueda.</td></tr>';
}

echo $html;
?>