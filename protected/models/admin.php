<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin
 *
 * @author Рой
 */
class admin extends modelsClass {
    
    
    public function loginAdmin($params){
        
        $base = new mysqlClass();
        $params = $base->validate($params, array(
           'string' => 'login, password', 
        ));
        $password = md5($params['password']);
        $sql = "SELECT * FROM `users` WHERE `rules` = 4 AND `phone` = '{$params['login']}' AND `password` = '{$password}'";
        $result = $base->query($sql);
        
        if($result){
            $_SESSION['phone'] = $params['login'];
            $_SESSION['rules'] = 4;
            $_SESSION['user_id'] = $result[0]['id_user'];
            return $params['error'] = false;
        }else{
            $params['error'] = "Неверная пара логин - пароль.";
            return $params['error'];
        }
        
    }
    
    
    public function listUsers(){
        
        $base = new mysqlClass();
        $sql = "SELECT * FROM `users` WHERE `rules` > 1";
        $result = $base->query($sql);
        if($result) return $result;
            else return false;
        
    }
    
    public function addUsers($params){
        
        $base = new mysqlClass();
        $params = $base->validate($params, array(
            'required' => 'fio, login, password, password_a, email, rules',
            'string' => 'fio, login, password, password_a, description, email',
            'number' => 'rules',
            'equal' => 'password, password_a',
            'email' => 'email',
            ));
        
        $sql = "SELECT * FROM `users` WHERE `phone` = '{$params['login']}'";
        if($base->query($sql)) $params['valid_errors']['login'] = 'Данный логин уже занят';
        
        
        if (empty($params['valid_errors'])){
            $params["password"] = md5($params["password"]);
            $date_registration = date('Y-m-d H:i:s');
            $sql = "INSERT INTO `users` (`phone`, `fio`, `email`, `password`, `rules`, `description`, `date_registration`) VALUES ('{$params["login"]}', '{$params["fio"]}', '{$params['email']}', '{$params["password"]}', '{$params["rules"]}', '{$params["description"]}', '{$date_registration}')";
            if (!$base->query($sql)){
                return array('sql_error' => 'Регистрация в данный момент не доступна');
            }
            return null;
        }else{
            return $params['valid_errors'];
        }
        
        
    }
    
    public function setRules($params){
        
        $base = new mysqlClass();
        $params = $base->validate($params, array(
                'required' => 'rules, id',
                'string' => 'rules, id',
                ));
        
        if (empty($params['valid_errors'])){
            $sql = "UPDATE `users` SET `rules` = '{$params['rules']}' WHERE `id_user` =  '{$params['id']}' AND `rules` > 1";
            if($base->query($sql)) return true;
                else return false;
        }else return false;
        
    }
    
    public function generateKey($params){
        $base = new mysqlClass();
        $params = $base->validate($params, array(
                'required' => 'days, category',
                'number' => 'days, category',
                ));
            
            if(empty($params['valid_errors'])){
                $users = new users();
                $code = $users->randomCode();
                $date_generation = date('Y-m-d H:i:s');
                $sql = "INSERT INTO `code` (`code`, `user_id`, `days`, `category`, `date_generation`)
                        VALUES ('{$code}', '-1', '{$params['days']}', '{$params['category']}', '{$date_generation}')";

                if ($base->query($sql)) return array('success'=> 'Ключ получен', 'key' => $code);
                    else return array('errors' =>array('sql_error'=> 'В данный момент получить код невозможно. Попробуйте позже.'));
            }
            return array('errors' => $params['valid_errors']);
    }
    
    
    
    public function getAllCity(){
        $base = new mysqlClass;
        $sql = "SELECT * FROM `city` WHERE 1";
        $result = $base->query($sql);
        if ($result) return $result;
            else return false;
    }
    
    
    
    public function deleteCity($id){
        $base = new mysqlClass;
        $params['id'] = $id;
        $params = $base->validate($params, $rules = array(
            'required' => 'id',
            'string' => 'id'
            ));
        if(empty($params['valid_errors'])){
            $sql = "DELETE FROM `city` WHERE `id_city` = '{$params['id']}'";
            $result = $base->query($sql);
            if ($result){
                $sql = "DELETE FROM `object` WHERE `city` = '{$params['id']}'";
                $base->query($sql);
                $sql = "DELETE FROM `district` WHERE `city_id` = '{$params['id']}'";
                $base->query($sql);
                return true;
            }else return false;
            
            
        }else return false;
        
    }
    
    
    public function createCity($params){
        $base = new mysqlClass();
        $params = $base->validate($params, $rules = array(
            'required' => 'city, cx, cy',
            'string' => 'city, cx, cy',
            ));
        
        if(empty($params['valid_errors'])){
            $sql = "INSERT INTO `city` (`city`, `coord_x`, `coord_y`) VALUES ('{$params['city']}', '{$params['cx']}', '{$params['cy']}')";
            $result = $base->query($sql);
            if ($result) return NULL;
                else return array('errors' => array('sql_error' => 'Не возможно создать город в данный момент'));
            
        }else return array('errors' => $params['valid_errors']);
    }
    
    
    public function editCity($params, $id){
        
        $base = new mysqlClass();
        $params['id'] = $id;
        $params = $base->validate($params, $rules = array(
            'required' => 'id, city, cx, cy',
            'string' => 'id, city, cx, cy',
            ));
        
        if(empty($params['valid_errors'])){
            $sql = "UPDATE `city` SET `city` = '{$params['city']}', `coord_x` = '{$params['cx']}', `coord_y` = '{$params['cy']}' WHERE `id_city` = '{$params['id']}'";
            $result = $base->query($sql);
            if ($result) return NULL;
                else return array('errors' => array('sql_error' => 'Ошибка редактирования'));
            
        }else return array('errors' => $params['valid_errors']);
        
    }
    
    
    public function getCityId($id){
        $base = new mysqlClass();
        $params['id'] = $id;
        $params = $base->validate($params, $rules = array(
            'required' => 'id',
            'string' => 'id',
            ));
        
        if(empty($params['valid_errors'])){
            $sql = "SELECT * FROM `city` WHERE `id_city` = '{$params['id']}'";
            $result = $base->query($sql);
            if ($result) return $result[0];
                else return array('errors' => array('sql_error' => 'Произошла ошибка. Данные не получены.'));
            
        }else return array('errors' => $params['valid_errors']);
        
        
    }
    
    
    
