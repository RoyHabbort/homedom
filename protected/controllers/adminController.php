<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of administrationController
 *
 * @author Рой
 */
class adminController extends controllerClass {
    
    public function index() {
        
        heretic::$_config['titlePage'] = 'Административная панель';
        if(!empty($_SESSION['rules'])){
            if($_SESSION['rules'] == 4){
                $location = '/admin/page';
                header( "Location: {$location}", true, 303 );
            }
        }
        if(!empty($_POST)){
            $admin = new admin();
            $errors = $admin->loginAdmin($_POST);
            if (!$errors){
                $location = '/admin/page';
                header( "Location: {$location}", true, 303 );
            }else{
                $this->render('index', array('errors' => $errors));
                return false;
            }
        }

        $this->render('index');
            
        
    }
    
    
    public function rulesUsers(){
        if($_SESSION['rules'] != 4){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }else{
            
            heretic::$_config['titlePage'] = 'Административная панель';
            
            $admin = new admin();
            $allUsers = $admin->listUsers();
            
            $this->render('rulesUsers', array('allUsers' => $allUsers));
        }  
    }
    
    public function key(){
        if($_SESSION['rules'] != 4){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }else{
            
            heretic::$_config['titlePage'] = 'Административная панель';
            
            
            if(!empty($_POST)){
                
                $admin = new admin();
                $result = $admin->generateKey($_POST);
                
                if(!empty($result['errors'])){
                    $distr = $admin->getDistrKey();
                    $this->render('createUsers', array('errors' => $result['errors'], 'post' =>$_POST, 'distr_key' => $distr));
                }else{
                    $users = new users();
                    $date_user = $users->getPersonalInfo();
                    $mail = new mail();
                    $mail->sendMail('distribution', $date_user['email'], $date_user['fio'], array('key' => $result['key']));
                    
                    heretic::setFlash('success', 'Ключ сгенерирован и выслан на почту');
                    $location = '/admin/key';
                    header( "Location: {$location}", true, 303 );
                }
                
            }else{
                $admin = new admin();
                $distr = $admin->getDistrKey();
                
                $this->render('key', array('distr_key' => $distr));
            }
        }  
    }
    
   
    
    public function createUsers(){
        if($_SESSION['rules'] != 4){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }else{
            
            heretic::$_config['titlePage'] = 'Административная панель';
            
            if(!empty($_POST)){
                
                $admin = new admin();
                $errors = $admin->addUsers($_POST);
                
                if($errors){
                    $this->render('createUsers', array('errors' => $errors, 'post' =>$_POST));
                }else{
                    heretic::setFlash('success', 'Пользователь успешно создан');
                    $location = '/admin/rulesUsers';
                    header( "Location: {$location}", true, 303 );
                }
                
            }else{
               $this->render('createUsers'); 
            }
        }  
    }
    
    
    public function page($params){
        if($_SESSION['rules'] != 4){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }else{
            heretic::$_config['titlePage'] = 'Административная панель';
            if(!empty($params[0])){
                $page_model = new page();
                if(!empty($_POST)){
                    $result = $page_model->editPage($_POST, $params[0]);
                    if (empty($result['errors'])){
                        heretic::setFlash('success', 'Страница успешно обновлена');
                        $location = '/admin/page/'. $params[0];
                        header( "Location: {$location}", true, 303 );
                    }else{
                        $result_page = $page_model->getPage($params[0]);
                        if ($result){
                            $this->render('edit_page', array('result' => $result_page, 'errors' => $result['errors']));
                        }else{
                            errorClass::getPageError('404');
                        }
                    }
                }else{
                    $result = $page_model->getPage($params[0]);
                    if ($result){
                        $this->render('edit_page', array('result' => $result));
                    }else{
                        errorClass::getPageError('404');
                    }
                }
            }else{
              $this->render('page');  
            }
        }
    }
    

    public function blog($params){
        if($_SESSION['rules'] != 4){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }else{
            if(!empty($params[0])) $page = $params[0];
                else $page = 1;
            heretic::$_config['titlePage'] = 'Административная панель';
            $blog = new blog();
            $result = $blog->getBlog();
            $this->render('blog', array('result' => $result, 'page' => $page));
        }  
    }
    
    public function addBlog() {
        
        if($_SESSION['rules'] != 4){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }else{
            
            heretic::$_config['titlePage'] = 'Административная панель';
            $blog = new blog();
            if(!empty($_POST)){
                $result = $blog->addBlog($_POST);
                if(!empty($result['errors'])){
                    $this->render('addblog', array('errors' => $result['errors'], 'result'=> $_POST));
                }else{
                    heretic::setFlash('success', 'Запись успешно добавлена в блог');
                    $location = '/admin/blog';
                    header( "Location: {$location}", true, 303 );
                }
            }else{
              $this->render('addblog');  
            }
        }  
    }
    
