<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla TIPO_PRODUCTO.
 */
class TipoProductoHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $nombre = null;


    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_tipo_producto, tipo_producto
                FROM tb_tipo_productos
                WHERE tipo_producto LIKE ?
                ORDER BY tipo_producto';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tb_tipo_productos(tipo_producto)
                VALUES(?)';
        $params = array($this->nombre);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_tipo_producto, tipo_producto 
                FROM tb_tipo_productos
                ORDER BY tipo_producto';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_tipo_producto, tipo_producto
                FROM tb_tipo_productos
                WHERE id_tipo_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }


    public function updateRow()
    {
        $sql = 'UPDATE tb_tipo_productos
                SET tipo_producto = ?
                WHERE id_tipo_producto = ?';
        $params = array( $this->nombre, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_tipo_productos
                WHERE id_tipo_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
