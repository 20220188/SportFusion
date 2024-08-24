<?php
// Se incluye la clase del modelo.
require_once('../../models/data/pedidos_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $valoracion = new PedidoData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'error' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como cliente para realizar las acciones correspondientes.
    if (isset($_SESSION['idCliente'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un cliente ha iniciado sesión.
        switch ($_GET['action']) {
                // Acción para agregar una valoracion.
            case 'createRowValoracion':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$valoracion->setComentario($_POST['Comentario']) or
                    !$valoracion->setValoracion($_POST['Valoracion']) or
                    !$valoracion->setDetallePedido($_POST['idDetalle']) or
                    !$valoracion->getValoracion()
                ) {
                    $result['error'] = $valoracion->getDataError();
                } elseif ($valoracion->createRowValoracion()) {
                    $result['status'] = 1;
                    $result['message'] = 'Valoración creada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                case 'createRowValoracionMovil':
                    $_POST = Validator::validateForm($_POST);
                    if (
                        !$valoracion->setComentario($_POST['Comentario']) or
                        !$valoracion->setValoracion($_POST['Valoracion']) or
                        !$valoracion->setDetallePedido($_POST['idDetalle']) or
                        !$valoracion->getValoracion()
                    ) {
                        $result['error'] = $valoracion->getDataError();
                    } elseif ($valoracion->createRowValoracion()) {
                        $result['status'] = 1;
                        $result['message'] = 'Valoración creada correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                    break;
                // Acción para obtener las visualizar los comentarios.
            case 'readAllValoracionPublica':
                if (!$valoracion->setDetallePedido($_POST['idDetalle'])) {
                    $result['error'] = $valoracion->getDataError();
                } elseif ($result['dataset'] = $valoracion->readAllValoracionPublica()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen resultados para mostrar';
                }
                break;
            case 'updateRowValoracion':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$valoracion->setid_valoracion($_POST['idValoracion']) or
                    !$valoracion->setComentario($_POST['Comentario']) or
                    !$valoracion->setValoracion($_POST['Valoracion'])
                ) {
                    $result['error'] = $valoracion->getDataError();
                } elseif ($valoracion->updateRowValoracion()) {
                    $result['status'] = 1;
                    $result['message'] = 'Comentario/Valoracion modificado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el comentario/valoracion';
                }
                break;
            case 'deleteRowValoracion':
                if (
                    !$valoracion->setid_valoracion($_POST['idValoracion']) 
                ) {
                    $result['error'] = $valoracion->getDataError();
                } elseif ($valoracion->deleteValoracion()) {
                    $result['status'] = 1;
                    $result['message'] = 'Comentario/valoracion eliminado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar el comentario/valoracion';
                }
                break;
                case 'readOneValoracion':
                    if (!$valoracion->setid_valoracion($_POST['idValoracion'])) {
                        $result['error'] = $valoracion->getDataError();
                    } elseif ($result['dataset'] = $valoracion->readOneValoracion()) {
                        $result['status'] = 1;
                    } else {
                        $result['error'] = 'Comentario/valoracion inexistente';
                    }
                    break;
            default:
                $result['error'] = 'Acción no disponible';
        }
    } else {
        // Se compara la acción a realizar cuando un cliente no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'createDetail':
                $result['error'] = 'Debe iniciar sesión para agregar el producto al carrito';
                break;
            default:
                $result['error'] = 'Acción no disponible fuera de la sesión';
        }
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
