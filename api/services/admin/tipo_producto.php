<?php
// Se incluye la clase del modelo.
require_once('../../models/data/tipo_producto_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $tipoProducto = new TipoProductoData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $tipoProducto->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (!$tipoProducto->setNombre($_POST['nombreTipoProducto'])) {
                    $result['error'] = $tipoProducto->getDataError();
                } elseif ($tipoProducto->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Tipo de producto creada correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al crear el tipo de producto';
                }
                break;
            case 'readAll_TipoP':
                if ($result['dataset'] = $tipoProducto->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen tipos de productos registradas';
                }
                break;
            case 'readOne':
                if (!$tipoProducto->setId($_POST['idTipoProducto'])) {
                    $result['error'] = $tipoProducto->getDataError();
                } elseif ($result['dataset'] = $tipoProducto->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Tipo de producto inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$tipoProducto->setId($_POST['idTipoProducto']) or
                    !$tipoProducto->setNombre($_POST['nombreTipoProducto'])
                ) {
                    $result['error'] = $tipoProducto->getDataError();
                } elseif ($tipoProducto->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Tipo de producto modificada correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el tipo de producto';
                }
                break;
            case 'deleteRow':
                if (
                    !$tipoProducto->setId($_POST['idTipoProducto'])
                ) {
                    $result['error'] = $tipoProducto->getDataError();
                } elseif ($tipoProducto->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Tipo de producto eliminado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar el tipo producto';
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
