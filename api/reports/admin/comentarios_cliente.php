<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../models/data/clientes_data.php');
require_once('../../models/data/producto_data.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Comentarios por cliente');
// Se instancia el módelo Categoría para obtener los datos.
$cliente = new ClienteData;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataClientes = $cliente->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(200);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(90, 10, 'Comentario', 1, 0, 'C', 1);
    $pdf->cell(50, 10, $pdf->encodeString('Valoración'), 1, 0, 'C', 1);
    $pdf->cell(46, 10, 'Estado', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(240);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Arial', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataClientes as $rowCliente) {
        // Se imprime una celda con el nombre de la categoría.
        $pdf->cell(0, 10, $pdf->encodeString('Cliente: ' . $rowCliente['nombre_cliente']), 1, 1, 'C', 1);
        // Se instancia el módelo Producto para procesar los datos.
        $cliente = new ClienteData;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($cliente->setId($rowCliente['id_cliente'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataClientes = $cliente->ComentariosCliente()) {
                // Se recorren los registros fila por fila.
                foreach ($dataClientes as $rowCliente) {
                    // Se imprimen las celdas con los datos de los productos.
                    ($rowCliente['estado_valoracion']) ? $estado = 'Activo' : $estado = 'Inactivo';
                    $pdf->cell(90, 10, $pdf->encodeString($rowCliente['comentario']), 1, 0);
                    $pdf->cell(50, 10, $rowCliente['valoracion'], 1, 0);
                    $pdf->cell(46, 10, $estado, 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay comentarios/valoraciones por clientes'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Cliente incorrecta o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay comentarios/valoraciones para mostrar'), 1, 1);
}

// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'pedidos.pdf');
