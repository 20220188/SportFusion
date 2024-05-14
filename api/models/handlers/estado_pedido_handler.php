<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla ESTADO_PEDIDO.
 */
class EstadoPedidoHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $estado = null;


    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_estado_pedido, estado_pedido
                FROM tb_estado_pedidos
                WHERE estado_pedido LIKE ?
                ORDER BY estado_pedido';
        $params = array($value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tb_estado_pedidos(estado_pedido)
                VALUES(?)';
        $params = array($this->estado);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_estado_pedido, estado_pedido 
                FROM tb_estado_pedidos
                ORDER BY estado_pedido';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_estado_pedido, estado_pedido
                FROM tb_estado_pedidos
                WHERE id_estado_pedido = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }


    public function updateRow()
    {
        $sql = 'UPDATE tb_estado_pedidos
                SET estado_pedido = ?
                WHERE id_estado_pedido = ?';
        $params = array( $this->estado, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_estado_pedidos
                WHERE id_estado_pedido = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
