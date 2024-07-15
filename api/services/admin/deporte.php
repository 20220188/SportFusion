<?php
// Se incluye la clase del modelo.
require_once('../../models/data/deporte_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $deporte = new DeporteData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $deporte->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$deporte->setNombre($_POST['nombreDeporte']) or
                    !$deporte->setEstado(isset($_POST['estadoDeporte']) ? 1 : 0) or
                    !$deporte->setImagen($_FILES['imagenDeporte'])
                ) {
                    $result['error'] = $deporte->getDataError();
                } elseif ($deporte->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Deporte creado correctamente';
                    // Se asigna el estado del archivo después de insertar.
                    $result['fileStatus'] = Validator::saveFile($_FILES['imagenDeporte'], $deporte::RUTA_IMAGEN);
                } else {
                    $result['error'] = 'Ocurrió un problema al crear el deporte';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $deporte->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen deportes registrados';
                }
                break;
            case 'readOne':
                if (!$deporte->setId($_POST['idDeporte'])) {
                    $result['error'] = $deporte->getDataError();
                } elseif ($result['dataset'] = $deporte->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Deporte inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$deporte->setId($_POST['idDeporte']) or
                    !$deporte->setFilename() or
                    !$deporte->setNombre($_POST['nombreDeporte']) or
                    !$deporte->setEstado(isset($_POST['estadoDeporte']) ? 1 : 0) or
                    !$deporte->setImagen($_FILES['imagenDeporte'], $deporte->getFilename())
                ) {
                    $result['error'] = $deporte->getDataError();
                } elseif ($deporte->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Deporte modificado correctamente';
                    // Se asigna el estado del archivo después de actualizar.
                    $result['fileStatus'] = Validator::changeFile($_FILES['imagenDeporte'], $deporte::RUTA_IMAGEN, $deporte->getFilename());
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el deporte';
                }
                break;
            case 'deleteRow':
                if (
                    !$deporte->setId($_POST['idDeporte']) or
                    !$deporte->setFilename()
                ) {
                    $result['error'] = $deporte->getDataError();
                } elseif ($deporte->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Deporte eliminado correctamente';
                    // Se asigna el estado del archivo después de eliminar.
                    $result['fileStatus'] = Validator::deleteFile($deporte::RUTA_IMAGEN, $deporte->getFilename());
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar el deporte';
                }
                break;
                case 'readTopProductosxDeporte':
                    if (!$deporte->setId($_POST['idDeporte'])) {
                        $result['error'] = $deporte->getDataError();
                    } elseif ($result['dataset'] = $deporte->readTopProductosxDeporte()) {
                        $result['status'] = 1;
                    } else {
                        $result['error'] = 'No existen productos por el momento';
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
