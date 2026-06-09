<?php
session_start();
include("../database/conexion.php");

if (!isset($_SESSION["id"])) {
    exit();
}

$id_mascota = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$search = isset($_GET['search']) ? mysqli_real_escape_string($conexion, $_GET['search']) : '';
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$registrosPorPagina = 10;

// Calcular el offset para la paginación
$desde = ($pagina - 1) * $registrosPorPagina;

// Obtener total de registros para la búsqueda
$queryTotal = "SELECT COUNT(*) as total 
               FROM historial_clinico h 
               WHERE h.id_mascota = $id_mascota 
               AND h.fecha_visita LIKE '%$search%'";
$resultadoTotal = mysqli_query($conexion, $queryTotal);
$filaTotal = mysqli_fetch_assoc($resultadoTotal);
$totalRegistros = $filaTotal['total'];

// Consulta principal con paginación
$query = "SELECT h.id_historial_clinico, c.nombres AS cliente, m.nombre AS mascota, 
                 h.fecha_visita, h.pulso, h.cardio, h.fecha_proxima_cita,
                 h.diagnostico, h.instrucciones, h.pulso, h.cardio, 
                 v.nombre AS vacuna, h.fecha_vacuna, 
                 d.nombre AS desparasitante, h.fecha_desparasitante, e.nombre AS empleado
          FROM historial_clinico h 
          LEFT JOIN cliente c ON h.id_cliente = c.id_cliente
          LEFT JOIN mascota m ON h.id_mascota = m.id_mascota
          LEFT JOIN vacuna v ON h.id_vacuna = v.id_vacuna
          LEFT JOIN desparasitante d ON h.id_desparasitante = d.id_desparasitante
          LEFT JOIN empleado e ON h.id_empleado = e.id_empleado
          WHERE h.id_mascota = $id_mascota
          AND h.fecha_visita LIKE '%$search%'
          ORDER BY h.fecha_visita DESC
          LIMIT $desde, $registrosPorPagina";

$resultado = mysqli_query($conexion, $query);

$html = '';
$contador_inicio = $desde + 1;

if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_assoc($resultado)) {

        $html .= '<tr>';
        $html .= '<td class="align-middle"><b>'.$contador_inicio.'</b></td>';
        $html .= '<td class="align-middle">'.(!empty($fila['mascota']) ? $fila['mascota'] : '-----').'</td>';
        $html .= '<td class="align-middle">'.(!empty($fila['cliente']) ? $fila['cliente'] : '-----').'</td>';
        $html .= '<td class="align-middle">'.(!empty($fila['fecha_visita']) ? $fila['fecha_visita'] : '-----').'</td>';
        $html .= '<td class="align-middle">'.(!empty($fila['pulso']) ? $fila['pulso'].' ppm' : '-----').'</td>';
        $html .= '<td class="align-middle">'.(!empty($fila['cardio']) ? $fila['cardio'].' lpm' : '-----').'</td>';
        $html .= '<td class="align-middle">'.(!empty($fila['fecha_proxima_cita']) ? $fila['fecha_proxima_cita'] : '-----').'</td>';
        $html .= '<td class="align-middle">
                    <a href="historial.php?animal='.$id_mascota.'&historia='.$fila['id_historial_clinico'].'" 
                    class="btn btn-info btn-sm py-0 px-1" target="_blank" style="font-size: 0.7rem;">
                    <i class="fas fa-file-pdf"></i></a>
                  </td>';
        $html .= '</tr>';

        $contador_inicio++;
    }

    // Agregar información de paginación si hay más de 10 resultados
    $totalPaginas = ceil($totalRegistros / $registrosPorPagina);
    if ($totalPaginas > 1) {
        $html .= '<tr><td colspan="8" class="text-center">
                    <div class="pagination-info mt-2">
                        <small>Mostrando ' . ($desde + 1) . ' - ' . min($desde + $registrosPorPagina, $totalRegistros) . ' de ' . $totalRegistros . ' resultados</small>
                  </div></td></tr>';
    }

} else {
    $html .= '<tr>
                <td colspan="8" class="text-center">
                    No se encontraron resultados para la búsqueda: "' . htmlspecialchars($search) . '"
                </td>
              </tr>';
}

echo $html;
?>