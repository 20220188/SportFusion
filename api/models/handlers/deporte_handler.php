<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
*	Clase para manejar el comportamiento de los datos de la tabla PRODUCTO.
*/
class DeporteHandler{

    //Declaración de atributos 

    protected $id = null;
    protected $nombre = null;
    protected $retro = null;
    protected $imagen = null;


    // Constante para establecer la ruta de las imágenes.
    const RUTA_IMAGEN = '../../images';


    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
    */
    public function searchRows(){
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_deporte, nombre_deporte, estado_retro
                FROM tb_deportes
                WHERE nombre_deporte LIKE ?
                ORDER BY nombre_deporte';
        $params = array($value, $value);
        return Database::getRows($sql, $params);    
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tb_deportes(nombre_deporte, estado_retro,imagen_deporte)
                VALUES(?,?)';
        $params = array($this->nombre,  $_SESSION['idAdministrador']);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_deportes
                SET  nombre_deporte = ?, estado_retro = ?, imagen_deporte = ?
                WHERE id_deporte = ?';
        $params = array(, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_deportes
                WHERE id_deporte = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readFilename()
    {
        $sql = 'SELECT imagen_deporte
                FROM tb_deporte
                WHERE id_deporte = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

}

