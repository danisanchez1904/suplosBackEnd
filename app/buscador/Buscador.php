<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/suplosBackEnd/back-end/db/DB.php';

class Buscador {
    
    /**
     * 
     * @var string
     */
    protected $_data;
    
    /**
     * 
     */
    public function __construct() {
        $this->_data = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/suplosBackEnd/data-1.json');
    }
    
    /**
     * 
     * @return array
     */
    protected function readData() {
        if ($this->_data) {
            return json_decode($this->_data);
        }
    }
    
    /**
     * 
     * @return array
     */
    public function all() {
        $data = $this->readData();
        return $data;
    }
    
    /**
     * 
     * @param array $request
     * @return array
     */
    public function searchBy(array $request) {
        $data = $this->readData();
        $ciudad = $request['ciudad'];
        $tipo = $request['tipo'];
        $resultadosFiltrados = array();
        $incluir = true;
        $porCiudad = true;
        $porTipo = true;
        foreach ($data as $obj) {
            if ($ciudad) {
                $porCiudad = ($ciudad == $obj->Ciudad);
            }
            if ($tipo) {
                $porTipo = ($tipo === $obj->Tipo);
            }
            $incluir = ($porCiudad && $porTipo);
            if ($incluir) {
                $resultadosFiltrados[] = $obj;
            }
        }   
        return $resultadosFiltrados;
    }
    
    /**
     * 
     * @return array
     */
    public function getAllUserRows() {
        $db = DB::getConnection();
        $sql = "SELECT * FROM intelcost_bienes.bienes";
        $st = $db->prepare($sql);
        $st->execute();
        return $st->fetchAll();
    }
    
    
    /**
     * 
     * @return array
     */
    public function deleteUserRow($id) {
        $db = DB::getConnection();
        $sql = "DELETE FROM intelcost_bienes.bienes WHERE id = :id";
        $st = $db->prepare($sql);
        $st->bindParam(':id', $id);
        $st->execute();
    }    
    
    /**
     * 
     * @param stdClass $obj
     */
    public function save(stdClass $obj) {
        $db = DB::getConnection();
        $sql = "INSERT INTO intelcost_bienes.bienes(Id, Direccion, Ciudad, Telefono, Codigo_Postal, Tipo, Precio) 
                VALUES(:id, :direccion, :ciudad, :telefono, :codigo_postal, :tipo, :precio)
        ";
        $st = $db->prepare($sql);
        $st->bindParam(':id', $obj->Id);
        $st->bindParam(':direccion', $obj->Direccion);        
        $st->bindParam(':ciudad', $obj->Ciudad);
        $st->bindParam(':telefono', $obj->Telefono);        
        $st->bindParam(':codigo_postal', $obj->Codigo_Postal);        
        $st->bindParam(':tipo', $obj->Tipo);
        $st->bindParam(':precio', $obj->Precio);
        $st->execute();
    }
    
    /**
     * 
     * @param string $id
     * @return stdClass
     */
    public function searchById($id) {
        $data = $this->all();
        $inmueble = new stdClass();
        foreach ($data as $row) {
            if ((int)$id === (int) $row->Id) {
                $inmueble = $row;
            }
        }  
        return $inmueble;
    }
}
