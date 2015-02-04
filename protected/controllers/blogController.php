<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of blogController
 *
 * @author Рой
 */
class blogController extends controllerClass {

    public function index($params){
        
        $model = new page();
        $result = $model->getPage(7);
        
        heretic::$_config['titlePage'] = $result['title'];
        
        if(!empty($params[0])) $page = $params[0];
            else $page = 1;
        
        $blog = new Blog();
        $result = $blog->getBlog();
        $page_name = 'Все';
        $this->render('index', array('result' => $result, 'page' => $page, 'page_name' => $page_name));
        
    }
    
    public function buyer($params){
        
        $model = new page();
        $result = $model->getPage(7);
        
        heretic::$_config['titlePage'] = $result['title'];
        
        if(!empty($params[0])) $page = $params[0];
            else $page = 1;
        
        $type = 'buyer';   
        $page_name = 'Покупателю';
        $blog = new Blog();
        $result = $blog->getBlog($type);
        
        $this->render('index', array('result' => $result, 'type' => $type, 'page' => $page, 'page_name' => $page_name));
        
    }
    
    public function seller($params){
        
        $model = new page();
        $result = $model->getPage(7);
        
        heretic::$_config['titlePage'] = $result['title'];
        
        if(!empty($params[0])) $page = $params[0];
            else $page = 1;
        
        $type = 'seller';
        $page_name = 'Продавцу';
        $blog = new Blog();
        $result = $blog->getBlog($type);
        
        $this->render('index', array('result' => $result, 'type' => $type, 'page' => $page, 'page_name' => $page_name));
        
    }
    
    public function tenant($params){
        
        $model = new page();
        $result = $model->getPage(7);
        
        heretic::$_config['titlePage'] = $result['title'];
        
        if(!empty($params[0])) $page = $params[0];
            else $page = 1;
        
        $type = 'tenant';   
        $page_name = 'Арендатору';
        $blog = new Blog();
        $result = $blog->getBlog($type);
        
        $this->render('index', array('result' => $result, 'type' => $type, 'page' => $page, 'page_name' => $page_name));
        
    }
    
    public function landlord($params){
        
        $model = new page();
        $result = $model->getPage(7);
        
        heretic::$_config['titlePage'] = $result['title'];
        
        if(!empty($params[0])) $page = $params[0];
            else $page = 1;
        
        $type = 'landlord';    
        $page_name = 'Арендодателю';
        $blog = new Blog();
        $result = $blog->getBlog($type);
        
        $this->render('index', array('result' => $result, 'type' => $type, 'page' => $page, 'page_name' => $page_name));
        
    }
    
    public function view($params){
        if(!empty($params[0])){
            heretic::$_config['titlePage'] = 'Блог';
            $blog = new blog();
            $result = $blog->getBlogId($params[0]);
            if(!empty($result)) $this->render('blog', array('result' => $result));
                else errorClass::getPageError (404);
        }else{
            errorClass::getPageError(404);
        }
    }
    
}
