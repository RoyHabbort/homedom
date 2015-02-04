<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usersController
 *
 * @author Рой
 */
class usersController extends controllerClass {
    
    public function login() {
        
        heretic::$_config['titlePage'] = 'Вход';
        if(!empty($_POST)){
            $users = new users();
            $errors = $users->loginUsers($_POST);
            if (!$errors){
                    $location = '/users/';
                    header( "Location: {$location}", true, 303 ); 
                }else{
                    $this->render('login', array('errors' => $errors, 'phone' => $_POST['phone']));
                    return false;
                }
        }
        $this->render('login');
    }
    
    public function logout() {
        $users = new users();
        $users->logoutUsers();
        
        $location = '/';
        header( "Location: {$location}", true, 303 );
    }
    
    public function registration($params) {
        if(!empty($_SESSION['phone'])){
            $location = '/users/';
            header( "Location: {$location}", true, 303); 
        }else{
            heretic::$_config['titlePage'] = 'Регистрация';
            $object = new Object();
            $allCity = $object->getAllCity();
            if(empty($params[0])) $params[0] = '';
            if(!$params[0]=='success'){
                if(!empty($_POST)){
                    $users = new users();
                    $errors = $users->addUsers($_POST);
                    if (empty($errors)){
                        $location = '/users/registration/success';
                        header( "Location: {$location}", true, 303); 
                    }else{
                        $this->render('registr', array('errors' => $errors, 'post' => $_POST, 'all_city' => $allCity));
                        return false;
                    }
                }
                $this->render('registr', array('all_city' => $allCity));
            }else{
                $this->render('success');
            }
        }
    }
    
    
    public function index(){
        if (empty($_SESSION['phone'])){
            $location = '/users/login';
            header( "Location: {$location}", true, 303); 
        }else{
            heretic::$_config['titlePage'] = 'Личный кабинет';
            $object = new object();
            $result = $object->getUserObject();
            if(!empty($result)){
                foreach ($result as $key => $value) {
                    $result[$key]['count'] = $object->getCountFavorites($value['id']);
                    $result[$key]['browsing'] = $object->getCountBrowsing($value['id']);
                    $result[$key]['browsing_day'] = $object->getCountBrowsingDay($value['id']);
                    
                    
                    switch ($value['moderation']) {
                        
                        case '1': $result[$key]['moderation'] = 'Размещено'; $result[$key]['stat'] = 1; break;
                        case '0': $result[$key]['moderation'] = 'На модерации'; $result[$key]['stat'] = 0; break;
                        case '-1': $result[$key]['moderation'] = 'Заблокировано модератором. Требует редактирования.'; $result[$key]['color'] = 'red'; $result[$key]['stat'] = -1; break;
                        case '-2': $result[$key]['moderation'] = 'Временно снято с продажи'; $result[$key]['color'] = 'red'; $result[$key]['stat'] = -2; break;
                        default: $result[$key]['moderation'] = 'На модерации'; $result[$key]['stat'] = 0; break;
                    }
                    
                }
            }
            
            $this->render('index', $result);
        }
    }
    
    public function favorites($params){
        if (empty($_SESSION['phone'])){
            $location = '/users/login';
            header( "Location: {$location}", true, 303); 
        }else{
            if(empty($params[0])){
                heretic::$_config['titlePage'] = 'Личный кабинет';

                $object = new object();
                $result = $object->getUserFavorites();
                
                if ($result){
                    $this->render('favorites', $result);
                    return true;
                }
                $this->render('favorites');
            }else{
                $id = $params[0];
                $object = new object();
                $object->removeFavorites($id);
                $location = '/users/favorites';
                header( "Location: {$location}", true, 303); 
            }    
        }
    }
    
    
    
    public function schedule($params){
        if (empty($_SESSION['phone'])){
            $location = '/users/login';
            header( "Location: {$location}", true, 303); 
        }else{
            heretic::$_config['titlePage'] = 'Личный кабинет';
            $object = new object();
            
            
            $result = $object->getUserObject();
            $mySchedule = $object->getMySchedule();
            $schedule = $object->getScheduleAll();

            $this->render('schedule', array('result' =>$result, 'schedule' => $schedule, 'mySchedule' => $mySchedule)); 
            
        }
    }
    
    
    
    public function personal($params){
        if (empty($_SESSION['phone'])){
            $location = '/users/login';
            header( "Location: {$location}", true, 303); 
        }else{
            heretic::$_config['titlePage'] = 'Личный кабинет';
            $user = new users();
            $object = new object();
            $allCity = $object->getAllCity();
            if(!empty($_POST)){
                $result = $user->editUser($_POST);
                if (empty($result['errors'])){
                    $location = '/users/personal/success';
                    header( "Location: {$location}", true, 303); 
                }else{
                    $error = $result['errors'];
                    $result = $user->getPersonalInfo();
                    $this->render('personal', array('result'=> $result, 'errors' => $error, 'all_city' => $allCity));
                }
            }else{
                $success='';
                if(!empty($params[0])){
                    if($params[0]='success'){
                        $success = 'Личные данные успешно обновлены';
                    }
                }
                $result = $user->getPersonalInfo();

                $this->render('personal', array('result' => $result, 'success'=>$success, 'all_city' => $allCity)); 
            }
            
        }
    }
    
    public function code(){
        if (empty($_SESSION['phone'])){
            $location = '/users/login';
            header( "Location: {$location}", true, 303); 
        }else{
            heretic::$_config['titlePage'] = 'Личный кабинет';
//            if(!empty($_POST)){
//                $users = new users();
//                $result = $users->generateCode($_POST);
//                $date_user = $users->getPersonalInfo();
//                if (empty($result['errors'])){
//                    if($_POST['type_receive'] == 'Email') {
//                        $compil = 2;
//                        $mail = new mail();
//                        $mail->sendMail('distribution', $date_user['email'], $date_user['fio'], array('key' => $result['key']));
//                    }else{
//                        $compil = 3;
//                    }
//                    $location = '/users/complite/' . $compil;
//                    header( "Location: {$location}", true, 303);
//                }
//                $this->render('code', array('errors'=> $result['errors']));
//            }
            
            $this->render('code');
        }
    }
    
