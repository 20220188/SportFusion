<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;

// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Comprobante de compra ');

// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_SESSION['idCliente'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../models/data/pedidos_data.php');
    require_once('../../models/data/clientes_data.php');
    
    // Se instancian las entidades correspondientes.
    $pedido = new PedidoData;
    $cliente = new ClienteData;
    
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if (isset($_SESSION['idPedido'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowCliente = $cliente->readProfile()) {
            $pdf->setFillColor(255);
            $pdf->setFont('Arial', 'B', 11);
            $pdf->cell(0, 10, 'Nombre: ' . $pdf->encodeString($rowCliente['nombre_cliente']), 0, 1, 'C', 1);
            $pdf->cell(0, 10, 'Correo: ' . $rowCliente['correo_cliente'], 0, 1, 'C', 1);
            $pdf->cell(0, 10, 'Telefono: ' . $rowCliente['telefono_cliente'], 0, 1, 'C', 1);
            $pdf->cell(0, 10, 'Direccion: ' . $rowCliente['dirección_cliente'], 0, 1, 'C', 1);
            $pdf->setFont('Arial', '', 11);

            $pdf->ln(10);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataPedidos = $pedido->ComprobanteCompra()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(68, 143, 163);
                $pdf->SetTextColor(255);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Arial', 'B', 11);
                
                
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(96, 10, 'Nombre', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Precio (US$)', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Cantidad', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Subtotal (US$)', 1, 1, 'C', 1);

                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Arial', '', 11);
                $pdf->SetTextColor(0);
                $total = 0;

                // Se recorren los registros fila por fila.
                foreach ($dataPedidos as $rowPedido) {
                    $subtotal = $rowPedido['cantidad_pedido'] * $rowPedido['precio_pedido'];
                    $total += $subtotal;
                    
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(96, 10, $pdf->encodeString($rowPedido['nombre_producto']), 1, 0, 'C');
                    $pdf->cell(30, 10, $rowPedido['precio_pedido'], 1, 0, 'C');
                    $pdf->cell(30, 10, $rowPedido['cantidad_pedido'], 1, 0, 'C');
                    $pdf->cell(30, 10, $pdf->encodeString(number_format($subtotal, 2)), 1, 1, 'C');
                }

                $pdf->ln(10);
                // Mueve el cursor a la posición deseada para la celda del total.
                $pdf->SetX(141); // Ajusta este valor según sea necesario
                $pdf->SetTextColor(255);
                $pdf->setFont('Arial', 'B', 11);
                $pdf->cell(30, 10, 'Total (US$)', 1, 0, 'C', 1);
                $pdf->SetTextColor(0);
                $pdf->setFont('Arial', '', 11);
                $pdf->cell(30, 10, $pdf->encodeString(number_format($total, 2)), 1, 0, 'C');
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para el deporte'), 1, 1);
            }
            
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'deporte.pdf');
        } else {
            print('Deporte inexistente');
        }
    } else {
        print('Debe iniciar un pedido');
    }
} else {
    print('Debe iniciar sesión');
}
?>
