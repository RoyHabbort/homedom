<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of loginWidget
 *
 * @author Рой
 */
class loginWidget extends widgetClass {
    
    public function index() {
        $users = new users();
        $fio = $users->getFio($_SESSION['phone']);
        if ($fio) $this->render('index', array('fio'=>$fio));
            else return false;
    }
    
}
