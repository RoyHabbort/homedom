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
class objectsController extends controllerClass{
    
    
    public function index(){
        
        heretic::$_config['titlePage'] = 'Объекты';
        errorClass::getPageError(404);
    }
    
    public function addObject($params){
        $page = new page();
        $result = $page->getPage(6);
        $object = new object();
        $params_add = $object->getParamsAdd();
        $allCity = $object->getAllCity();
        heretic::$_config['titlePage'] = $result['title'];
        
        if(!empty($_POST)){
            
            
            $object = new object();
            $result = $object->addObjects($_POST);
            if (empty($result['errors'])){
                $users = new users();
                if (!empty($_SESSION['phone'])) $date_user = $users->getPersonalInfo();
                $mail = new mail();
                $mail->sendMail('notice', 'homedom.ru@mail.ru', 'Homedom', array('last_id' => $result['last_id']));
                $mail->sendMail('object', $date_user['email'], $date_user['fio'], array('last_id' => $result['last_id']));
                $location = '/objects/object/' . $result['last_id'];
                header( "Location: {$location}", true, 303); 
            }else{
                $params_add['district'] = $object->getDistrict($_POST['city']);
                $this->render('addObject', array('errors' => $result['errors'], 'post' => $_POST, 'params_add' => $params_add));
                return false;
            }
        }
        $this->render('addObject', array('params_add' => $params_add, 'all_city' => $allCity)); 
        
    }
    
    public function search($params){
        if(empty($params[0])){
            unset($_SESSION['postSearch']);
            $page = 1;
            heretic::$_config['titlePage'] = 'Объекты';
            $object = new object();
            //$result = $object->getAllObjectByFilter();
            $params_add = $object->getParamsAdd();
            if(!empty($_SESSION['phone'])){
                $code_accept = $object->accessCategory();
                
                if(!empty($_SESSION['rules'])){
                    if($_SESSION['rules'] >= 3){
                        $code_accept = true;
                    }
                }
            }else{
                $code_accept = false;
            }
            if (!empty($_SESSION['postSearch']['city']))
                $params_add['district'] = $object->getDistrict($_SESSION['postSearch']['city']);
            $this->render('index', array( 'params_add' => $params_add, 'page' => $page, 'code_accept' => $code_accept));
        }else{
            if (strlen($params[0])>2) {
                $category = $params[0];
                if (!empty($params[1])) $page = $params[1];
                    else $page = 1;
            }else{
                $category = '';
                $page = (integer) $params[0];
            }
            
            $object = new object();
            $result = $object->getAllObjectByFilter($category);
            $params_add = $object->getParamsAdd();
            if(!empty($_SESSION['phone'])){
                $code_accept = $object->accessCategory($category);
                
                if(!empty($_SESSION['rules'])){
                    if($_SESSION['rules'] >= 3){
                        $code_accept = true;
                    }
                }
            }else{
                $code_accept = false;  
            }
            
            if (!empty($_SESSION['postSearch']['city']))
                $params_add['district'] = $object->getDistrict($_SESSION['postSearch']['city']);
            
            $this->render('index', array('result' => $result, 'category' => $category, 'params_add' => $params_add, 'page' => $page, 'code_accept' => $code_accept));
        }
        
    }
    
    public function object($params){
        
        if(empty($params[0])){
            $location = '/objects/search/';
            header( "Location: {$location}", true, 303);
        }else{
            $id = $params[0];
            if(!empty($_POST['action'])){
                $object = new object();
                if($_POST['action'] == 'add') $object->addFavorites ($id);
                    elseif($_POST['action'] == 'remove') $object->removeFavorites($id);
                    
                $location = '/objects/object/' . $id;
                header( "Location: {$location}", true, 303);     
                   
            }else{
                heretic::$_config['titlePage'] = 'Поиск квартир';
                $object = new object();
                $result = $object->getObject($id);
                $result['count'] = $object->getCountFavorites($id);
                $result['browsing'] = $object->getCountBrowsing($id);
                $result['browsing_day'] = $object->getCountBrowsingDay($id);
                
                if(empty($result['category'])) errorClass::getPageError('404');
                else {
                    if(!empty($_SESSION['phone'])) {
                        if ($result['phone'] == $_SESSION['phone']) $ifCode = true;
                            else $ifCode = $object->accessObject($id);
                        $favorites = $object->ifFavorites($id);
                        $result['favorites'] = $favorites;
                    }else $ifCode = false;
                
                    $this->render('object', array('result'=>$result, 'ifCode' => $ifCode));
                }
                
            }
            
        }
        
    }
    
    
    public function postSearch(){
        $model = new object();
        $model->postSearch($_POST);
        
        $location = '/objects/search/' . $_SESSION['postSearch']['category'];
        header( "Location: {$location}", true, 303);
    }
    
}
