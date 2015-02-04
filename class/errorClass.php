<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mainClass
 *
 * @author Рой
 */
class errorClass {
    
    public static $_error = array();
    
    private static $error_text = array(
        101 => "Ошибка подключения к серверу Базы Данных",
        102 => "Ошибка подключения к Базе Данных",
        103 => "Ошибка подключения к Базе Данных12",
        104 => "Ошибка подключения к Базе Данных123",
    );
    
    
    public static function getError(){
        foreach (self::$_error as $value) {
            $result .= "<div> ! - " . self::$error_text[$value] . '</div>';
        }
        return $result;
    }
    
    public static function getCountError(){
        return count(self::$_error);
    }
    
    public static function getPageError($page) {
        $path_page = heretic::$_path['views'] . 'error/' . $page . '.php';
        if(is_readable($path_page)){
            $output = new viewsClass();
            $output->renderPage($path_page);
        }else{
            $page = 'template/error' . $page . '.php';
            include_once  $page;
            die();
        }
    }
    
}
