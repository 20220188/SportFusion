<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../models/data/clientes_data.php');
require_once('../../models/data/pedidos_data.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Pedidos por cliente');
// Se instancia el módelo Categoría para obtener los datos.
$cliente = new ClienteData;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataClientes = $cliente->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(200);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(15, 10, 'Pedido', 1, 0, 'C', 1);
    $pdf->cell(80, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Precio (US$)', 1, 0, 'C', 1);
    $pdf->cell(21, 10, 'Cantidad', 1, 0, 'C', 1);
    $pdf->cell(40, 10, 'fecha de registro', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(240);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Arial', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataClientes as $rowCliente) {
        // Se imprime una celda con el nombre de la categoría.
        $pdf->cell(0, 10, $pdf->encodeString('Cliente: ' . $rowCliente['nombre_cliente']), 1, 1, 'C', 1);
        // Se instancia el módelo Producto para procesar los datos.
        $pedido = new PedidoData;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($pedido->setId_cliente($rowCliente['id_cliente'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataPedidos = $pedido->PedidosClientes()) {
                // Se recorren los registros fila por fila.
                foreach ($dataPedidos as $rowPedido) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(15, 10, $rowPedido['id_pedido'], 1, 0);
                    $pdf->cell(80, 10, $pdf->encodeString($rowPedido['nombre_producto']), 1, 0);
                    $pdf->cell(30, 10, $rowPedido['precio_pedido'], 1, 0);
                    $pdf->cell(21, 10, $rowPedido['cantidad_pedido'], 1, 0);
                    $pdf->cell(40, 10, $rowPedido['fecha_registro'], 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay pedidos por clientes'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Cliente incorrecta o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay pedidos para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'pedidos.pdf');
