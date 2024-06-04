<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
*	Clase para manejar el comportamiento de los datos de la tabla PRODUCTO.
*/
class PedidoHandler
{
    /*
    *   Declaración de atributos para el manejo de datos.
    */

    // Atributos de la tabla PEDIDO.
    protected $id_pedido = null;
    protected $direccion_pedido = null;
    protected $fecha_registro = null;
    protected $id_cliente = null;
    // Atributos de la tabla DETALLE_PEDIDO.
    protected $id_detalle = null;
    protected $cantidad_pedido = null;
    protected $precio_pedido = null;
    protected $id_estado_pedido = null;
    protected $id_producto = null;



    /*
    *   Métodos para realizar las operaciones SCRUD en tabla PEDIDO (search, create, read, update, and delete).
    */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_pedido, direccion_pedido, fecha_registro, nombre_cliente
                FROM tb_pedidos
                INNER JOIN tb_clientes USING(id_cliente)
                WHERE direccion_pedido LIKE ? OR fecha_registro LIKE ? OR nombre_cliente LIKE ? 
                ORDER BY direccion_pedido';
        $params = array($value, $value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tb_pedidos(direccion_pedido, fecha_registro, id_cliente)
                    VALUES(?, ?, ?)';
        $params = array($this->direccion_pedido, $this->fecha_registro, $this->id_cliente);
        //esto funciona para ver los valores que toma el arreglo print_r($params);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_pedido, direccion_pedido, fecha_registro, nombre_cliente, estado_pedido, id_estado_pedido  
                FROM tb_pedidos
                INNER JOIN tb_clientes USING(id_cliente)
                INNER JOIN tb_estado_pedidos USING(id_estado_pedido)
                ORDER BY id_pedido';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_pedido, estado_pedido
                FROM tb_pedidos 
                INNER JOIN tb_estado_pedidos USING(id_estado_pedido)
                WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_pedidos p
                SET  p.id_estado_pedido = ?
                WHERE id_pedido = ?';
        $params = array($this->id_estado_pedido, $this->id_pedido);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_pedidos
                WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::executeRow($sql, $params);
    }


    /*
    *   Métodos para realizar las operaciones SCRUD en tabla DETALLE?PRODUCTO (search, create, read, update, and delete).
    */
    public function createRowDetalle()
    {
        $sql = 'INSERT INTO tb_detalle_pedidos(cantidad_pedido, precio_pedido, id_pedido, id_producto, id_estado_pedido)
                    VALUES(?, ?, ?, ?, ?)';
        $params = array($this->cantidad_pedido, $this->precio_pedido, $this->id_pedido, $this->id_producto, $this->id_estado_pedido);
        return Database::executeRow($sql, $params);
    }

    public function readAllDetalle()
    {
        $sql = 'SELECT dp.id_detalle, dp.cantidad_pedido, dp.precio_pedido, dp.id_pedido, g.nombre_producto
        FROM tb_detalle_pedidos dp
        INNER JOIN tb_pedidos t USING(id_pedido)
        INNER JOIN tb_productos g USING(id_producto)
        WHERE dp.id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::getRows($sql, $params);
    }

    public function readOneDetalle()
    {
        $sql = 'SELECT id_detalle, id_estado_pedido
                FROM tb_detalle_pedidos
                WHERE id_detalle = ?';
        $params = array($this->id_detalle);
        return Database::getRow($sql, $params);
    }

    public function updateRowDetalle()
    {
        $sql = 'UPDATE tb_detalle_pedidos 
                SET id_estado_pedido = ?
                WHERE id_detalle = ?';
        $params = array($this->id_estado_pedido, $this->id_detalle);
        return Database::executeRow($sql, $params);
    }

    public function deleteRowDetalle()
    {
        $sql = 'DELETE FROM tb_detalle
                WHERE id_detalle = ?';
        $params = array($this->id_detalle);
        return Database::executeRow($sql, $params);
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