    public function getDistrictId($id){
        $base = new mysqlClass();
        $params['id'] = $id;
        $params = $base->validate($params, $rules = array(
            'required' => 'id',
            'string' => 'id',
            ));
        
        if(empty($params['valid_errors'])){
            $sql = "SELECT * FROM `district` WHERE `city_id` = '{$params['id']}'";
            $result = $base->query($sql);
            if ($result) return $result;
                else return array('errors' => array('sql_error' => 'Произошла ошибка. Данные не получены.'));
            
        }else return array('errors' => $params['valid_errors']);
        
    }
    
    
    public function deleteDistrict($params){
        
        $base = new mysqlClass;
        $params = $base->validate($params, $rules = array(
            'required' => 'id, to_id',
            'string' => 'id, to_id'
            ));
        if(empty($params['valid_errors'])){
            $sql = "DELETE FROM `district` WHERE `id_district` = '{$params['id']}'";
            $result = $base->query($sql);
            if ($result){
                $sql = "UPDATE `object` SET `district` = '{$params['to_id']}'  WHERE `district` = '{$params['id']}'";
                $base->query($sql);
                return true;
            }else return false;
            
            
        }else return false;
        
    }
    
    public function addDistrict($params){
        $base = new mysqlClass();
        $params = $base->validate($params, $rules = array(
            'required' => 'district, id',
            'string' => 'district, id',
            ));
        
        if(empty($params['valid_errors'])){
            
            $sql = "INSERT INTO `district` (`district`, `city_id`) VALUES ('{$params['district']}', '{$params['id']}')";
            $result = $base->query($sql);
            if ($result) return $base->last_insert_id();
                else return FALSE;
            
        }else FALSE;
    }
    
    
    
    public function rezervKey($params){
        
        $base = new mysqlClass();
        $params = $base->validate($params, $rules = array(
                'string' => 'rent, sell',
            ));
        
        if(!empty($params['rent'])) $params['rent'] = 1;
            else $params['rent'] = 0;
        
        if(!empty($params['sell'])) $params['sell'] = 1;
            else $params['sell'] = 0;  
            
        $sql = "UPDATE `distr_key` SET `stat` = '{$params['rent']}' WHERE `category` = 'renting'";
        $result[0] = $base->query($sql);
        $sql2 = "UPDATE `distr_key` SET `stat` = '{$params['sell']}' WHERE `category` = 'sell'";
        $result[1] = $base->query($sql2);
        if($result[0]&&$result[1]) return true;            
            else return fasle;
        
    }
    
    public function getDistrKey(){
        $base = new mysqlClass();
        $sql = "SELECT * FROM `distr_key` WHERE 1";
        return $base->query($sql);
    }
    
    public function countDistrKey(){
        $base = new mysqlClass();
        $sql = "SELECT count(*) FROM `distr_key` WHERE `stat` = 1 LIMIT 1";
        return $base->query($sql);
    }
    
    
    /*
     * 8-11-2014
     * Добавление админ коммента
     * roy
     */
    
    public function addAdminComment($params){
        $base = new mysqlClass;
        $params = $base->validate($params, $rules = array(
            'required' => 'id_user',
            'string' => 'id_user, comment'
        ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }else{
            
            $sql = "UPDATE `users` SET `comment` = '{$params['comment']}' WHERE `id_user` = '{$params['id_user']}'";
            $result = $base->query($sql);
            
            if($result){
                return array('success' => 'Коммент добавлен');
            }else{
                return array('errors' => 'Ошибка БД');
            }
            
        }
    }
    
    
    /*
     * 8-11-2014
     * Добавление статуса
     * roy
     */
    
    public function addAdminStatus($params){
        $base = new mysqlClass;
        $params = $base->validate($params, $rules = array(
            'required' => 'id_user',
            'string' => 'id_user, status'
        ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }else{
            
            $sql = "UPDATE `users` SET `status` = '{$params['status']}' WHERE `id_user` = '{$params['id_user']}'";
            $result = $base->query($sql);
            
            if($result){
                return array('success' => 'Коммент добавлен');
            }else{
                return array('errors' => 'Ошибка БД');
            }
            
        }
    }
    
    
    
}
