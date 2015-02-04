<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controllerClass
 *
 * @author Рой
 */
class controllerClass {
    
    
    private function getViews($views){
        
        $controller = get_class($this);
        $controller = str_replace('Controller', '', $controller);
        
        return heretic::$_path['views'] . $controller . '/' . $views . '.php';
        
    }
    
    public function partialRender($views = 'index', $arguments = array()) {
        $views = $this->getViews($views);
        
        $output = new viewsClass();
        $output->partialRenderPage($views, $arguments);
    }
    
    public function render($views = 'index', $arguments = array()) {
        
        $views = $this->getViews($views);
        
        $output = new viewsClass();
        $output->renderPage($views, $arguments);
    }
    
        
    
}
