<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla CATEGORIA.
 */
class ClienteHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $nombre = null;
    protected $telefono = null;
    protected $correo = null;
    protected $direccion = null;
    protected $alias = null;
    protected $clave = null;



    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_cliente, nombre_ciente, telefono_cliente, correo_cliente, dirección_cliente, alias_cliente, clave_cliente
                FROM tb_clientes
                WHERE nombre_ciente LIKE ? OR correo_cliente LIKE ?
                ORDER BY nombre_ciente';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tb_clientes(nombre_ciente, telefono_cliente, correo_cliente, dirección_cliente, alias_cliente, clave_cliente)
                VALUES(?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->telefono, $this->correo, $this->direccion, $this->alias, $this->clave);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_cliente, nombre_ciente, telefono_cliente, correo_cliente, dirección_cliente, alias_cliente, clave_cliente
                FROM tb_clientes
                ORDER BY nombre_ciente';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_cliente, nombre_ciente, telefono_cliente, correo_cliente, dirección_cliente, alias_cliente, clave_cliente
                FROM tb_clientes
                WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function readFilename()
    {
        $sql = 'SELECT nombre_ciente
                FROM tb_clientes
                WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_clientes
                SET nombre_ciente = ?, telefono_cliente = ?, correo_cliente = ?
                WHERE id_cliente = ?';
        $params = array($this->nombre, $this->telefono, $this->correo, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_clientes
                WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
