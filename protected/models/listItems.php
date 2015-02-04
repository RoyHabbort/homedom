<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class listItems{
    
    public function getCountItems($table) {
        $base = new mysqlClass();
        $sql = "SELECT * FROM `{$table}`";
        $count = $base->numrows($sql);
        if ($count) return $count;
            else return false;
    }
    
    public function getAllItems($table){
        $base = new mysqlClass();
        $sql = "SELECT * FROM `{$table}`";
        $items = $base->query($sql);
        if ($items){
            return $items;
        }else{
            return false;
        }
        
    }
    
}