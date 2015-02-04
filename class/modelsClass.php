<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modelsClass
 *
 * @author Рой
 */
class modelsClass extends imageClass{
     
    /*
     * 3-09-2014
     * Запрос на получение всех данный таблицы
     * roy
     */
    public function getAll($table, $criteria = '1'){
        $sql = "SELECT * FROM {$table} WHERE $criteria";
        $result = $this->query($sql);
        if($result) return $result;
            else return false;
    }
    
    
    /*
     * 3-09-2014
     * Запрос на получение одной строки из таблицы
     * roy
     */
    
    public function getOne($table, $criteria = '1'){
        $sql = "SELECT * FROM {$table} WHERE $criteria";
        $result = $this->query($sql);
        if($result) return $result[0];
            else return false;
    }
    
    /*
     * 3-09-2014
     * Запрос на получение записи из таблицы по id
     * roy
     */
    
    public function getById($table, $id){
        $sql = "SELECT * FROM {$table} WHERE `id_{$table}` = '{$id}'";
        $result = $this->query($sql);
        if($result) return $result[0];
            else return false;
    }
    
    /*
     * 3-09-2014
     * Запрос на удаление записи из таблицы по id
     * roy
     */
    
    public function DeleteById($table, $id){
        $sql = "DELETE FROM `{$table}` WHERE `id_{$table}` = '{$id}'";
        $this->query($sql);
        $result = $this->anotherNumRow();
        if($result) return true;
            else return false;
    }
    
    
}
