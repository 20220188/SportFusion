<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handlers/pedidos_handler.php');
/*
 *	Clase para manejar el encapsulamiento de los datos de la tabla PRODUCTO.
 */
class PedidoData extends PedidoHandler
{
    /*
     *  Atributos adicionales.
     */
    private $data_error = null;

    /*
     *   Métodos para validar y establecer los datos.
     */

    // Métodos para el manejo de la tabla PEDIDO.
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_pedido = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del pedido es incorrecto';
            return false;
        }
    }

    public function setDireccion($value, $min = 2, $max = 250)
    {
        if (!Validator::validateString($value)) {
            $this->data_error = 'El formato de la dirección es incorrecto';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->direccion_pedido = $value;
            return true;
        } else {
            $this->data_error = 'La dirección debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }
    

    public function setFecha($value)
    {
        if (!Validator::validateDate($value)) {
            $this->data_error = 'la fecha de registro es incorrecta';
            return false;
        } else {
            $this->data_error = 'El formato de la fecha es incorrecto';
            return false;
        }
    }

    public function setId_cliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_cliente = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del cliente es incorrecto';
            return false;
        }
    }

    // Métodos para el manejo de la tabla DETALLE_PRODUCTO.

public function setDetallePedido($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_detalle = $value;
            return true;
        } else {
            $this->data_error = 'Id de detalle incorrecto';
            return false;
        }
    }

    public function getValoracion()
    {
        if(!$this->readValoracion()){
            return true;
        }else{
            $this->data_error = 'El producto ya fue valorado';
            return false;
        }
    }

    public function setid_Producto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_producto = $value;
            return true;
        } else {
            $this->data_error = 'Id de producto incorrecto';
            return false;
        }
    }
    
    public function setCantidad($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidad_pedido = $value;
            return true;
        } else {
            $this->data_error = 'El valor de las existencias debe ser numérico entero';
            return false;
        }
    }

    public function setPrecio($value)
    {
        if (Validator::validateMoney($value)) {
            $this->precio_pedido = $value;
            return true;
        } else {
            $this->data_error = 'El precio debe ser un valor numérico';
            return false;
        }
    }

    public function setId_estado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->estado_pedido = $value;
            return true;
        } else {
            $this->data_error = 'Estado incorrecto';
            return false;
        }
    }

    // Métodos para el manejo de la tabla VALORACION.

    public function setid_valoracion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_valoracion = $value;
            return true;
        } else {
            $this->data_error = 'El identificador de la valoracion es incorrecto';
            return false;
        }
    }

    public function setComentario($value, $min = 2, $max = 250)
    {
        if (!Validator::validateString($value)) {
            $this->data_error = 'El comentario contiene caracteres prohibidos';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->comentario = $value;
            return true;
        } else {
            $this->data_error = 'El comentario debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    public function setValoracion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->valoracion = $value;
            return true;
        } else {
            $this->data_error = 'Ocurrió un error al valorar el producto';
            return false;
        }
    }

    public function setEstado_valoracion($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estado_valoracion = $value;
            return true;
        } else {
            $this->data_error = 'Estado incorrecto';
            return false;
        }
    }


    /*
     *  Métodos para obtener los atributos adicionales.
     */
    public function getDataError()
    {
        return $this->data_error;
    }
}
