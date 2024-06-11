<?php
// Se incluye la clase del modelo.
require_once('../../models/data/producto_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se instancia la clase correspondiente.
    $categoria = new CategoriaData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null);
    // Se compara la acción a realizar según la petición del controlador.
    switch ($_GET['action']) {
        case 'createRowValoracon':
            $_POST = Validator::validateForm($_POST);
            if (
                !$producto->setPrecio($_POST['precioDetalle']) or
                !$producto->setExistencias($_POST['existenciasDetalle']) or
                !$producto->setTalla($_POST['tallaDetalle']) or
                !$producto->setId($_POST['idProductoDetalle'])
            ) {
                $result['error'] = $producto->getDataError();
            } elseif ($producto->createRowDetalleProducto()) {
                $result['status'] = 1;
                $result['message'] = 'Detalle creado correctamente';
            } else {
                $result['exception'] = Database::getException();
            }
            break;
        default:
            $result['error'] = 'Acción no disponible';
    }
    // Se obtiene la excepción del servidor de base de datos por si ocurrió un problema.
    $result['exception'] = Database::getException();
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('Content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
