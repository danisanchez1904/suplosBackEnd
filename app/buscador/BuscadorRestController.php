<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/suplosBackEnd/back-end/controller/RestController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/suplosBackEnd/app/buscador/Buscador.php';

class BuscadorRestController extends RestController {
    
    /**
     * 
     * @var BuscadorRestController
     */
    protected static $_instance = null;   
    
    /**
     * 
     * @var Buscador
     */
    protected $_buscador;
    
    /**
     * 
     */
    public function __construct() {
        $this->_buscador = new Buscador();
    }

    /**
     * Método de arranque del controlador
     */
    public static function run() {
        $obj = self::getInstance();
        $obj->iniciar();
    }

    /**
     * Patrón Singleton
     * @return type
     */
    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }    
    
    /**
     * 
     * @param array $request
     */
    protected function delete(array $request) {
        
    }
    
    /**
     * 
     */
    protected function getAllUserRows() {
        $rows = $this->_buscador->getAllUserRows();
        $this->response($rows);
    }
    
    /**
     * 
     * @param array $request
     */
    protected function get(array $request) {
        $this->call($request);
    }
    
    /**
     * 
     */
    protected function getAll() {
        $data = $this->_buscador->all();
        $this->response($data);        
    }
    
    /**
     * 
     * @param array $request
     */
    protected function searchBy(array $request) {
        $data = $this->_buscador->searchBy($request);
        $this->response($data);
    }

    /**
     * 
     * @param array $request
     */
    protected function post(array $request) {
        $this->call($request);
    }
    
    /**
     * 
     * @param array $request
     */
    protected function save(array $request) {
        $obj = $this->_buscador->searchById($request['id']);
        $this->_buscador->save($obj);
        $this->response($obj);
    }
    
    /**
     * 
     * @param array $request
     */
    protected function deleteUserRow(array $request) {
        $obj = $this->_buscador->searchById($request['id']);
        $this->_buscador->deleteUserRow($request['id']);
        $this->response($obj);
    }

    /**
     * 
     * @param array $request
     */
    protected function put(array $request) {
        
    }

}