    public function complite($params){
        if (empty($_SESSION['phone'])){
            $location = '/users/login';
            header( "Location: {$location}", true, 303); 
        }else{
            heretic::$_config['titlePage'] = 'Личный кабинет';
            $text = '';
            if(!empty($params[0])){
                switch ($params[0]) {
                    case 1: $text = ''; break;
                    case 2: $text = 'Код доступа отправлен на ваш электронный адрес. Активируйте его в Личном кабинете. '; break;
                    case 3: $text = 'Ваш код выслан на ваш номер телефона'; break;    
                    case 4: $text = 'Ваш код успешно активирован'; break;    
                    case 5: $text = 'Активировать код не удалось'; break;    
                    default:
                        $text = '';
                        break;
                }
            }
            $this->render('complite', array('text'=>$text));
        }
    }

    
    
    private function itIsMyObject($params){
        
        if(!empty($params[0])){
            $id = $params[0];
            $object = new object();
            $result = $object->itIsMyObject($id);
            if(!$result){
                $location = '/users/login';
                header( "Location: {$location}", true, 303);  
            }
            
        }else{
            $location = '/users/login';
            header( "Location: {$location}", true, 303); 
        }
    }
    
    public function object($params){
        
        if (empty($_SESSION['phone'])){
            $location = '/users/login';
            header( "Location: {$location}", true, 303); 
        }else{
            
            $this->itIsMyObject($params);
            
            heretic::$_config['titlePage'] = 'Личный кабинет';
            if(!empty($params[0])){
                
                $id = $params[0];
                $object = new object();
                
                if(!empty($_POST)){
                    $result = $object->editObject($_POST, $params[0]);
                    if(empty($result['errors'])){
                        $location = '/users/object/'.$id.'/success';
                        header( "Location: {$location}", true, 303); 
                    }else{
                        $errors = $result['errors'];
                        $result=$object->getUserObjectId($id);
                        $params_add = $object->getParamsAdd();
                        $params_add['district'] = $object->getDistrict($result['city']);
                        $this->render('object', array('result'=> $result, 'errors' => $errors, 'params_add' => $params_add)); 
                    }
                }else{
                    $result=$object->getUserObjectId($id);
                    $params_add = $object->getParamsAdd();
                    $params_add['district'] = $object->getDistrict($result['city']);
                    $success = '';
                    if(!empty($params[1])){
                        if($params[1] == "success") $success = "Объявление успешно обновленно";
                    }
                    $this->render('object', array('result' => $result, 'params_add' => $params_add, 'success' => $success)); 
                }
            }else{
                $this->render('object');    
            }
        }
    }
    
    
    public function activate(){
        if (empty($_SESSION['phone'])){
            $location = '/users/login';
            header( "Location: {$location}", true, 303); 
        }else{
            if(!empty($_POST)){
                $users = new users();
                $result = $users->activateCode($_POST);
                if($result) $location = '/users/complite/4';
                    else $location = '/users/complite/5';
                header( "Location: {$location}", true, 303);
            }else{
                $location = '/users';
                header( "Location: {$location}", true, 303); 
            }
        }
    }
    
    
    
    public function upload($params){
        
        if(!empty($params[0])){
            $moder = new moderation();
            $result = $moder->uploadImage($params[0]);
            if(!empty($result)){
                heretic::setFlash('errors', 'Ошибка загрузки фотографии');
            }else{
                heretic::setFlash('success', 'Фотография загружена');
            }
            $location = '/users/object/'.$params[0];
            header( "Location: {$location}", true, 303 );
        }else{
            errorClass::getPageError(404);
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
                
                $location = '/users/object/'.$params[0];
                header( "Location: {$location}", true, 303 );
            }else{
               errorClass::getPageError(404); 
            }

        }else{
            errorClass::getPageError(404);
        }
        
    }
    
    
    
    public function deleteObject(){
        
        if(empty($_SESSION['phone'])){
            $location = '/users/login';
            header( "Location: {$location}", true, 303); 
        }
        
        $object = new object();
        $result = $object->deleteObject($_POST);
        
        if($result){
            heretic::setFlash('success', 'Объявление удалено');
        }else{
            heretic::setFlash('errors', 'Ошибка удаления объявления');
        }
        
        $location = '/users/';
        header( "Location: {$location}", true, 303 );
        
    }
    
    
    public function removeObject(){
        
        if(empty($_SESSION['phone'])){
            $location = '/users/login';
            header( "Location: {$location}", true, 303); 
        }
        
        $object = new object();
        $result = $object->removeObject($_POST);
        
        if($result){
            heretic::setFlash('success', 'Объявление снято');
        }else{
            heretic::setFlash('errors', 'Ошибка действия');
        }
        
        $location = '/users/';
        header( "Location: {$location}", true, 303 );
        
    }
    
    
    public function moveObject(){
        
        if(empty($_SESSION['phone'])){
            $location = '/users/login';
            header( "Location: {$location}", true, 303); 
        }
        
        $object = new object();
        $result = $object->moveObject($_POST);
        
        if($result){
            heretic::setFlash('success', 'Объявление возвращено на модерацию');
        }else{
            heretic::setFlash('errors', 'Ошибка действия');
        }
        
        $location = '/users/';
        header( "Location: {$location}", true, 303 );
        
    }
    
    
    
}
