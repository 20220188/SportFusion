<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['idDeporte'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../models/data/deporte_data.php');
    require_once('../../models/data/producto_data.php');
    // Se instancian las entidades correspondientes.
    $deporte = new DeporteData;
    $producto = new ProductoData;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($deporte->setId($_GET['idDeporte']) && $producto->setDeporte($_GET['idDeporte'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowDeporte = $deporte->readOne()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Productos del deporte ' . $rowDeporte['nombre_deporte']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $producto->productosDeporte()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Arial', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(126, 10, 'Nombre', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Precio (US$)', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Existencias', 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Arial', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataProductos as $rowProducto) {
                    
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(126, 10, $pdf->encodeString($rowProducto['nombre_producto']), 1, 0);
                    $pdf->cell(30, 10, $rowProducto['precio'], 1, 0);
                    $pdf->cell(30, 10, $rowProducto['cantidad_disponible'], 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para el deporte'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'deporte.pdf');
        } else {
            print('Deporte inexistente');
        }
    } else {
        print('Deporte incorrecta');
    }
} else {
    print('Debe seleccionar una Deporte');
}
