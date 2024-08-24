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
    protected $estado_pedido = null;
    protected $id_producto = null;
    // Atributos de la tabla VALORACION.
    protected $id_valoracion = null;
    protected $comentario = null;
    protected $valoracion = null;
    protected $estado_valoracion = null;




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
        $sql = 'SELECT id_pedido, dirección_cliente, fecha_registro, nombre_cliente, estado_pedido  
                FROM tb_pedidos
                INNER JOIN tb_clientes USING(id_cliente)
                ORDER BY id_pedido';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_pedido, estado_pedido
                FROM tb_pedidos
                WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_pedidos p
                SET estado_pedido = ?
                WHERE id_pedido = ?';
        $params = array($this->estado_pedido, $this->id_pedido);
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
    *   Métodos para realizar las operaciones SCRUD en tabla DETALLE_PRODUCTO (search, create, read, update, and delete).
    */

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
        $sql = 'SELECT id_detalle, estado_pedido
                FROM tb_detalle_pedidos
                WHERE id_detalle = ?';
        $params = array($this->id_detalle);
        return Database::getRow($sql, $params);
    }

    public function updateRowDetalle()
    {
        $sql = 'UPDATE tb_detalle_pedidos 
                SET estado_pedido = ?
                WHERE id_detalle = ?';
        $params = array($this->estado_pedido, $this->id_detalle);
        return Database::executeRow($sql, $params);
    }

    public function deleteRowDetalle()
    {
        $sql = 'DELETE FROM tb_detalle
                WHERE id_detalle = ?';
        $params = array($this->id_detalle);
        return Database::executeRow($sql, $params);
    }

    // Métodos que se usan en el sitio publico para gestionar los pedidos

    public function getOrder()
    {
        $this->estado_pedido = 'Pendiente';
        $sql = 'SELECT id_pedido
                FROM tb_pedidos
                WHERE estado_pedido = ? AND id_cliente = ?';
        $params = array($this->estado_pedido, $_SESSION['idCliente']);
        if ($data = Database::getRow($sql, $params)) {
            $_SESSION['idPedido'] = $data['id_pedido'];
            return true;
        } else {
            return false;
        }
    }

    // Método para iniciar un pedido en proceso.
    public function startOrder()
    {
        if ($this->getOrder()) {
            return true;
        } else {
            $sql = 'INSERT INTO tb_pedidos (id_cliente, estado_pedido)
                    VALUES(?, ?)';
            $params = array($_SESSION['idCliente'], 'Pendiente');
            // Se obtiene el ultimo valor insertado de la llave primaria en la tabla pedido.
            if ($_SESSION['idPedido'] = Database::getLastRow($sql, $params)) {
                return true;
            } else {
                return false;
            }
        }
    }

    // Método para agregar un producto al carrito de compras.
    public function createDetail()
    {
        // Se realiza una subconsulta para obtener el precio del producto.
        $sql = 'INSERT INTO tb_detalle_pedidos(id_producto, precio_pedido, cantidad_pedido, id_pedido)
                VALUES(?, (SELECT precio FROM tb_detalle_productos WHERE id_producto = ?), ?, ?)';
        $params = array($this->id_producto, $this->id_producto, $this->cantidad_pedido, $_SESSION['idPedido']);
        return Database::executeRow($sql, $params);
    }

    // Método para obtener los productos que se encuentran en el carrito de compras.
    public function readDetail()
    {
        $sql = 'SELECT id_detalle, nombre_producto, precio_pedido, cantidad_pedido
                FROM tb_detalle_pedidos 
                INNER JOIN tb_pedidos USING(id_pedido)
                INNER JOIN tb_productos USING(id_producto)
                WHERE id_pedido = ?';
        $params = array($_SESSION['idPedido']);
        return Database::getRows($sql, $params);
    }

    // Método para finalizar un pedido por parte del cliente.
    public function finishOrder()
    {
        $this->estado_pedido = 'Aceptado';
        $sql = 'UPDATE tb_pedidos
                SET estado_pedido = ?
                WHERE id_pedido = ?';
        $params = array($this->estado_pedido, $_SESSION['idPedido']);
        return Database::executeRow($sql, $params);
    }

    // Método para actualizar la cantidad de un producto agregado al carrito de compras.
    public function updateDetail()
    {
        $sql = 'UPDATE tb_detalle_pedidos
                SET cantidad_pedido = ?
                WHERE id_detalle = ? AND id_pedido = ?';
        $params = array($this->cantidad_pedido, $this->id_detalle, $_SESSION['idPedido']);
        $result = Database::executeRow($sql, $params);

        if ($result) {
            // Llamar al procedimiento almacenado para actualizar la cantidad de productos
            $sql = 'CALL sp_actualizar_cantidad_producto(?, ?)';
            $params = array($this->id_detalle, $this->cantidad_pedido);
            return Database::executeRow($sql, $params);
        } else {
            return false;
        }
    }


    // Método para eliminar un producto que se encuentra en el carrito de compras.
    public function deleteDetail()
    {
        $sql = 'DELETE FROM tb_detalle_pedidos
                WHERE id_detalle = ? AND id_pedido = ?';
        $params = array($this->id_detalle, $_SESSION['idPedido']);
        return Database::executeRow($sql, $params);
    }

    // Método para obtener el historial de pedidos de un cliente.
    public function readHistorial()
    {
        $sql = 'SELECT id_pedido, fecha_registro, dirección_cliente, nombre_cliente, estado_pedido
                FROM tb_pedidos 
                INNER JOIN tb_clientes USING(id_cliente)
                WHERE estado_pedido = "Aceptado" AND id_cliente = ?';
        $params = array($_SESSION['idCliente']);
        return Database::getRows($sql, $params);
    }


    public function readDetalleHistorial()
    {
        $sql = 'SELECT id_detalle, id_pedido, precio_pedido, cantidad_pedido, nombre_producto, imagen
                FROM tb_detalle_pedidos
                INNER JOIN tb_pedidos USING(id_pedido)
                INNER JOIN tb_productos USING(id_producto) 
                WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::getRows($sql, $params);
    }

    public function readAllValoracionPublica()
    {
        $sql = 'SELECT v.comentario, v.valoracion, c.nombre_cliente, v.id_valoracion
        FROM tb_valoraciones v
        INNER JOIN tb_clientes c USING(id_cliente)
        inner join tb_detalle_pedidos dp using(id_detalle)
        WHERE dp.id_detalle = ? AND id_cliente = ?';
        $params = array($this->id_detalle, $_SESSION['idCliente']);
        return Database::getRows($sql, $params);
    }

    public function createRowValoracion()
    {
        $sql = 'INSERT INTO tb_valoraciones(comentario, valoracion, id_detalle, id_cliente)
                    VALUES(?, ?, ?, ?)';
        $params = array($this->comentario, $this->valoracion, $this->id_detalle, $_SESSION['idCliente']);
        return Database::executeRow($sql, $params);
    }


    public function updateRowValoracion()
    {
        $sql = 'UPDATE tb_valoraciones
        SET comentario = ?, valoracion = ?
        WHERE id_valoracion = ? AND id_cliente = ?';
        $params = array($this->comentario, $this->valoracion, $this->id_valoracion, $_SESSION['idCliente']);
        return Database::executeRow($sql, $params);
    }

    public function deleteValoracion()
    {
        $sql = 'DELETE FROM tb_valoraciones
                WHERE id_valoracion = ? AND id_cliente = ?';
        $params = array($this->id_valoracion, $_SESSION['idCliente']);
        return Database::executeRow($sql, $params);
    }

    public function readValoracion()
    {
        $sql = 'SELECT id_valoracion
        FROM tb_valoraciones 
        WHERE id_detalle = ? AND id_cliente = ?';
        $params = array($this->id_detalle, $_SESSION['idCliente']);
        return Database::getRow($sql, $params);
    }

    public function readOneValoracion()
    {
        $sql = 'SELECT id_valoracion, comentario, valoracion 
        FROM tb_valoraciones 
        WHERE id_valoracion = ? AND id_cliente = ?';
        $params = array($this->id_valoracion, $_SESSION['idCliente']);
        return Database::getRow($sql, $params);
    }


    /*
    *   Métodos para generar graficas 
    */
    public function ValoracionesProductos()
    {
        $sql = 'SELECT nombre_producto, AVG(valoracion) promedio 
    FROM tb_valoraciones
    INNER JOIN 	tb_detalle_pedidos USING (id_detalle)
    INNER JOIN tb_productos USING(id_producto)
    GROUP BY nombre_producto
    ORDER BY promedio ASC LIMIT 5 ';
        return Database::getRows($sql);
    }
    /*
    *   Métodos para generar reportes.
    */

    // Método para obtener los productos de una categoría. Comentada porque no se implementan reportes aun
    public function PedidosClientes()
    {
        $sql = 'SELECT id_pedido, nombre_cliente, fecha_registro, precio_pedido, nombre_producto, cantidad_pedido
            from tb_detalle_pedidos
            INNER JOIN tb_pedidos USING(id_pedido)
            INNER JOIN tb_productos USING (id_producto)
            INNER JOIN tb_clientes USING(id_cliente)
            WHERE id_cliente = ?';
        $params = array($this->id_cliente);
        return Database::getRows($sql, $params);
    }

    public function ComprobanteCompra()
    {
        $sql = 'SELECT  precio_pedido, cantidad_pedido, nombre_producto
            FROM tb_detalle_pedidos
            INNER JOIN tb_productos USING(id_producto)
            WHERE id_pedido = ?';
        $params = array($_SESSION['idPedido']);
        return Database::getRows($sql, $params);
    }
}

