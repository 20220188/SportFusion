<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
*	Clase para manejar el comportamiento de los datos de la tabla PRODUCTO.
*/
class DeporteHandler
{
    /*
    *   Declaración de atributos para el manejo de datos.
    */
    protected $id = null;
    protected $nombre = null;
    protected $imagen = null;
    protected $estado = null;

    // Constante para establecer la ruta de las imágenes.
    const RUTA_IMAGEN = '../../images/deportes/';

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
    */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_deporte, nombre_deporte, estado_retro, imagen_deporte
                FROM tb_deportes
                WHERE nombre_deporte LIKE ?
                ORDER BY nombre_deporte';
        $params = array($value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tb_deportes(nombre_deporte, estado_retro, imagen_deporte)
                    VALUES(?, ?, ?)';
        $params = array($this->nombre, $this->estado, $this->imagen);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_deporte, nombre_deporte, estado_retro, imagen_deporte
                FROM tb_deportes
                ORDER BY nombre_deporte';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_deporte, nombre_deporte, estado_retro, imagen_deporte
                FROM tb_deportes
                WHERE id_deporte = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function readFilename()
    {
        $sql = 'SELECT imagen_deporte
                FROM tb_deportes
                WHERE id_deporte = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_deportes
                SET nombre_deporte = ?,imagen_deporte = ?,  estado_retro = ?
                WHERE id_deporte = ?';
        $params = array($this->nombre, $this->imagen, $this->estado, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_deportes
                WHERE id_deporte = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para mostrar las graficas.
    */

    public function readTopProductosxDeporte()
    {
        $sql = 'SELECT nombre_producto, cantidad_disponible 
                FROM tb_detalle_productos
                INNER JOIN tb_productos USING(id_producto)
                WHERE id_deporte = ?
                GROUP BY nombre_producto
                ORDER BY cantidad_disponible DESC
                LIMIT 5';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    
}
