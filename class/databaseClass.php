<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of databaseClass
 *
 * @author Рой
 */
class databaseClass {
    
    
    private $db_host = "";
    private $db_login = "";
    private $db_password = "";
    private $db_name = "";
    public $db;
    
    public function selectDatabase($param) {
        $this->db_host = $param['db_host'];
        $this->db_login = $param['db_login'];
        $this->db_password = $param['db_password'];
        $this->db_name = $param['db_name'];
        return $this->conectDatabase();
    }
    
    public function closeDatabase(){
        $this->unconectionDatabase();
    }

        private function conectDatabase() {
      
        if (!$this->db = mysql_connect($this->db_host,$this->db_login,$this->db_password)){
            errorClass::$_error[] = 101;
            return false;
        }
        if  (!mysql_select_db($this->db_name ,$this->db)){
            errorClass::$_error[] = 102;
            return false;
        }
        else{
            return true;
        }
    }
    
    private function unconectionDatabase() {
        mysql_close($this->db);
    }
    
}
