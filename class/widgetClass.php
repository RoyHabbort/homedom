<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of widgetClass
 *
 * @author Рой
 */
class widgetClass {
    
    
    private function getViews($views){
        $widget = get_class($this);
        $widget = str_replace('Widget', '', $widget);
        
        return heretic::$_path['widget'] . $widget . '/views/' . $views . '.php';
    }
    
    public function render($views = 'index', $arguments = array()) {
        $views = $this->getViews($views);
        
        $output = new viewsClass();
        $output->partialRenderPage($views, $arguments);
    }
    
}
