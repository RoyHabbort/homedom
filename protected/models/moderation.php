<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of moderation
 *
 * @author Рой
 */
class moderation extends modelsClass{
    
    public function deleteNews($idNews){
        $params['id'] = $idNews;
        $base = new mysqlClass;
        $params = $base->validate($params, $rules = array(
            'required' => 'id',
            'string' => 'id',
            ));
        
        if(empty($params['valid_errors'])){
            $sql = "DELETE FROM `news` WHERE `id` = '{$params['id']}'";
            $result = $base->query($sql);
        }else{
            return false;
        }
    }
    
    public function loginModer($params){
        
        $base = new mysqlClass();
        $params = $base->validate($params, array(
           'string' => 'login, password', 
        ));
        $password = md5($params['password']);
        $sql = "SELECT * FROM `users` WHERE `rules` = 3 AND `phone` = '{$params['login']}' AND `password` = '{$password}'";
        $result = $base->query($sql);
        
        if($result){
            $_SESSION['phone'] = $params['login'];
            $_SESSION['rules'] = 3;
            $_SESSION['user_id'] = $result[0]['id_user'];
            return $params['error'] = false;
        }else{
            $params['error'] = "Неверная пара логин - пароль.";
            return $params['error'];
        }
        
    }
    
    
    public function getUsersByFilter($filter){
        $params['phone'] = '';
        if(!empty($filter)) $params['phone'] = $filter;
        
        $base = new mysqlClass();
        
        $params = $base->validate($params, $rules = array(
            'string' => 'phone',
            ));
        $fil = '';
        if (!empty($params['phone'])) $fil = " AND `phone` = '{$params['phone']}'";
        
        $sql = "SELECT *
                FROM `users` 
                WHERE `rules` = 0" . $fil;
        $result = $base->query($sql);
        if ($result) return array('result'=>$result);
            else return array('errors'=> array('sql_error' => 'Пользователи не найдены'));
            
    }
    
    public function setban($params){
        $base = new mysqlClass();
        $params = $base->validate($params, array(
                'required' => 'id',
                'string' => 'rules, id',
                ));
        if(empty($params['valid_errors'])){
            if($params['rules']==1){
                $sql = "UPDATE `users` SET `rules` = 0 WHERE `id_user` = '{$params['id']}' AND `rules` <= 1";
            }else{
                $sql = "UPDATE `users` SET `rules` = 1 WHERE `id_user` = '{$params['id']}' AND `rules` <= 1";
            }

            if ($base->query($sql)) return TRUE;
                else return FALSE;
        }
        return FALSE;
    }
    
    
    public function getNews(){
        $base = new mysqlClass();
        $sql = "SELECT * FROM `news` WHERE 1 ORDER BY `date` DESC";
        $result = $base->query($sql);
        if($result) return $result;
            else return false;
    }
    
    public function getNewsId($id){
        $params['id'] = $id;
        $base = new mysqlClass();
        $params = $base->validate($params, $rules = array(
                'required'=> 'id',
                'string' => 'id',
            ));
        
        if(empty($params['valid_errors'])){
            $sql = "SELECT * FROM `news` WHERE `id` = '{$params['id']}'";
            $result = $base->query($sql);
            if ($result) return $result[0];
                else return false;
        }else{
            return false;
        }
        
    }
    
    
    public function editNews($params, $id){
        
        $for_main = '';
        
        $params['id'] = $id;
        $base = new mysqlClass();
        $params = $base->validate($params, $rules = array(
            'required' => 'id, title, text',
            'string' => 'id, title',
            'text' => 'text',
            ));
        
        if(!empty($params['for_main'])){
            $for_main = 1;
        }else $for_main = 0;
        
        if (!empty($_FILES['image']["name"])){
            $image = $this->uploadFrontImage('image', 340, false);
            if ($image){
                $params['image'] = $image;
            }else {
                $params['valid_errors']['image'] = "Неправильный формат картинки";
            }
        }else{
            $params['image']='';
        }
        
        if(empty($params['valid_errors'])){
            
            if ($for_main){
                $sql = "UPDATE `news` SET `for_main` = '0' WHERE 1";
                $base->query($sql);
                $sql = "UPDATE `blog` SET `for_main` = '0' WHERE 1";
                $base->query($sql);
            }
            
            $image_sql = '';
            if(!empty($params['image'])) $image_sql = ", `image` = '{$params['image']}'";
            
            $sql = "UPDATE `news` SET `title` = '{$params['title']}', `text` = '{$params['text']}', `user_edit` = '{$_SESSION['user_id']}', `for_main` = '{$for_main}' " . $image_sql . "  WHERE `id` = '{$params['id']}'";
            echo $sql;
            $result = $base->query($sql);
            if ($result) return true;
                else return array('errors' => array('sql_error' => 'Невозможно отредактировать новость в данный момент'));
        }else{
            return array('errors'=> $result['valid_errors']);
        }
        
    }
    
    
    
    
    
