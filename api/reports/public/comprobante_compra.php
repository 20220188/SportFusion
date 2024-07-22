<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['idPedido'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../models/data/pedidos_data.php');
    require_once('../../models/data/_data.php');
    // Se instancian las entidades correspondientes.
    $pedido = new PedidoData;
    $cliente = new ClienteData;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($pedido->setId_cliente($_GET['idCliente']) && $cliente->setId($_GET['idCliente'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowCliente = $cliente->readOne()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Comprobante de compra ' . $rowCliente['nombre_cliente']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataPedidos = $pedido->ComprobanteCompra()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Arial', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(126, 10, 'Nombre', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Precio (US$)', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'unidades', 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Arial', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataPedidos as $rowPedido) {
                    
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(126, 10, $pdf->encodeString($rowProducto['nombre_producto']), 1, 0);
                    $pdf->cell(30, 10, $rowProducto['precio_pedido'], 1, 0);
                    $pdf->cell(30, 10, $rowProducto['cantidad_pedido'], 1, 1);
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