    public function deleteBlog($params){
        if($_SESSION['rules'] != 4){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }
        
        if(empty($params)){
            errorClass::getPageError(404);
        }
        
        $idBlog = (integer) $params[0];
        heretic::$_config['titlePage'] = 'Административная панель';
        $blog = new blog();
        $result = $blog->DeleteBlog($idBlog);
        if($result){
            heretic::setFlash('success', 'Запись успешно удалена');
            $location = '/admin/blog';
            header( "Location: {$location}", true, 303 );
        }else{
            heretic::setFlash('errors', 'Удаление записи не удалось');
            $location = '/admin/blog';
            header( "Location: {$location}", true, 303 );
        }
        
    }
    
    
    public function editBlog($params){
        if($_SESSION['rules'] != 4){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }else{
            
            heretic::$_config['titlePage'] = 'Административная панель';
            $blog = new blog();
            if(!empty($_POST)){
                $result = $blog->editBlog($_POST, $params[0]);
                if(!empty($result['errors'])){
                    $result['result'] = $blog->getBlogId($params[0]);
                    $this->render('editBlog', array('errors' => $result['errors'], 'result'=> $result['result']));
                }else{
                    heretic::setFlash('success', 'Запись успешно изменена');
                    $location = '/admin/blog';
                    header( "Location: {$location}", true, 303 );
                }
            }else{
                $result = $blog->getBlogId($params[0]);
                if(empty($result)){
                    $location = '/admin/blog';
                    header( "Location: {$location}", true, 303 );
                }else{
                    $this->render('editBlog', array('result' => $result));     
                }
            }
            
        }
        
    }
        
    
    
    public function city(){
        
        if($_SESSION['rules'] != 4){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }else{
            heretic::$_config['titlePage'] = 'Административная панель';
            $admin = new admin();
            $city = $admin->getAllCity();
            
            $this->render('city', array('city' => $city));
        }
        
        
    }
    
    
    /*
     * 3-09-2014
     * Убираем удаление городов
    public function deleteCity($params){
        if($_SESSION['rules'] != 4){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }else{
            heretic::$_config['titlePage'] = 'Административная панель';
            $admin = new admin();
            $result = $admin->deleteCity($params[0]);
            if($result) {
                heretic::setFlash('success', 'Город удалён');
            }else{
                heretic::setFlash('error', 'Удалить город не получилось');
            }
            $location = '/admin/city/';
            header( "Location: {$location}", true, 303 );
        }
    }
    */
    
    
    public function createCity(){
        if($_SESSION['rules'] != 4){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }else{
            heretic::$_config['titlePage'] = 'Административная панель';
            $admin = new admin();
            if (!empty($_POST)){
                
                $errors = $admin->createCity($_POST);
                if (!empty($errors['errors'])) {
                    $this->render('createCity', array('errors' => $errors['errors'], 'post' => $_POST)); 
                }else{
                    heretic::setFlash('success', 'Город успшно создан');
                    $location = '/admin/city/';
                    header( "Location: {$location}", true, 303 );
                }
            }else{
               $this->render('createCity'); 
            }
        }
    }
    
    
    public function editCity($params){
        if($_SESSION['rules'] != 4){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }else{
            heretic::$_config['titlePage'] = 'Административная панель';
            if(empty($params[0])){
                errorClass::getPageError(404);
            }else{
             
                $admin = new admin();
                if (!empty($_POST)){
                    $errors = $admin->editCity($_POST, $params[0]);
                    if (!empty($errors)) {
                        $result = $admin->getCityId($params[0]);
                        $district = $admin->getDistrictId($params[0]);
                        $this->render('editCity', array('errors' => $errors, 'post' => $result, 'district' => $district)); 
                    }else{
                        heretic::setFlash('success', 'Город отредактирован');
                        $location = '/admin/city/';
                        header( "Location: {$location}", true, 303 );
                    }
                }else{
                   $result = $admin->getCityId($params[0]);
                   $district = $admin->getDistrictId($params[0]);
                   $this->render('editCity', array('post' => $result, 'district' => $district)); 
                }
                
            }
            
        }
    }

    
    public function keyGive(){
        if($_SESSION['rules'] != 4){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }else{
            
            if(!empty($_POST)){
                $admin = new admin();
                $result = $admin->rezervKey($_POST);
                if($result) heretic::setFlash('success', 'Раздача отредактирована');
                    else heretic::setFlash('error', 'При редактировании произошла ошибка');
                    
                
                $location = '/admin/key/';
                header( "Location: {$location}", true, 303 );
            }else{
                errorClass::getPageError(404);
            }
            
            
        }
    }
    
 
    
    
    public function billing(){
        if($_SESSION['rules'] < 3){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }
        
        heretic::$_config['titlePage'] = 'Администраторская панель';
        $moder = new moderation();
        $result = $moder->getUsersForBilling();
        
        $this->render('billing_ang', array('result' => $result));
    }
    
    
    
    public function loadBillingTable(){
        
        if($_SESSION['rules'] < 3){
            $location = '/';
            header( "Location: {$location}", true, 303 );
        }
        
        heretic::$_config['titlePage'] = 'Администраторская панель';
        $moder = new moderation();
        $result = $moder->getUsersForBilling();
        
        $this->partialRender('files/billing', array('result' => $result));
    }
    
    
    
}
