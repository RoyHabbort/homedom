<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mainController
 *
 * @author Рой
 */
class pageController extends controllerClass{
    
    public function index() {
        $this->render();
    }
    
    public function about() {
        
        $model = new page();
        $result = $model->getPage(2);
        
        heretic::$_config['titlePage'] = $result['title'];
        
        $this->render('page', $result);
        
    }
    
    public function help() {
        
        $model = new page();
        $result = $model->getPage(3);
        
        heretic::$_config['titlePage'] = $result['title'];
        
        $this->render('page', $result);
    }
    
    
    
}
