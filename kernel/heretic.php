<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of heretic
 *
 * @author Рой
 */
class heretic {
    
    public static $_path = array();
    public static $_config = array();
    public static $_script = array();
    public static $_link = array();
    
    
    public static function dateDotted($date){
        
        $array = explode(' ', $date);
        $date = $array[0];


        $date_split = explode('-', $date);

        $year = $date_split[0];
        $month = $date_split[1];
        $day = $date_split[2];
        $result = $day . '.' . $month . '.' . $year; 
        
        return $result;
        
    }




    public static function connect($path, $condition){
    
        $dir = $path;
        if(is_dir($dir)) {

            $files = scandir($dir);

            array_shift($files); // удаляем из массива '.'
            array_shift($files); // удаляем из массива '..'
            foreach ($files as $key => $value) {
                if (substr_count($value, $condition)) include_once $dir . $value;
            }
        }
        
    }
    
    public static function Widget($name, $arguments = array()){

            $file = heretic::$_path['widget'] . $name . '/' . $name . 'Widget.php';
            $class = $name . 'Widget'; 
            if (!is_readable($file)){
                return false;
            }else{
               include $file;

               $widget = new $class;
               $widget->index($arguments);
               return true;
            }
      }
      
      public static function previewText($text = '', $length = 500){
        $text = strip_tags($text);
        return self::cropText($text, $length); 
      }
      
      public static function cropText($string, $length){
        $result = implode(array_slice(explode('<br>',wordwrap($string,$length,'<br>',false)),0,1));
        if($result!=$string) {
            if ($result[mb_strlen($result) - 1] == '.' || $result[mb_strlen($result) - 1] == ',') $result = substr($result, 0, strlen($result)-1);
            $result .= '...';
        }    
        return $result;
      }
      
      public static function cout($params){
          if(!empty($params)) return $params;
            else return NULL;
      }
      
      public static function setFlash($name, $value){
          $_SESSION[$name] = $value;
      }
      
      public static function getFlash($name){
          if (!empty($_SESSION[$name])) {
              $return = $_SESSION[$name];
              heretic::destroyFlash($name);
              return $return;
          } else return NULL;
      }
      
      public static function destroyFlash($name){
          if (!empty($_SESSION[$name])) unset($_SESSION[$name]);
      }
    
}
