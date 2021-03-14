<?php


abstract class RestController {
    
    /**
     * 
     * @var RestController
     */
    protected static $_instance = null; 
    
    /**
     * 
     */
    protected function iniciar() {
        $method = $_SERVER['REQUEST_METHOD'];
        $request = [];
        switch($method) {
            case 'GET':
                $request = $_GET;
                $this->get($request);
            break;
            case 'POST':
                $request = $_POST;
                $this->post($request);
            break; 
            case 'DELETE':
                $request = file_get_contents('php://input');
                $this->delete($request);
            break;  
            case 'PUT':
                $request = file_get_contents('php://input');
                $this->put($request);
            break;         
        }
    }
    
    /**
     * 
     * @param array|Object $data
     */
    protected function response($data) {
        $json = json_encode($data);
        echo $json;
        exit();
    }
    
    protected function call(array $request) {
        $method = $request['action'];
        if (method_exists($this, $method)) {
            $this->{$method}($request);
        }        
    }
    
    abstract protected function post(array $request);
    
    abstract protected function get(array $request);
    
    abstract protected function delete(array $request);
    
    abstract protected function put(array $request);
}
