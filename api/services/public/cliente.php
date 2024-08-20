<?php
// Se incluye la clase del modelo.
require_once('../../models/data/clientes_data.php');
require_once('../../services/admin/mail_config.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $cliente = new ClienteData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'error' => null, 'exception' => null, 'username' => null);

    // Se verifica si existe una sesión iniciada como cliente para realizar las acciones correspondientes.
    if (isset($_SESSION['idCliente'])) {
        $result['session'] = 1;

        // Se compara la acción a realizar cuando un cliente ha iniciado sesión.
        switch ($_GET['action']) {
            case 'logOut':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminada correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;

            case 'getUser':
                if (isset($_SESSION['correoCliente'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['correoCliente'];
                } else {
                    $result['error'] = 'Correo de usuario indefinido';
                }
                break;

            case 'readProfile':
                if ($result['dataset'] = $cliente->readProfile()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Ocurrió un problema al leer el perfil';
                }
                break;

            case 'editProfile':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$cliente->setId($_SESSION['idCliente']) ||
                    !$cliente->setNombre($_POST['nombreclientePerfil']) ||
                    !$cliente->setTelefono($_POST['telefonoclientePerfil']) ||
                    !$cliente->setCorreo($_POST['correoclientePerfil']) ||
                    !$cliente->setDireccion($_POST['direccionclientePerfil'])
                ) {
                    $result['error'] = $cliente->getDataError();
                } elseif ($cliente->editProfile()) {
                    $result['status'] = 1;
                    $result['message'] = 'Perfil modificado correctamente';
                    $_SESSION['correoCliente'] = $_POST['correoclientePerfil'];
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el perfil';
                }
                break;

            case 'changePassword':
                $_POST = Validator::validateForm($_POST);
                if (!$cliente->checkPassword($_POST['claveActual'])) {
                    $result['error'] = 'Contraseña actual incorrecta';
                } elseif ($_POST['claveNueva'] != $_POST['confirmarClave']) {
                    $result['error'] = 'Confirmación de contraseña diferente';
                } elseif (!$cliente->setClave($_POST['claveNueva'])) {
                    $result['error'] = $cliente->getDataError();
                } elseif ($cliente->changePassword()) {
                    $result['status'] = 1;
                    $result['message'] = 'Contraseña cambiada correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al cambiar la contraseña';
                }
                break;

            case 'verificarCorreo':
                $_POST = Validator::validateForm($_POST);
                if (!$cliente->setVerificarCorreo($_POST['correo'])) {
                    $result['error'] = $cliente->getDataError();
                } elseif ($result['dataset'] = $cliente->verificarCorreo()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Ocurrió un error al verificar el correo';
                }
                break;

            default:
                $result['error'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el cliente no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'signUp':
                $_POST = Validator::validateForm($_POST);
                $secretKey = '6LdBzLQUAAAAAL6oP4xpgMao-SmEkmRCpoLBLri-';
                $ip = $_SERVER['REMOTE_ADDR'];
                $data = array('secret' => $secretKey, 'response' => $_POST['gRecaptchaResponse'], 'remoteip' => $ip);
                $options = array(
                    'http' => array('header' => 'Content-type: application/x-www-form-urlencoded\r\n', 'method' => 'POST', 'content' => http_build_query($data)),
                    'ssl' => array('verify_peer' => false, 'verify_peer_name' => false)
                );

                $url = 'https://www.google.com/recaptcha/api/siteverify';
                $context = stream_context_create($options);
                $response = file_get_contents($url, false, $context);
                $captcha = json_decode($response, true);

                if (!$captcha['success']) {
                    $result['recaptcha'] = 1;
                    $result['error'] = 'No eres humano';
                } elseif (!isset($_POST['condicion'])) {
                    $result['error'] = 'Debe marcar la aceptación de términos y condiciones';
                } elseif (
                    !$cliente->setNombre($_POST['nombreCliente']) ||
                    !$cliente->setCorreo($_POST['correoCliente']) ||
                    !$cliente->setDireccion($_POST['direccionCliente']) ||
                    !$cliente->setTelefono($_POST['telefonoCliente']) ||
                    !$cliente->setClave($_POST['claveCliente'])
                ) {
                    $result['error'] = $cliente->getDataError();
                } elseif ($_POST['claveCliente'] != $_POST['confirmarClave']) {
                    $result['error'] = 'Contraseñas diferentes';
                } elseif ($cliente->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cuenta registrada correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al registrar la cuenta';
                }
                break;

            case 'signUpMovil':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$cliente->setNombre($_POST['nombreCliente']) ||
                    !$cliente->setCorreo($_POST['correoCliente']) ||
                    !$cliente->setDireccion($_POST['direccionCliente']) ||
                    !$cliente->setTelefono($_POST['telefonoCliente']) ||
                    !$cliente->setClave($_POST['claveCliente'])
                ) {
                    $result['error'] = $cliente->getDataError();
                } elseif ($_POST['claveCliente'] != $_POST['confirmarClave']) {
                    $result['error'] = 'Contraseñas diferentes';
                } elseif ($cliente->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cuenta registrada correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al registrar la cuenta';
                }
                break;

            case 'logIn':
                $_POST = Validator::validateForm($_POST);
                if (!$cliente->checkUser($_POST['correo'], $_POST['clave'])) {
                    $result['error'] = 'Datos incorrectos';
                } elseif ($cliente->checkStatus()) {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                } else {
                    $result['error'] = 'La cuenta ha sido desactivada';
                }
                break;

            case 'verifyEmail':
                if (isset($_POST['correo'])) {
                    $correo = $_POST['correo'];
                    if ($cliente->checkEmailExists($correo)) {
                        $result['status'] = 1;
                        $result['message'] = 'Correo encontrado';
                    } else {
                        $result['error'] = 'Correo no encontrado';
                    }
                } else {
                    $result['error'] = 'Correo no proporcionado';
                }
                break;

            case 'solicitarPinRecuperacion':
                $_POST = Validator::validateForm($_POST);
                if (!isset($_POST['correo'])) {
                    $result['error'] = 'Falta el correo electrónico';
                } elseif (!$cliente->setCorreos($_POST['correo'])) {
                    $result['error'] = 'Correo electrónico inválido';
                } else {
                    // Verificar si el correo existe en la base de datos
                    $checkCorreoSql = 'SELECT COUNT(*) as count, nombre_cliente FROM tb_clientes WHERE correo_cliente = ?';
                    $checkCorreoParams = array($_POST['correo']);
                    $checkCorreoResult = Database::getRow($checkCorreoSql, $checkCorreoParams);

                    if ($checkCorreoResult['count'] == 0) {
                        $result['error'] = 'No existe una cuenta asociada a este correo electrónico';
                    } elseif ($pin = $cliente->generarPinRecuperacion($_POST['correo'])) {
                        $result['status'] = 1;
                        $result['message'] = 'PIN generado con éxito';

                        // Enviar correo con el PIN
                        $email = $_POST['correo'];
                        $cliente = $checkCorreoResult['nombre_cliente'];
                        $subject = "Recuperación de clave - SportsFusion";
                        $body = "
                            <p>Estimado/a {$cliente},</p>
                            <p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en SportsFusion.</p>
                            <p>Tu PIN de recuperación es: <strong>{$pin}</strong></p>
                            <p>Este PIN es válido por los próximos 30 minutos. Si no solicitaste este cambio, por favor ignora este mensaje.</p>
                            <p>Para completar el proceso de recuperación de contraseña, ingresa este PIN en la aplicación.</p>
                            <p>Si tienes alguna pregunta o necesitas ayuda adicional, no dudes en contactarnos.</p>
                            <p>Saludos cordiales,<br>El equipo de SportsFusion</p>
                        ";

                        $emailResult = sendEmail($email, $subject, $body);
                        if ($emailResult !== true) {
                            $result['message'] .= ' Sin embargo, no se pudo enviar el correo con el PIN.';
                        }
                    } else {
                        $result['error'] = 'No se pudo generar el PIN';
                    }
                }
                break;

            case 'verificarPin':
                if (!isset($_POST['correo']) || !isset($_POST['pin'])) {
                    $result['error'] = 'Faltan datos necesarios';
                } elseif (!$cliente->setCorreos($_POST['correo'])) {
                    $result['error'] = 'Correo electrónico inválido';
                } else {
                    $id_usuario = $cliente->verificarPinRecuperacion($_POST['pin']);
                    if ($id_usuario) {
                        $result['status'] = 1;
                        $result['id_usuario'] = $id_usuario;
                        $result['message'] = 'PIN verificado correctamente';
                    } else {
                        $result['error'] = 'PIN inválido o expirado';
                    }
                }
                break;

                case 'cambiarClaveConPin':
                    $_POST = Validator::validateForm($_POST);
                    if (!isset($_POST['id_cliente']) || !isset($_POST['nuevaClave'])) {
                        $result['error'] = 'Faltan datos necesarios';
                    } else {
                        $id_cliente = $_POST['id_cliente'];
                        $nuevaClave = $_POST['nuevaClave'];
                        if ($cliente->cambiarClaveConPin($id_cliente, $nuevaClave)) {
                            $result['status'] = 1;
                            $result['message'] = 'Contraseña cambiada exitosamente';
                            $cliente->resetearPin(); // Resetea el PIN para que no se pueda usar nuevamente
                        } else {
                            $result['error'] = 'No se pudo cambiar la contraseña';
                        }
                    }
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
    echo json_encode($result);
} else {
    echo json_encode(array('error' => 'Recurso no disponible'));
}
