<?php
// Se incluye la clase del modelo.
require_once('../../helpers/database.php');

class Clientes
{
    protected $id_cliente = null;
    protected $nombre_ciente = null;
    protected $dui_cliente = null;
    protected $telefono_cliente = null;
    protected $correo_cliente = null;
    protected $dirección_cliente = null;
    protected $alias_cliente = null;
    protected $clave_cliente = null;

    public function checkUser($mail, $password)
    {
        $sql = 'SELECT id_cliente, nombre_ciente, dui_cliente, telefono_cliente, correo_cliente, dirección_cliente, alias_cliente, clave_cliente 
                FROM tb_clientes
                WHERE correo_cliente = ?';
        $params = array($mail);
        $data = Database::getRow($sql, $params);
        if (password_verify($password, $data['clave_cliente'])) {
            $this->id_cliente = $data['id_cliente'];
            $this->nombre = $data['nombre_ciente'];
            $this->dui = $data['dui_cliente'];
            $this->telefono = $data['telefono_cliente'];
            $this->correo = $data['correo_cliente'];
            $this->direccion_cliente = $data['direccion_cliente'];
            $this->alias = $data['alias_cliente'];
            $this->clave = $data['clave_cliente'];
            return true;
        } else {
            return false;
        }
    }
    public function changePassword()
    {
        $sql = 'UPDATE tb_cliente
                SET clave_cliente = ?
                WHERE id_cliente = ?';
        $params = array($this->clave_cliente, $this->id_cliente);
        return Database::executeRow($sql, $params);
    }
    public function editProfile()
    {
        $sql = 'UPDATE cliente
                SET nombre_ciente = ?, dui_cliente = ?, telefono_cliente = ?, correo_cliente = ?, direccion_cliente = ?, alias_cliente = ?, clave_cliente = ?
                WHERE id_cliente = ?';
        $params = array($this->nombre_ciente, $this->dui_cliente, $this->telefono_cliente, $this->dui_cliente, $this->telefono_cliente, $this->correo_cliente, $this->dirección_cliente, $this->alias_cliente, $this-> clave_cliente, $this->id_cliente);
        return Database::executeRow($sql, $params);
    }

    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_cliente, nombre_ciente, dui_cliente, telefono_cliente, correo_cliente, direccion_cliente, alias_cliente, clave_cliente
                FROM tb_clientes
                WHERE dui_cliente LIKE ? OR nombre_ciente LIKE ? OR correo_cliente LIKE ?
                ORDER BY dui_cliente';
        $params = array($value, $value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tb_clientes(nombre_ciente, dui_cliente, telefono_cliente, correo_cliente, direccion_cliente, alias_cliente, clave_cliente)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre_ciente, $this->dui_cliente, $this->telefono_cliente, $this->correo_cliente, $this->dirección_cliente, $this->alias_cliente, $this->clave_cliente);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_clientes
                SET nombre_cliente = ?, dui_cliente = ?, telefono_cliente = ?, correo_cliente = ?, direccion_cliente = ?, alias_cliente = ?, clave_cliente = ?
                WHERE id_cliente = ?';
        $params = array($this->nombre_ciente, $this->dui_cliente, $this->telefono_cliente, $this->correo_cliente, $this->dirección_cliente, $this->alias_cliente, $this->clave_cliente, $this->id_cliente);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_cliente
                WHERE id_cliente = ?';
        $params = array($this->id_cliente);
        return Database::executeRow($sql, $params);
    }

    public function checkDuplicate($value)
    {
        $sql = 'SELECT id_cliente
                FROM tb_cliente
                WHERE dui_cliente = ? OR correo_cliente = ?';
        $params = array($value, $value);
        return Database::getRow($sql, $params);
    }
}