<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of routerClass
 *
 * @author Рой
 */
class routerClass {
    
    private $controller = '';
    private $action = '';
    private $arguments = '';
    private $file = '';
    
    public function delegate(){
    
        $this->getController();

        $controller = $this->controller ;
        $action = $this->action;
        $arguments = $this->arguments;
        if (is_readable($this->file) == false) {
            errorClass::getPageError('404');
            die();
        }
        
        include_once $this->file;
        $class = $this->controller . 'Controller';
        
        $controller = new $class();
        
        if (is_callable(array($controller, $this->action)) == false) {
            errorClass::getPageError('404');
            die();
        }
        $controller->$action($arguments);
    
    }
    
    private function getController(){
        
//        $route = $_SERVER["REQUEST_URI"];
//        echo $route;
         
        $route = (empty($_GET['route'])) ? '' : $_GET['route'];
        if (empty($route)) { $route = 'index'; }
        
        
        $route = trim($route, '/\\');
        $parts = explode('/', $route);
        
        $this->controller = $parts[0];
        array_shift($parts);
        if (!empty($parts)){
            $this->action = $parts[0];
            array_shift($parts);
            if(!empty($parts))$this->arguments = $parts;
        }
        
        if(empty($this->controller)) $this->controller = 'index';
        if(empty($this->action)) $this->action = 'index';
        if($this->controller == 'index') $this->controller = heretic::$_config['default_controller'];
        
        $this->file = heretic::$_path['controllers'].$this->controller . 'Controller.php';
        
    }
    
}
