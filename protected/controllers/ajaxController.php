<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ajaxController
 *
 * @author Рой
 */
class ajaxController extends controllerClass{
    
    public function viewDistrict($city){
        
        if (!empty($_POST)){
            $object = new object();
            $result = $object->getDistrict($_POST['city']);
            echo json_encode($result);
        }
        else echo NULL;
        
    }
    
    public function timeSchedule(){
        if (!empty($_POST)){
            
            $object = new object();
            
            
            $ifCode = false;
            if(!empty($_SESSION['phone'])) {
                $ifCode = $object->accessObject($_POST['id']);
            }else $ifCode = false;
            
            
            if ($ifCode){
                
                $result = $object->addClientSchedule($_POST);
                $for_sms = $object->getInfoSMS($_POST);
                $for_sms['time'] = substr($_POST['time'], 0, 16);
                $mail = new mail();
                $mail->sendSMS('schedule', $for_sms['phone'], array('data' => $for_sms));
                echo json_encode($result);
                
            }else{
                $result = array('dostup' => 'no');
                echo json_encode($result);
            }
            
        }
        else echo NULL;
    }
    
    public function rulesSave(){
        if($_SESSION['rules'] != 4){
            echo NULL;
        }else{
            if (!empty($_POST)){
                $admin = new admin();
                $result = $admin->setRules($_POST);
                echo json_encode($result);
            }
            else echo NULL;
        }
    }
    
    public function banfunc(){
        if($_SESSION['rules'] < 3){
            echo NULL;
        }else{
            if (!empty($_POST)){
                $moder = new moderation();
                $result = $moder->setban($_POST);
                echo json_encode($result);
            }
            else echo NULL;
        }
    }
    
    
    public function getCoord(){
        if (!empty($_POST)){
            $object = new object();
            $result = $object->getCoord($_POST);
            echo json_encode($result);
        }
        else echo NULL;
    }
    
    
    public function setCoord(){
        if (!empty($_POST)){
            $object = new object();
            $result = $object->setCoord($_POST);
            echo json_encode($result);
        }
        else echo FALSE;
    }
    
    
    public function ifSchedule(){
        if (!empty($_POST)){
            $object = new object();
            $result = $object->ifSchedule($_POST);
            echo json_encode($result);
        }
        else echo NULL;
    }
    
    public function addDistrict(){
        if($_SESSION['rules'] != 4){
            echo NULL;
        }else{
            if (!empty($_POST)){
                $admin = new admin();
                $result = $admin->addDistrict($_POST);
                echo json_encode($result);
            }
            else echo NULL;
        }
    }
    
    public function deleteDistrict(){
        if($_SESSION['rules'] != 4){
            echo NULL;
        }else{
            if (!empty($_POST)){
                $admin = new admin();
                $result = $admin->deleteDistrict($_POST);
                echo json_encode($result);
            }
            else echo NULL;
        }
    }
    
    public function postSearch(){
        
        $model = new object();
        $result = $model->postSearch($_POST);
        echo json_encode($result);
    }
    
    
    public function AjaxSearch(){
        
        $model = new object();
        $access_cat = $model->accessCat($_SESSION['postSearch']['category']);
        
        if($access_cat){
            $result = $model->getAllObjectByFilter();
            echo json_encode($result);
        }else{
            echo FALSE;
        }
        
        
    }
    
    public function uploadFile(){
        
        $model = new object();
        $result = $model->uploadFile();
        
        echo json_encode($result);
        
    }
    
    
    public function deleteUser(){
        
        if($_SESSION['rules'] <3){
            return false;
        }
        
        $moder = new moderation();
        $result = $moder->deleteUser($_POST);
        
        echo $result;
        
    }
    
    
    public function getCoordCity(){
        if(!empty($_POST)){
            
            $model = new object();
            $result = $model->getCoordByCity($_POST);
            if($result){
                echo json_encode($result);
            }else echo false;
            
        }else{
            echo false;
        }
    }
    
    
    public function addAdminComment(){
        if($_SESSION['rules'] != 4){
            $result = array('errors' => 'Ошибка прав доступа!');
            echo json_encode($result);
            return false;
        }else{
            
            
            if (!empty($_POST)){
                $admin = new admin();
                $result = $admin->addAdminComment($_POST);
                echo json_encode($result);
            }
            else{
                $result = array('errors' => 'Неверный формат данных');
                echo json_encode($result);
                return false;
            }    
        }
    }
    
    
    public function addAdminStatus(){
        if($_SESSION['rules'] != 4){
            $result = array('errors' => 'Ошибка прав доступа!');
            echo json_encode($result);
            return false;
        }else{
            
            
            if (!empty($_POST)){
                $admin = new admin();
                $result = $admin->addAdminStatus($_POST);
                echo json_encode($result);
            }
            else{
                $result = array('errors' => 'Неверный формат данных');
                echo json_encode($result);
                return false;
            }    
        }
    }
    
    
    public function deleteUserBilling(){
        if($_SESSION['rules'] != 4){
            $result = array('errors' => 'Ошибка прав доступа!');
            echo json_encode($result);
            return false;
        }else{
            
            
            if (!empty($_POST)){
                $moder = new moderation();
                $result = $moder->deleteUserBilling($_POST);
                echo json_encode($result);
            }
            else{
                $result = array('errors' => 'Неверный формат данных');
                echo json_encode($result);
                return false;
            }    
        }
    }
    
    
    public function getAllUsers(){
        if($_SESSION['rules'] < 4){
            return false;
        }
        
        $model = new billing();
        $result = $model->getAllUsers();
        echo json_encode(array('success' => 'Список пользователей получен', 'users' => $result));
    }
    
    
    public function getAllCities(){
        if($_SESSION['rules'] <3){
            return false;
        }
        
        $model = new billing();
        $result = $model->getAllCities();
        echo json_encode(array('success' => 'Список пользователей получен', 'cities' => $result));
        
    }
    
    
    
    public function editPass(){
        if($_SESSION['rules'] < 4){
            return false;
        }
        
        $model = new users();
        $result = $model->editPass($_POST);
        
        if(!empty($result['errors'])){
            $jsonArray = array('errors' => $result['errors']);
        }else{
            $jsonArray = array('success' => $result['success']);
        }
        
        echo json_encode($jsonArray);
        
    }
    
    
}
