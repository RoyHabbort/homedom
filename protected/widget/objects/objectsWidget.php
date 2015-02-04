<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of objects
 *
 * @author Рой
 */
class objectsWidget extends widgetClass{
    
    public function index($arguments){
        
        echo "<pre>";
        var_dump($arguments);
        echo "</pre>";
        
        echo "17 - r9<br/><br/>";
        
        $model = new object();
        $obj = $model->getObjects();
        
        $this->render('objectViews', $obj);
        
    }
    
}