    public function addNews($params){
        $for_main = '';
        
        $base = new mysqlClass();
        $params = $base->validate($params, $rules = array(
            'required' => 'title, text',
            'string' => 'title, for_main',
            'text' => 'text',
            ));
        
        if(!empty($params['for_main'])){
            $for_main = 1;
        }else $for_main = 0;
        
        
        if (!empty($_FILES['image']["name"])){
            $image = $this->uploadFrontImage('image', 340, false);
            if ($image){
                $params['image'] = $image;
            }else {
                $params['valid_errors']['image'] = "Неправильный формат картинки";
            }
        }else{
            $params['image']='';
        }
        
        
        if(empty($params['valid_errors'])){
            
            if ($for_main){
                $sql = "UPDATE `news` SET `for_main` = '0' WHERE 1";
                $base->query($sql);
            }
            
            $date = date('Y-m-d H:i:s');
            $sql = "INSERT INTO `news` (`title`, `text`, `date`, `user_create`, `image`, `for_main`) VALUES ('{$params['title']}', '{$params['text']}', '{$date}', '{$_SESSION['user_id']}', '{$params['image']}', '{$for_main}')";
            $result = $base->query($sql);
            if ($result) {
                return array('last_id' => $base->last_insert_id());
            }
                else return array('errors' => array('sql_error' => 'Невозможно отредактировать новость в данный момент'));
        }else{
            return array('errors'=> $result['valid_errors']);
        }
        
    }
    
    public function listObject(){
        $base = new mysqlClass();
        $sql = "SELECT * FROM `object` o LEFT JOIN `type_object` t ON o.type = t.id_type LEFT JOIN `users` u ON o.user_id = u.id_user  WHERE o.moderation = 0 AND u.rules >= 1";
        $result = $base->query($sql);
        if($result) return $result;
            else return false;
    }
    
    
    public function getObjectId($id){
        if (($id != 0) &&!empty($id) ){
            $params['id'] = $id;
            $base = new mysqlClass();
            $params = $base->validate($params, array(
                    'string' => 'id',
                    ));
            
            $sql = "SELECT o.id, o.category, o.type, o.city, o.district, o.street, o.home, o.apartament, o.public_square,
                    o.life_square, o.price, o.comment, o.date_create, o.user_id, o.time_start, o.time_end, o.kitchen, u.email, u.id_user, u.rules,
                    u.phone, u.fio, u.rules, u.description, u.date_registration, u.date_visited, o.main_image, o.floor, o.floor_all
                    FROM `object` o
                    LEFT JOIN `city` c ON c.id_city = o.city
                    LEFT JOIN `district` d ON d.id_district = o.district
                    LEFT JOIN `type_object` t ON t.id_type = o.type
                    LEFT JOIN `users` u ON u.id_user = o.user_id
                    WHERE o.id = '{$params['id']}' AND u.rules >= 1 ORDER BY `date_create` DESC";
            $result = $base->query($sql);
            
            $sql = "SELECT `id_photo`, `photo` FROM `photogallery` WHERE `object_id` = '{$result[0]['id']}'";
            $result[0]['photo'] = $base->query($sql);
            
            if ($result) return $result[0];
                else return false;
            
        }else return false; 
    }
    
    public function moderObject($id){
        $params['id'] = $id;
        $base = new mysqlClass();
        $params = $base->validate($params, $rules = array(
            'string' => 'id',
            ));
        
        
        
        $sql = "UPDATE `object` SET `moderation` = '1' WHERE `id` = '{$params['id']}'";
        $result = $base->query($sql);
        if($result) return true;
            else return false;
    }
    
