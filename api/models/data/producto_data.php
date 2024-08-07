<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handlers/producto_handler.php');
/*
 *	Clase para manejar el encapsulamiento de los datos de la tabla PRODUCTO.
 */
class ProductoData extends ProductoHandler
{
    /*
     *  Atributos adicionales.
     */
    private $data_error = null;
    private $filename = null;

    /*
     *   Métodos para validar y establecer los datos.
     */

    // Métodos para el manejo de la tabla PRODUCTO.
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del producto es incorrecto';
            
            return false;
        }
    }

    public function setNombre($value, $min = 2, $max = 50)
    {
        if (!Validator::validateAlphanumeric($value)) {
            $this->data_error = 'El nombre debe ser un valor alfanumérico';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->nombre = $value;
            return true;
        } else {
            $this->data_error = 'El nombre debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    public function setDescripcion($value, $min = 2, $max = 250)
    {
        if (!Validator::validateString($value)) {
            $this->data_error = 'La descripción contiene caracteres prohibidos';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->descripcion = $value;
            return true;
        } else {
            $this->data_error = 'La descripción debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }
    
    public function setImagen($file, $filename = null)
    {
        if (Validator::validateImageFile($file, 400)) {
            $this->imagen = Validator::getFileName();
            return true;
        } elseif (Validator::getFileError()) {
            $this->data_error = Validator::getFileError();
            return false;
        } elseif ($filename) {
            $this->imagen = $filename;
            return true;
        } else {
            $this->imagen = 'default.png';
            return true;
        }
    }
    
    public function setCategoria($value)
    {
        if($value == null){
            $this->id_categoria = null;
            return true;
        } elseif (Validator::validateNaturalNumber($value)) {
            $this->id_categoria = $value;
            return true;
        } else {
            $this->data_error = 'El identificador de la categoría es incorrecto';
            return false;
        }
    }
    
    public function setTipoProducto($value)
    {
        if($value == null){
            $this->id_tipo_producto = null;
            return true;
        }elseif (Validator::validateNaturalNumber($value)) {
            $this->id_tipo_producto = $value;
            return true;
        } else {
            $this->data_error = 'Tipo producto incorrecto';
            return false;
        }
    }

    public function setDeporte($value)
    {
        if($value == null){
            $this->id_deporte = null;
            return true;
        }elseif (Validator::validateNaturalNumber($value)) {
            $this->id_deporte = $value;
            return true;
        } else {
            $this->data_error = 'Deporte incorrecto';
            return false;
        }
    }

    public function setFilename()
    {
        if ($data = $this->readFilename()) {
            $this->filename = $data['imagen'];
            return true;
        } else {
            $this->data_error = 'Producto inexistente';
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
            $this->data_error = 'Detalle producto incorrecto';
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

    public function setPrecioMin($value)
    {
        if (Validator::validateMoney($value)) {
            $this->precioMin = $value;
            return true;
        } else {
            $this->data_error = 'El precio minimo debe ser un valor numérico';
            return false;
        }
    }

    public function setPrecioMax($value)
    {
        if (Validator::validateMoney($value)) {
            $this->precioMax = $value;
            return true;
        } else {
            $this->data_error = 'El precio maximo debe ser un valor numérico';
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
        if($value == null){
            $this->id_genero = null;
            return true;
        }elseif (Validator::validateNaturalNumber($value)) {
            $this->id_genero = $value;
            return true;
        } else {
            $this->data_error = 'Género incorrecto';
            return false;
        }
    }

    public function setIdProducto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_producto = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del producto en el detalle es incorrecto';
            return false;
        }
    }

    // Métodos para el manejo de la tabla VALORACION_PRODUCTOS

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

    public function setid_cliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_cliente = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del cliente es incorrecto';
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

    public function getFilename()
    {
        return $this->filename;
    }
}
