<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla CATEGORIA.
 */
class CategoriaHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $nombre = null;

    

    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */
    public function searchRows() /*Buscar dentro de la tabla*/ 
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT nombre_categoria
                FROM tb_categoria
                WHERE nombre_categoria LIKE ? 
                ORDER BY nombre_categoria';
        $params = array($value);
        return Database::getRows($sql, $params);
    }

    public function createRow() /*Crear una fila nueva*/
    {
        $sql = 'INSERT INTO tb_categoria(nombre_categoria)
                VALUES(?)';
        $params = array($this->nombre);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_categoria, nombre_categoria
                FROM tb_categoria
                ORDER BY nombre_categoria';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_categoria
                FROM tb_categoria
                WHERE id_categoria = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_categoria
                SET nombre_categoria = ?, 
                WHERE id_categoria = ?';
        $params = array($this->nombre, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_categoria
                WHERE id_categoria = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
