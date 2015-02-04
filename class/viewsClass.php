<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of viewsClass
 *
 * @author Рой
 */
class viewsClass {
    
    function __construct() {
        if ((heretic::$_config['debug']) && errorClass::getCountError()) {
            echo "<strong>Текущая ошибка:</strong>" . errorClass::getError();
        }
    }

    public function renderPage($page, $arguments = '') {
        
        include_once heretic::$_path['template'] . 'inner.php';
        include_once heretic::$_path['template'] . 'head.php';
        include_once heretic::$_path['template'] . 'header.php';

        /***********WORK PLACE****************/
        
        if (is_readable($page) == false) {
            errorClass::getPageError('404');
        }else{
            include $page;
        }
        
        include_once heretic::$_path['template'] . 'footer.php';
        
    }
    
    public function partialRenderPage($page, $arguments = '') {
        
        if (is_readable($page) == false) {
            errorClass::getPageError('404');
        }else{
            include $page;
        }
        
    }
    
    
    public function converteDate($date, $type = 'date'){
        
        $array = explode(' ', $date);
        $date = $array[0];
        
        
        $date_split = explode('-', $date);
        
        $year = $date_split[0];
        $month = $date_split[1];
        $day = $date_split[2];
        
        switch ($month) {
            case '01': $month = 'января'; break;
            case '02': $month = 'февраля'; break;
            case '03': $month = 'марта'; break;
            case '04': $month = 'апреля'; break;
            case '05': $month = 'мая'; break;
            case '06': $month = 'июня'; break;
            case '07': $month = 'июля'; break;
            case '08': $month = 'августа'; break;
            case '09': $month = 'сентября'; break;
            case '10': $month = 'октября'; break;
            case '11': $month = 'ноября'; break;
            case '12': $month = 'декабря'; break;
            default: $month = 'января'; break;
        }
        
        $result = $day . ' ' . $month . ' ' . $year;
        if ($type == 'dateTime') {
            $time = $array[1];
            $time = substr($time, 0, 5);
            $result = $result . ' в ' . $time;
        }
        return $result;
        
    }
    
    
    public function smarty_modifier_string_declination($numeric, $many="объявлений", $one="объявление", $two="объявления"){
        
        $numeric = (int) abs($numeric);
        if (($numeric % 100 == 1) || ($numeric % 100 > 20) && ($numeric % 10 == 1)){
            return $one;
        }
        elseif (($numeric % 100 == 2) || ($numeric % 100 > 20) && ($numeric % 10 == 2)){
            return $two;
        }
        elseif (($numeric % 100 == 3) || ($numeric % 100 > 20) && ($numeric % 10 == 3)){
            return $two;
        }
        elseif (($numeric % 100 == 4) || ($numeric % 100 > 20) && ($numeric % 10 == 4)){
            return $two;
        }
        else {
            return $many;
        }
    }
    
    
    public function smarty_modifier_sum_convert($string, $format="int"){
	
	if ($format == "int") {
		return intval($string);
	}
	if ($format == "float") {
		$string = str_replace(",",".",$string);
		return floatval($string);
	}
	if ($format == "digit") {
		return number_format($string, 0, "," ," ");
	}
	if ($format == "summa") {
        return number_format($string,0,","," ")." <span class='rur'>руб.</span>";
	}
        if ($format == "float_summa") {
        return number_format($string,2,","," ")." <span class='rur'>руб.</span>";
        }
    }
    
    
    
}
