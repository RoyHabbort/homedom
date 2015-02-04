<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of billing
 *
 * @author Рой
 */
class billing extends modelsClass{
    
    public function getAllUsers(){
        $base = new mysqlClass();
        $sql = "SELECT * FROM `users` WHERE 1";
        $result = $base->query($sql); 
        
        foreach ($result as $key => $value) {
            $sql = "SELECT `id` FROM `object` WHERE `user_id` = '{$value['id_user']}'";
            $result[$key]['count'] = count($base->query($sql));
        }
        
        return $result;
        
    }
    
    
    public function getAllCities(){
        $base = new mysqlClass();
        $sql = "SELECT * FROM `city` WHERE 1";
        $result = $base->query($sql); 
        
        return $result;
    }
    
}
