<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla TIPO_PRODUCTO.
 */
class GeneroHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $genero = null;


    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_genero, genero
                FROM tb_generos
                WHERE genero LIKE ?
                ORDER BY genero';
        $params = array($value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tb_generos(genero)
                VALUES(?)';
        $params = array($this->genero);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_genero, genero
                FROM tb_generos
                ORDER BY genero';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_genero, genero
                FROM tb_generos
                WHERE id_genero = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }


    public function updateRow()
    {
        $sql = 'UPDATE tb_generos
                SET genero = ?
                WHERE id_genero = ?';
        $params = array( $this->genero, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_generos
                WHERE id_genero = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
