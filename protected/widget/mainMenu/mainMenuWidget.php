<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mainMenuWidget
 *
 * @author Рой
 */
class mainMenuWidget extends widgetClass{
    
    public function index(){
        
        $link_object = new link();
        $link_main = $link_object->getMainLink();
        
        $user = new users();
        $ifGetCode = $user->ifGetCode();
        
        $news = new news();
        $image = $news->getMainImage();
        
        $this->render('mainMenu', array('ifGetCode'=> $ifGetCode, 'image' => $image));
        
    }
    
}
