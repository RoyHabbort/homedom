<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ьфвукфешщтСщтекщддук
 *
 * @author Рой
 */
class moderationController extends controllerClass {
    
    
    public function index(){
    
        heretic::$_config['titlePage'] = 'Модераторская панель';
        if(!empty($_SESSION['rules'])){
            if($_SESSION['rules'] >= 3){
                $location = '/moderation/listObject';
                header( "Location: {$location}", true, 303 );
            }
        }
        if(!empty($_POST)){
            $moderation = new moderation();
            $errors = $moderation->loginModer($_POST);
            if (!$errors){
                $location = '/moderation/listObject';
                header( "Location: {$location}", true, 303 );
            }else{
                $this->render('index', array('errors' => $errors));
                return false;
            }
        }

        $this->render('index');
        
    }    
    
    
    public function main(){
        
        if($_SESSION['rules'] < 3){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }else{
            
            heretic::$_config['titlePage'] = 'Модераторская панель';
            
            
            
            $this->render('main');
        }  
        
    }
    
    public function listObject($params){
        
        if($_SESSION['rules'] < 3){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }else{
            
            heretic::$_config['titlePage'] = 'Модераторская панель';
            if(!empty($params[0])) $page = $params[0];
                else $page = 1;
            
            $moder = new moderation();
            $result = $moder->listObject();
            $object = new object();
            $params_add = $object->getParamsAdd();
            $this->render('listObject', array('result' => $result, 'page' => $page));
        }  
        
    }
    
    
    
    
    public function banList($params){
        
        if($_SESSION['rules'] < 3){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }else{
            
            if (!empty($params[0])) $page = $params[0];
                else $page=1;
            
            heretic::$_config['titlePage'] = 'Модераторская панель';
            
            $filter = '';
            if(!empty($_POST)) $filter = $_POST['phone'];
            
            $moder = new moderation();
            $result = $moder->getUsersByFilter($filter);
            $result['page'] = $page;
            $this->render('banlist', $result);
        }  
        
    }
    
    public function editNews($params){
        
        if($_SESSION['rules'] < 3){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }else{
            
            heretic::$_config['titlePage'] = 'Модераторская панель';
            
            if (!empty($params[0])) $page = $params[0];
                else $page=1;
            
            $moder = new moderation();
            $result = $moder->getNews();
            
            $this->render('editnews', array('result'=>$result, 'page'=> $page));
        }  
        
    }
    
    
    public function deleteNews($params){
        if($_SESSION['rules'] < 3){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }
        
        if(empty($params)){
            errorClass::getPageError(404);
        }
        
        $idNews = (integer) $params[0];
        heretic::$_config['titlePage'] = 'Модераторская панель';
        $moder = new moderation();
        $result = $moder->DeleteNews($idNews);
        if($result){
            heretic::setFlash('success', 'Новость успешно удалена');
            $location = '/moderation/editnews';
            header( "Location: {$location}", true, 303 );
        }else{
            heretic::setFlash('errors', 'Удаление Новости не удалось');
            $location = '/moderation/editnews';
            header( "Location: {$location}", true, 303 );
        }
    }
    
    
    public function newseditpage($params){
        
        if($_SESSION['rules'] < 3){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }else{
            heretic::$_config['titlePage'] = 'Модераторская панель';
            if (!empty($params[0])){
                $add = false;
                $moder = new moderation();
                if(!empty($_POST)){
                    
                    $result = $moder->editNews($_POST, $params[0]); 
                    if (!empty($result['errors'])){
                        $result['result'] = $moder->getNewsId($params[0]);
                        $this->render('newspage', array('result'=> $result['result'],'errors'=>$result['errors'], 'add'=>$add));
                    }else{
                        heretic::setFlash('success', 'Новость обновлена');
                        $location = '/moderation/editnews/';
                        header( "Location: {$location}", true, 303 );
                    }
                    
                }else{
                    
                    $result['result'] = $moder->getNewsId($params[0]);
                    if($result){
                        $this->render('newspage', array('result'=>$result['result'], 'add'=>$add));
                    }else{
                        errorClass::getPageError('404');
                    }
                }
                
            }else{
                errorClass::getPageError('404');
            }
            
        } 
        
    }
    
    
    public function addNews(){
        
        if($_SESSION['rules'] < 3){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }else{
            heretic::$_config['titlePage'] = 'Модераторская панель';
            $add = true;
            $moder = new moderation();
            if(!empty($_POST)){
                $result = $moder->addNews($_POST); 
                if (!empty($result['errors'])){
                    $this->render('newspage', array('post'=> $_POST,'errors'=>$result['errors'], 'add' => $add));
                }else{
                    $mail = new mail();
                    $mail->sendMailAll('news', array('post' => $_POST, 'last_id' => $result['last_id']));
                    heretic::setFlash('success', 'Новость добавлена');
                    $location = '/moderation/editNews/';
                    header( "Location: {$location}", true, 303 );
                }
            }else{
                $this->render('newspage', array('add' => $add));
            }
            
        }
        
    }
    
