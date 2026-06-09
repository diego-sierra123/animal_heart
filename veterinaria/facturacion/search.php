<?php
include("../database/conexion.php");

if (isset($_POST['search'])) {
    $searchTerm = mysqli_real_escape_string($conexion, $_POST['search']);
    
    // Consulta mejorada con INNER JOIN y búsqueda más completa
    $query = "SELECT f.id_factura, f.fecha, f.total_factura, 
                     c.id_cliente, CONCAT(c.nombres, ' ', c.apellidos) AS cliente,
                     e.id_empleado, e.nombre AS empleado, 
                     es.id_estado_factura, es.nombre AS estado 
              FROM factura f
              INNER JOIN cliente c ON f.id_cliente = c.id_cliente 
              INNER JOIN empleado e ON f.id_empleado = e.id_empleado 
              INNER JOIN estado_factura es ON f.id_estado_factura = es.id_estado_factura 
              WHERE CONCAT(c.nombres, ' ', c.apellidos) LIKE '%$searchTerm%' 
                 OR e.nombre LIKE '%$searchTerm%' 
                 OR f.fecha LIKE '%$searchTerm%'
                 OR f.id_factura LIKE '%$searchTerm%'
              ORDER BY f.id_factura DESC";

    $result = mysqli_query($conexion, $query);
    
    if (mysqli_num_rows($result) > 0) {
        while ($fila = mysqli_fetch_assoc($result)) {
            // Mantener el contador para mantener consistencia con la tabla principal
            static $cont = 0;
            $cont++;
            
            $id_factura = $fila['id_factura'];
            $fecha = date('d/m/Y', strtotime($fila['fecha']));
            $total = number_format($fila['total_factura'], 0, ',', '.');
            $cliente = htmlspecialchars($fila['cliente']);
            $empleado = htmlspecialchars($fila['empleado']);
            $estado = $fila['estado'];
            $id_cliente = $fila['id_cliente'];
            $id_estado = $fila['id_estado_factura'];
            
            // Determinar clase CSS según estado
            $estadoClase = ($id_estado == 1) ? 'badge bg-success' : 'badge bg-danger';
            ?>
            <tr style="border: 1px solid black;">
                <td><b><?php echo $cont; ?></b></td>
                <td><?php echo $fecha; ?></td>
                <td>$<?php echo $total; ?></td>
                <td><?php echo $cliente; ?></td>
                <td><?php echo $empleado; ?></td>
                <td>
                    <span class="<?php echo $estadoClase; ?>"><?php echo $estado; ?></span>
                </td>
                <td>
                    <?php if ($id_estado == 1): ?>
                        <button class="btn btn-warning btn-sm m-3" onclick="confirmarAnulacion(<?php echo $id_factura; ?>)" title="Anular Factura">
                            <i class="fas fa-ban"></i> Anular
                        </button>
                    <?php endif; ?>
                    
                    <?php if ($id_estado == 2): ?>
                        <span class="text-muted" style="margin-right: 30px; margin-left:20px; color:#dc3545 !important;" title="Factura Anulada">
                            <i class="fas fa-times-circle"></i> Anulada
                        </span>
                    <?php endif; ?>

                    <a class="btn btn-danger btn-sm" href="pdf.php?facturar=<?php echo $id_factura; ?>&cliente=<?php echo $id_cliente; ?>&anular=<?php echo $id_estado; ?>" target="_blank" title="Ver PDF">
                        <i class="fas fa-file-pdf"></i> PDF
                    </a>
                    
                </td>
            </tr>
            <?php
        }
    } else {
        echo '<tr><td colspan="8" class="text-center py-4">No se encontraron resultados en la búsqueda.</td></tr>';
    }
} else {
    echo '<tr><td colspan="8" class="text-center py-4">No se proporcionó término de búsqueda.</td></tr>';
}
?>