    public function banObject($id){
        $params['id'] = $id;
        $base = new mysqlClass();
        $params = $base->validate($params, $rules = array(
            'string' => 'id',
            ));
        
        $sql = "UPDATE `object` SET `moderation` = '-1' WHERE `id` = '{$params['id']}'";

        $result = $base->query($sql);
        if($result) return true;
            else return false;
        
    }
    
    
    public function uploadImage($id){
        $params['object_id'] = $id;
        $base = new mysqlclass();
        
        $params = $base->validate($params, $rules = array (
                'required' => 'object_id',
                'string' => 'object_id',
            ));
        
        if (!empty($_FILES['photogallery']["name"])){
            $image = $this->uploadFrontImage('photogallery', 1024);
            if ($image) $params['photogallery'] = $image;
                else $params['valid_errors']['photogallery'] = "Неправильный формат картинки";
        }
        
        if(empty($params['valid_errors'])){
            $date = date('Y-m-d H:i:s');
            $sql = "INSERT INTO `photogallery` (`photo`, `object_id`, `date`, `moder_id`) 
                    VALUES ('{$params['photogallery']}', '{$params['object_id']}', '{$date}', '{$_SESSION['user_id']}' )";
            $result = $base->query($sql);
            if ($result) return NULL;
                else $params['valid_errors']['sql_error'] = "Ошибка загрузки фотографии";
        }else{
            return $params['valid_errors'];
        }
            
        
    }
    
    
    public function deletePhoto($id){
        $params['id_photo'] = $id;
        $base = new mysqlclass();
        
        $params = $base->validate($params, $rules = array (
                'required' => 'id_photo',
                'string' => 'id_photo',
            ));
        
        if(empty($params['valid_errors'])){
            
            $sql = "SELECT `object_id` FROM `photogallery` WHERE `id_photo` = '{$params['id_photo']}' LIMIT 1";
            $object_id = $base->query($sql);
            
            $sql = "DELETE FROM `photogallery` WHERE `id_photo` = '{$params['id_photo']}'";
            $result = $base->query($sql);
            
            $sql = "SELECT * FROM `photogallery` WHERE `object_id` = '{$object_id}'";
            
            $troop = $base->query($sql);
            
            if (!empty($troop)){
                $need = $troop[0];
                $sql = "UPDATE `object` SET `main_image` = '{$need['photo']}' WHERE `id` = '{$object_id}'";
                $base->query($sql);
            }else{
                $sql = "UPDATE `object` SET `main_image` = '' WHERE `id` = '{$object_id}'";
                $base->query($sql);
            }
            
            
            
            if ($result) return NULL;
                else $params['valid_errors']['sql_error'] = "Ошибка удаления фотографии";
        }else{
            return $params['valid_errors'];
        }
        
    }
    
    
    public function deleteUser($params){
        $base = new mysqlclass();
        
        $params = $base->validate($params, $rules = array (
                'required' => 'id',
                'string' => 'id',
            ));
        
        if(empty($params['valid_errors'])){
            
            
            $sql = "DELETE FROM `users` WHERE `id_user` = '{$params['id']}'";
            if(!empty($_SESSION['phone'])&&!empty($_SESSION['rules'])){
                if($_SESSION['rules'] >= 3){
                    $result = $base->query($sql);
                    if($result) return true;
                        else return false;
                } else return false;
            }else return false;
            
        }else return false;
        
    }
    
    public function deleteUserBilling($params){
        $base = new mysqlclass();
        
        $params = $base->validate($params, $rules = array (
                'required' => 'id_user',
                'string' => 'id_user',
            ));
        
        if(empty($params['valid_errors'])){
            
            
            $sql = "DELETE FROM `users` WHERE `id_user` = '{$params['id_user']}'";
            if(!empty($_SESSION['phone'])&&!empty($_SESSION['rules'])){
                if($_SESSION['rules'] >= 3){
                    $result = $base->query($sql);
                    if($result) return array('success' => 'Пользователь успешно удалён');
                        else return array('errors' => 'Ошибка БД');
                } else return array('errors' => 'Ошибка прав доступа');
            }else return array('errors' => 'Ошибка прав доступа');
            
        }else return array('errors' => $params['valid_errors']);
        
    }
    
    
    
