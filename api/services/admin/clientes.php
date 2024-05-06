<?php
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../models/data/clientes_data.php');

$clientes = new clientes_data;

if ($clientes_data = $clientes->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(200);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(50, 10, 'Nombre Cliente', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'DUI', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Telefono', 1, 0, 'C', 1);
    $pdf->cell(60, 10, 'Correo', 1, 0, 'C', 1);
    $pdf->cell(60, 10, 'Direccion', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Alias', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar los datos de el cliente.
    $pdf->setFillColor(240);
    // Se establece la fuente para los datos de el cliente.
    $pdf->setFont('Arial', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($clientes_data as $rowcliente) {
        $pdf->cell(50, 10, $pdf->encodeString($rowcliente['nombre_cliente']), 1, 0);
        $pdf->cell(30, 10, $rowcliente['DUI'], 1, 0);
        $pdf->cell(30, 10, $rowcliente['Telefono'], 1, 0);
        $pdf->cell(60, 10, $rowcliente['Correo'], 1, 0);
        $pdf->cell(60, 10, $pdf->encodeString($rowcliente['Direccion']), 1, 0);
        $pdf->cell(30, 10, $rowcliente['Alias'], 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay clientes'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Cliente incorrecto o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay clientes para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'clientes.pdf');