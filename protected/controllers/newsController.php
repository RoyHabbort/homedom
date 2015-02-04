<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newsController
 *
 * @author Рой
 */
class newsController extends controllerClass {
    
    
    public function lists($params) {
        
        if(empty($params[0])) $page=1;
            else $page = (integer) $params[0];
        
        $model = new page();
        $result = $model->getPage(4);
        
        $news = new news();
        $all_news = $news->getAllNews();
        
        heretic::$_config['titlePage'] = 'Новости';
        
        $this->render('index', array('result' => $result, 'page' => $page, 'all_news' => $all_news));
        
    }
    
    public function news($params){
        $model = new news();
        $new = $model->getNew($params[0]);
        
        heretic::$_config['titlePage'] = 'Новости';
        
        
        if ($new){
            $this->render('new', $new);
        }else{
            errorClass::getPageError('404');
        }
        
        
    }
    
}