    public function otvetCount(){
        
        $base = new mysqlClass();
        
        $sql = "SELECT * FROM `otvet` WHERE `otvet` = 'Поиск в яндекс/Google'";
        $result1 = $base->query($sql);
        
        $sql = "SELECT * FROM `otvet` WHERE `otvet` = 'Реклама на улице'";
        $result2 = $base->query($sql);
        
        $sql = "SELECT * FROM `otvet` WHERE `otvet` = 'Социальные сети'";
        $result3 = $base->query($sql);
        
        $sql = "SELECT * FROM `otvet` WHERE `otvet` = 'Посоветовал друг'";
        $result4 = $base->query($sql);
        
        $result = array(
            'Поиск в яндекс/Google' => count($result1),
            'Реклама на улице' => count($result2),
            'Социальные сети' => count($result3),
            'Посоветовал друг' => count($result4),
        );
        
        return $result;
            
    }
    
    
    public function getUsersForBilling(){
        
        $base = new mysqlClass();
        
        $sql = "SELECT * FROM `users` WHERE `rules` < 3 ";
        $users = $base->query($sql);
        $result = array();
        
        foreach ($users as $key => $value) {
            $options = $this->getBillingOption($value['id_user']);
            
            $result[$key]['id_user'] = $value['id_user'];
            $result[$key]['city'] = $value['city'];
            $result[$key]['fio'] = $value['fio'];
            $result[$key]['phone'] = $value['phone'];
            $result[$key]['email'] = $value['email'];
            $result[$key]['date_registration'] = $value['date_registration'];
            $result[$key]['date_visited'] = $value['date_visited'];
            $result[$key]['count'] = $options['count'];
            $result[$key]['status'] = $options['status'];
            $result[$key]['comment'] = $value['comment'];
        }
        
        return $result;
        
    }
    
    private function getBillingOption($id){
        $options = array();
        $base = new mysqlClass();
        $rent = 0;
        $sell = 0;
        $userRent = 0;
        $userBuy = 0;
        
        $sql = "SELECT * FROM `object` WHERE `user_id` = '{$id}'";
        $objects = $base->query($sql);
        
        
        foreach ($objects as $key => $value) {
            $rent = ($value['category'] == 'renting') ? 1 : 0;
            $sell = ($value['category'] == 'sell') ? 1 : 0;
        }
        
        
        $sql = "SELECT `rules` FROM `users` WHERE `id_user` = '{$id}' LIMIT 1";
        $rules = $base->query($sql);
        
        if($rules == 0){
            $case = "-1";
        }else{
            $sql = "SELECT * FROM `code` WHERE `user_id` = '{$id}'";
            $code = $base->query($sql);

            foreach ($code as $key => $value) {
                $userRent = ($value['category'] == 'renting') ? 1 : 0;
                $userBuy = ($value['category'] == 'sell') ? 1 : 0;
            }

            $case = $rent . $sell . $userRent . $userBuy;
        }    
        
        switch ($case) {
            case '0000':
                $status = "В поиске";
                break;
            case '1000':
                $status = "Сдаёт жильё";
                break;
            case '0100':
                $status = "Продаёт";
                break;
            case '1100':
                $status = "Сдаёт и продаёт";
                break;
            case '0010':
                $status = "Ищет аренду";
                break;
            case '0001':
                $status = "Ищет на продажу";
                break;
            case '0011':
                $status = "Полный доступ к поиску";
                break;
            case '1001':
                $status = "Сдаёт и ищет";
                break;
            case '1010':
                $status = "Сдаёт и ищет";
                break;
            case '1011':
                $status = "Сдаёт и ищет";
                break;
            case '0101':
                $status = "Продаёт и ищет";
                break;
            case '0110':
                $status = "Продаёт и ищет";
                break;
            case '0111':
                $status = "Продаёт и ищет";
                break;
            case '1101':
                $status = "Сдаёт, продаёт и ищет";
                break;
            case '1110':
                $status = "Сдаёт, продаёт и ищет";
                break;
            case '1111':
                $status = "Сдаёт, продаёт и ищет всё подряд";
                break;
            case '-1':
                $status = "Забанен";
                break;

            default:
                $status = "В поиске";
                break;
        }
        
        $options['status'] = $status;
        $options['count'] = count($objects);
        
        return $options;
        
    }
    
    
}
