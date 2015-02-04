<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of link
 *
 * @author Рой
 */
class link {
    
    public function getLink($id){
        $base = new mysqlClass();
        $sql = "SELECT `link` FROM `link` WHERE `id` = '{$id}'";
        $result = $base->query($sql);
        if ($result) return $result;
            else return false;
        
    }
    
    public static function getParent($id){
        $base = new mysqlClass();
        $sql = "SELECT `id_parent` FROM `link` WHERE `id` = '{$id}'";
        $result = $base->query($sql);
        if ($result) return $result[0]['id_parent'];
            else return false;
    }
    
    public function getMainLink(){
        $base = new mysqlClass();
        $sql = "SELECT `link` FROM `link` WHERE `level` = '1'";
        $result = $base->query($sql);
        if ($result) return $result;
            else return false;
        
    }
    
    
    public function createLinkObject($id){
        $base = new mysqlClass();
        $link = 'object/search/' . $id;
        $sql = "INSERT INTO `link` (`link`, `level`, `id_parent`) VALUES ('{$link}',2,8)";
        if ($base->query($sql)){
            return $base->last_insert_id();
        }else{
            return false;
        }
    }
}
