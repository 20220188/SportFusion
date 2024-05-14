<?php
// Se incluye la clase del modelo.
require_once('../../models/data/pedidos_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $pedido = new PedidoData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $pedido->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$pedido->setNombre($_POST['nombreProducto']) or
                    !$pedido->setDescripcion($_POST['descripcionProducto']) or
                    !$pedido->setCategoria($_POST['categoriaProducto']) or
                    !$pedido->setTipoProducto($_POST['tipoProducto']) or
                    !$pedido->setDeporte($_POST['deporteProducto']) or
                    !$pedido->setImagen($_FILES['imagenProducto'])
                ) {
                    $result['error'] = $pedido->getDataError();
                } elseif ($pedido->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto creado correctamente';
                    // Se asigna el estado del archivo después de insertar.
                    $result['fileStatus'] = Validator::saveFile($_FILES['imagenProducto'], $pedido::RUTA_IMAGEN);
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $pedido->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen productos registrados';
                }
                break;
            case 'readOne':
                if (!$pedido->setId($_POST['idPedido'])) {
                    $result['error'] = $pedido->getDataError();
                } elseif ($result['dataset'] = $pedido->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Pedido inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$pedido->setId($_POST['idPedido']) or
                    !$pedido->setDireccion($_POST['direccionPedido']) or
                    !$pedido->setDireccion($_POST['direccionPedido'])
                ) {
                    $result['error'] = $pedido->getDataError();
                } elseif ($pedido->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto modificado correctamente';
                    // Se asigna el estado del archivo después de actualizar.
                    $result['fileStatus'] = Validator::changeFile($_FILES['imagenProducto'], $pedido::RUTA_IMAGEN, $pedido->getFilename());
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el producto';
                }
                break;
            case 'deleteRow':
                if (
                    !$pedido->setId($_POST['idProducto']) or
                    !$pedido->setFilename()
                ) {
                    $result['error'] = $pedido->getDataError();
                } elseif ($pedido->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto eliminado correctamente';
                    // Se asigna el estado del archivo después de eliminar.
                    $result['fileStatus'] = Validator::deleteFile($pedido::RUTA_IMAGEN, $pedido->getFilename());
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar el producto';
                }
                break;
            //Casos para DETALLE_PRODUCTO
            case 'createRow_detalleProducto':
                $_POST = Validator::validateForm($_POST);
            if (
                !$pedido->setPrecio($_POST['precioDetalle']) or
                !$pedido->setExistencias($_POST['existenciasDetalle']) or
                !$pedido->setTalla($_POST['tallaDetalle']) or
                !$pedido->setGenero($_POST['generoDetalle']) or
                !$pedido->setId($_POST['idProductoDetalle'])
            ) {
                $result['error'] = $pedido->getDataError();
            } elseif ($pedido->createRow_detalleProducto()) {
                $result['status'] = 1;
                $result['message'] = 'Detalle creado correctamente';
            } else {
                $result['exception'] = Database::getException();
            }
                break;
            case 'readAll_detalle':
                if ($result['dataset'] = $pedido->readAll_detalle()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen detalles registrados';
                    
                }
                break;
            case 'readOne_detalleProducto':
                if (!$pedido->setDetalleproducto($_POST['idDetalle'])) {
                    $result['error'] = $pedido->getDataError();
                } elseif ($result['dataset'] = $pedido->readOne_detalle()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Detalle inexistente';
                }
                break;
            case 'updateRow_detalleProducto':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$pedido->setDetalleproducto($_POST['idDetalle']) or
                    !$pedido->setPrecio($_POST['precioDetalle']) or
                    !$pedido->setExistencias($_POST['existenciasDetalle']) or
                    !$pedido->setTalla($_POST['tallaDetalle']) or
                    !$pedido->setGenero($_POST['generoDetalle'])
                ) {
                    $result['error'] = $pedido->getDataError();
                } elseif ($pedido->updateRow_detalle()) {
                    $result['status'] = 1;
                    $result['message'] = 'Detalle modificado correctamente';
                } else {
                    $result['exception'] = 'Ocurrió un problema al modificar el detalle';
                }
                break;
            case 'deleteRow_detalleProducto':
                if (!$pedido->setDetalleproducto($_POST['idDetalle'])) {
                    $result['error'] = $pedido->getDataError();
                } elseif ($pedido->deleteRow_detalle()) {
                    $result['status'] = 1;
                    $result['message'] = 'Detalle eliminado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar el detalle';
                }
                break;
            case 'cantidadProductosCategoria':
                if ($result['dataset'] = $pedido->cantidadProductosCategoria()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'No hay datos disponibles';
                }
                break;

            case 'porcentajeProductosCategoria':
                if ($result['dataset'] = $pedido->porcentajeProductosCategoria()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'No hay datos disponibles';
                }
                break;
            default:
                $result['error'] = 'Acción no disponible dentro de la sesión';
        }
        // Se obtiene la excepción del servidor de base de datos por si ocurrió un problema.
        $result['exception'] = Database::getException();
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('Content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}
