<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handlers/producto_handler.php');
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
            $this->data_error = 'El identificador del producto es incorrecto';
            return false;
        }
    }

    public function setDireccion($value, $min = 2, $max = 250)
    {
        if (!Validator::validateString($value)) {
            $this->data_error = 'No';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->direccion_pedido = $value;
            return true;
        } else {
            $this->data_error = 'La dirección debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    // Métodos para el manejo de la tabla DETALLE_PRODUCTO.

public function setDetalleproducto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_detalle_producto = $value;
            return true;
        } else {
            $this->data_error = 'Tipo producto incorrecto';
            return false;
        }
    }

    public function setPrecio($value)
    {
        if (Validator::validateMoney($value)) {
            $this->precio = $value;
            return true;
        } else {
            $this->data_error = 'El precio debe ser un valor numérico';
            return false;
        }
    }

    public function setExistencias($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->existencias = $value;
            return true;
        } else {
            $this->data_error = 'El valor de las existencias debe ser numérico entero';
            return false;
        }
    }

    public function setTalla($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_talla = $value;
            return true;
        } else {
            $this->data_error = 'Talla incorrecta';
            return false;
        }
    }

    public function setGenero($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_genero = $value;
            return true;
        } else {
            $this->data_error = 'Género incorrecto';
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