    public function object($params){
        
        if($_SESSION['rules'] < 3){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }else{
            heretic::$_config['titlePage'] = 'Модераторская панель';
            if (!empty($params[0])){
                $moder = new moderation();
                $object = new object();
                
                $all_object = $object->getObjectUser($params[0]);
                
                $result = $moder->getObjectId($params[0]);
                $params_add = $object->getParamsAdd();
                $params_add['district'] = $object->getDistrict($result['city']);
                if(isset($_POST['save'])){
                        $saveEdit = $object->editObject($_POST, $params[0]);
                        if(empty($saveEdit['errors'])){
                            
                            $compile = $moder->moderObject($params[0]);
                            if($compile){
                                heretic::setFlash('success', 'Объявление одобрено');
                                $location = '/moderation/listObject/';
                                header( "Location: {$location}", true, 303 );
                            }else{
                          
                                if($result){
                                    $this->render('editObject', array('result'=>$result, 'params_add' => $params_add, 'all_object' => $all_object, 'errors'=>array('sql_error'=> 'Ошибка. Одобрить не удалось.')));
                                }else{
                                    errorClass::getPageError('404');
                                }
                            }
                            
                        }else{
                            $this->render('editObject', array('result'=>$result, 'params_add' => $params_add, 'errors'=> $saveEdit['errors'], 'all_object' => $all_object));
                        }
                        
                }else{
                    if($result){
                        $this->render('editObject', array('result'=>$result, 'params_add' => $params_add, 'all_object' => $all_object));
                    }else{
                        errorClass::getPageError('404');
                    }
                }
            }else{
                errorClass::getPageError('404');
            }
            
        } 
        
    }
    
    
    public function banObject($params){
        
        if($_SESSION['rules'] < 3){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }else{
            
            heretic::$_config['titlePage'] = 'Модераторская панель';
            if (!empty($params[0])){
                if(isset($_POST['ban'])){
                    $moder = new moderation();
                    $result = $moder->banObject($params[0]);
                    
                    if($result){
                        heretic::setFlash('success', 'Объявление забанено');
                        $location = '/moderation/listObject/';
                        header( "Location: {$location}", true, 303 );
                    }else{
                        heretic::setFlash('error', 'Действие не удалось');
                        $location = '/moderation/object/' . $params[0];
                        header( "Location: {$location}", true, 303 );
                    }
                    
                }else{
                    errorClass::getPageError('404');    
                }
            }else{
                errorClass::getPageError('404');
            }
        }
    }
    
    
    public function deletePhoto($params){
        
        if(!empty($params[0])){
            $moder = new moderation();
            if (isset($_POST['photo_id'])){
                $result = $moder->deletePhoto($_POST['photo_id']);
                if(!empty($result)){
                    heretic::setFlash('errors', 'Ошибка удаления фотографии');
                }else{
                    heretic::setFlash('success', 'Фотография удалена');
                }
                
                $location = '/moderation/object/'.$params[0];
                header( "Location: {$location}", true, 303 );
            }else{
               errorClass::getPageError(404); 
            }

        }else{
            errorClass::getPageError(404);
        }
        
    }
    
    
    
    public function otvetPage(){
        
        if($_SESSION['rules'] < 3){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }
        
        heretic::$_config['titlePage'] = 'Модераторская панель';
        $moder = new moderation();
        $result = $moder->otvetCount();
        
        $this->render('otvet', array('result' => $result));
    }
    
    
    
}
