<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
*	Clase para manejar el comportamiento de los datos de la tabla PRODUCTO.
*/
class ProductoHandler
{
    /*
    *   Declaración de atributos para el manejo de datos.
    */

    // Atributos de la tabla PRODUCTO.
    protected $id = null;
    protected $nombre = null;
    protected $descripcion = null;
    protected $imagen = null;
    protected $id_categoria = null;
    protected $id_tipo_producto = null;
    protected 
    // Atributos de la tabla DETALLE_PRODUCTO.
    protected $id_detalle_producto = null;
    protected $precio = null;
    protected $existencias = null;
    protected $id_talla = null;
    protected $id_genero = null;

    // Constante para establecer la ruta de las imágenes.
    const RUTA_IMAGEN = '../../images/productos/';

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
    */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_producto, imagen, nombre_producto, descripcion, nombre_categoria, tipo_producto
                FROM tb_productos
                INNER JOIN tb_categoris USING(id_categoria)
                INNER JOIN tb_tipos_productos USING(id_tipo_producto)
                WHERE nombre_producto LIKE ? OR descripcion LIKE ? OR nombre_categoria LIKE ? OR tipo_producto LIKE ?
                ORDER BY nombre_producto';
        $params = array($value, $value, $value, $value);
        return Database::getRows($sql, $params);
    }

        public function createRow()
        {
            $sql = 'INSERT INTO tb_productos(nombre_producto, descripcion, imagen, id_categoria,id_tipo_producto)
                    VALUES(?, ?, ?, ?, ?)';
            $params = array($this->nombre, $this->descripcion, $this->imagen, $this->id_categoria, $this->id_tipo_producto);
            return Database::executeRow($sql, $params);
        }

        public function createRow_detalleProducto()
        {
            $sql = 'INSERT INTO tb_detalle_producto(precio, cantidad_disponible, id_talla, id_genero, id_producto)
                    VALUES(?, ?, ?, ?)';
            $params = array($this->precio, $this->existencias, $this->id_talla, $this->id_genero, $this->id);
            return Database::executeRow($sql, $params);
        }

    public function readAll()
    {
        $sql = 'SELECT id_producto, imagen_producto, nombre_producto, descripcion, nombre_categoria, tipo_producto
                FROM tb_productos
                INNER JOIN categoria USING(id_categoria)
                INNER JOIN tipo_producto USING(id_tipo_producto)
                ORDER BY nombre_producto';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT p.id_producto, p.nombre_producto, p.descripcion, dp.precio, dp.cantidad_disponible, p.id_categoria, p.id_tipo_producto, dp.id_talla, dp.id_genero, p.imagen 
                FROM tb_productos p
                INNER JOIN tb_detalle_producto dp USING(id_producto)
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function readFilename()
    {
        $sql = 'SELECT imagen
                FROM tb_productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_productos p
                INNER JOIN tb_detalle_producto dp USING(id_producto)
                SET p.imagen = ?, p.nombre_producto = ?, p.descripcion = ?, dp.precio = ?, dp.cantidad_disponible = ?, p.id_categoria = ?, p.id_tipo_producto = ?, dp.id_talla = ?, dp.id_genero = ?
                WHERE id_producto = ?';
        $params = array($this->imagen, $this->nombre, $this->descripcion, $this->precio, $this->existencias, $this->id_categoria,$this->id_tipo_producto,$this->id_talla,$this->id_genero, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_productos
                INNER JOIN tb_detalle_producto USING(id_producto)
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readProductosCategoria()
    {
        $sql = 'SELECT id_producto, imagen, nombre_producto, descripcion, nombre_categoria, tipo_producto
                FROM tb_productos
                INNER JOIN tb_categoria USING(id_categoria)
                INNER JOIN tb_tipo_producto USING(id_tipo_producto)
                WHERE id_categoria = ?
                ORDER BY nombre_producto';
        $params = array($this->categoria);
        return Database::getRows($sql, $params);
    }

    /*
    *   Métodos para generar gráficos.
    */
    public function cantidadProductosCategoria()
    {
        $sql = 'SELECT nombre_categoria, COUNT(id_producto) cantidad
                FROM producto
                INNER JOIN categoria USING(id_categoria)
                GROUP BY nombre_categoria ORDER BY cantidad DESC LIMIT 5';
        return Database::getRows($sql);
    }

    public function porcentajeProductosCategoria()
    {
        $sql = 'SELECT nombre_categoria, ROUND((COUNT(id_producto) * 100.0 / (SELECT COUNT(id_producto) FROM producto)), 2) porcentaje
                FROM producto
                INNER JOIN categoria USING(id_categoria)
                GROUP BY nombre_categoria ORDER BY porcentaje DESC';
        return Database::getRows($sql);
    }

    /*
    *   Métodos para generar reportes.
    */
    /*
    // Método para obtener los productos de una categoría. Comentada porque no se implementan reportes aun
    public function productosCategoria()
    {
        $sql = 'SELECT nombre_producto, precio_producto, estado_producto
                FROM producto
                INNER JOIN categoria USING(id_categoria)
                WHERE id_categoria = ?
                ORDER BY nombre_producto';
        $params = array($this->categoria);
        return Database::getRows($sql, $params);
    }
    */
    
}
