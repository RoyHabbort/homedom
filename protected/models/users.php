<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of users
 *
 * @author Иноходец
 */
class users {
    
    public function addUsers($params){
        
        $base = new mysqlClass();
        $params = $base->validate($params, array(
            'required' => 'fio, phone, password, password_a, email, user_city',
            'string' => 'fio, phone, password, password_a, user_city, email',
            'equal' => 'password, password_a',
            'email' => 'email',
            'phone' => 'phone'
            ));
        
        $sql = "SELECT * FROM `users` WHERE `phone` = '{$params['phone']}'";
        if($base->query($sql)) $params['valid_errors']['phone'] = 'С данного телефона регистрация уже проводилась';
        
        if (empty($params['valid_errors'])){
            $params["password"] = md5($params["password"]);
            $date_registration = date('Y-m-d H:i:s');
            $sql = "INSERT INTO `users` (`phone`, `fio`, `email`, `password`, `city`, `date_registration`) VALUES ('{$params["phone"]}', '{$params["fio"]}', '{$params['email']}', '{$params["password"]}', '{$params["user_city"]}', '{$date_registration}')";
            if (!$base->query($sql)){
                return array('sql_error' => 'Регистрация в данный момент не доступна');
            }
            return null;
        }else{
            return $params['valid_errors'];
        }
    }
    
    public function editUser($params) {
        $base = new mysqlClass();
        $params = $base->validate($params, array(
            'required' => 'fio, user_city',
            'string' => 'fio, user_city, email',
            'email' => 'email'
            ));
        
        if(!empty($params['new_password'])){
            $params = $base->validate($params, array(
                'required' => 'old_password, new_password, password_a',
                'string' => 'old_password, new_password, password_a',
                'equal' => 'new_password, password_a',
                ));
            
            if(empty($params['valid_errors'])){
                $password = md5($params['old_password']);
                $sql = "SELECT * FROM `users` WHERE `phone` = '{$_SESSION['phone']}' AND `password` = '{$password}'";
                if (!$base->query($sql)) return array('errors' => array('old_password' => 'Неверный пароль'));
            }
            $pass = md5($params['new_password']);
            $sql = "UPDATE `users`
                    SET `fio` = '{$params['fio']}', `email` = '{$params['email']}', `password` = '{$pass}', `city` = '{$params['user_city']}'
                    WHERE `phone` = '{$_SESSION['phone']}'";
        }else{
            $sql = "UPDATE `users`
                    SET `fio` = '{$params['fio']}', `email` = '{$params['email']}', `city` = '{$params['user_city']}'
                    WHERE `phone` = '{$_SESSION['phone']}'";
        }
        
        if(empty($params['valid_errors'])){
            $result = $base->query($sql);
            if($result) return array('success'=>'Личные данные успешно обновлены');
                else return array('errors'=> array('sql_error' => 'В данный момент обновить данные невозможно.'));
        }else{
            return array('errors' => $params['valid_errors']);
        }
        
        
    }
    
    public function loginUsers($params) {
        $base = new mysqlClass();
        $params = $base->validate($params, array(
           'string' => 'phone, password', 
        ));
        
        unset($_SESSION['phone']);
        unset($_SESSION['rules']);
        unset($_SESSION['user_id']);
        
        $password = md5($params['password']);
        $sql = "SELECT * FROM `users` WHERE `rules` = 1 AND `phone` = '{$params['phone']}' AND `password` = '{$password}'";
        $result = $base->query($sql);
        if($result){
            $_SESSION['phone'] = $params['phone'];
            $_SESSION['user_id'] = $result[0]['id_user'];
            
            $date_visited = date('Y-m-d H:i:s');
            $sql = "UPDATE `users` SET `date_visited` = '{$date_visited}' WHERE `phone` = '{$_SESSION['phone']}' ";
            $base->query($sql);
            return $params['error'] = false;
        }else{
            $params['error'] = "Неверная пара логин - пароль.";
            return $params['error'];
        }
        
    }
    
    public function getFio($phone) {
        
        $base = new mysqlClass();
        $sql = "SELECT `fio` FROM `users` WHERE `phone` = '{$phone}' LIMIT 1";
        $fio = $base->query($sql);
        if (!empty($fio)) return $fio;
            else return false;
    }
    
    public function logoutUsers() {
        $base = new mysqlClass();
        $date_visited = date('Y-m-d H:i:s');
        $sql = "UPDATE `users` SET `date_visited` = '{$date_visited}' WHERE `phone` = '{$_SESSION['phone']}' ";
        $base->query($sql);
        unset($_SESSION['phone']);
        unset($_SESSION['rules']);
        unset($_SESSION['user_id']);
        session_destroy();
    }
    
    public function getUser($id){
        $params['id'] = $id;
        $base = new mysqlClass();
        $params = $base->validate($params, array(
                'string' => 'id',
                ));
        $sql = "SELECT * FROM `users` WHERE `id_user` = '{$params['id']}'";
        $result = $base->query($sql);
        if ($result) return $result[0];
            else return false;
    }
    
    
    public function getPersonalInfo(){
        $base = new mysqlClass();
        $sql = "SELECT count(o.id), u.id_user, u.phone, u.fio, u.email, u.rules, u.city, u.date_registration
                FROM `users` u
                LEFT JOIN `object` o ON u.id_user = o.user_id
                WHERE u.phone = '{$_SESSION['phone']}'";
        $result = $base->query($sql);
        $current_date = date('Y-m-d H:i:s');
        $sql_code = "SELECT c.category, (c.days - Datediff('{$current_date}', c.date_activate)) as days
                    FROM `code` c 
                    WHERE c.user_id = '{$result[0]['id_user']}' AND Datediff('{$current_date}', c.date_activate) IS NOT NULL AND (c.days - Datediff('{$current_date}', c.date_activate)) > 0";
        $result[0]['code'] = $base->query($sql_code);
        
        foreach ($result[0]['code'] as $key => $value) {
            
            switch ($value['category']) {
                case 'sell':
                    $result[0]['code']['sell'][] = $value['days'];
                    unset($result[0]['code'][$key]);
                    break;
                
                case 'buy':
                    $result[0]['code']['buy'][] = $value['days'];
                    unset($result[0]['code'][$key]);
                    break;
                
                case 'renting':
                    $result[0]['code']['renting'][] = $value['days'];
                unset($result[0]['code'][$key]);
                    break;
                
                case 'rentals':
                    $result[0]['code']['rentals'][] = $value['days'];
                    unset($result[0]['code'][$key]);
                    break;

                default:
                    unset($result[0]['code'][$key]);
                    break;
            }
            
        }
        
        foreach ($result[0]['code'] as $key => $value) {
            $result[0]['code'][$key] = max($value);
        }
        
        $result[0]['date_registration'] = date('Y-m-d', time($result[0]['date_registration']));
        return $result[0];
    }
    
    
    public function generateCode($params){
        $base = new mysqlClass();
        $params = $base->validate($params, array(
            'required' => 'days, category, type_receive, otvet',
            'string' => 'otvet',
            'number' => 'days, category',
            ));
        if(empty($params['valid_errors'])){
            
            if($params['otvet']=='Лабиен'){
                $code = $this->randomCode();
                $date_generation = date('Y-m-d H:i:s');
                $sql = "INSERT INTO `code` (`code`, `user_id`, `days`, `category`, `date_generation`)
                        VALUES ('{$code}', '{$_SESSION['user_id']}', '{$params['days']}', '{$params['category']}', '{$date_generation}')";
                       
                if ($base->query($sql)) return array('success'=> 'Ключ получен', 'key' => $code);
                    else return array('errors' =>array('sql_error'=> 'В данный момент получить код не возможно. Попробуйте позже.'));
            }
            return array('errors' =>array('otvet'=> 'Не правильный ответ на вопрос'));
        }
        return array('errors' => $params['valid_errors']);
        
    }
    
    
    public function randomCode(){
        $base = new mysqlClass();
        do{
            $key = '';
            for($i=0; $i<12; $i++){
                $key .= mt_rand(0,9);
            }
            $sql = "SELECT * FROM `code` WHERE `code` = '{$key}'";
            $result = $base->query($sql);
        }while($result);
        return $key;
    }
    
    
    public function activateCode($params){
        $base = new mysqlClass();
        $params = $base->validate($params, array(
            'required' => 'code',
            'string' => 'code',
            ));
        
        if(empty($params['valid_errors'])){
            $date_activate = date('Y-m-d H:i:s');
            $sql = "UPDATE `code`
                    SET `date_activate` = '{$date_activate}', `user_id` = '{$_SESSION['user_id']}' 
                    WHERE (`user_id` = '{$_SESSION['user_id']}' OR `user_id` = '-1') AND `code` = '{$params['code']}' AND `date_activate` is NULL";
                    
            $result = $base->query($sql);
            $count = $base->anotherNumRow();
            if ($count) return true;
                else return false;
        }else{
            return false;
        }
    }
    
    
    public function ifGetCode(){
        $base = new mysqlClass();
        
        $sql = "SELECT count(*) FROM `distr_key` WHERE `stat` = 1 LIMIT 1";
        if($base->query($sql)>0){
            if (empty($_SESSION['phone'])){
                return true;
            }else{
                $sql = "SELECT c.id_code FROM `code` c INNER JOIN `users` u ON u.id_user = c.user_id WHERE u.phone = '{$_SESSION['phone']}'";
                if ($base->numrows($sql)<1){
                    return true;
                }
                return false;
            }
        }else{
            return false;
        }
        
    }
    
    public function generateCodeByVopros($params){
        
        $ifGetCode = $this->ifGetCode();
        if(true){ //проверка на получение кода доступа
            
            if(empty($params['name'])){


                $otvet = '4';

                $base = new mysqlClass();
                if(empty($_SESSION['phone'])){

                    $params = $base->validate($params, array(
                        'required' => 'days, category, type_receive, otvet, fio, phone, password, password_a, email, user_city',
                        'string' => 'otvet, fio, phone, password, password_a, user_city, email',
                        'equal' => 'password, password_a',
                        'number' => 'days, category',
                        'email' => 'email',
                        'phone' => 'phone',
                        ));

                    if($params['days']!=7 && $params['days']!=14 && $params['days']!=21 && $params['days']!=28){
                        $params['valid_errors']['days'] = "Ошибка ввода даты";
                    }


                    $sql = "SELECT * FROM `users` WHERE `phone` = '{$params['phone']}'";
                    if($base->query($sql)) $params['valid_errors']['phone'] = 'С данного телефона регистрация уже проводилась';

                    $sql = "SELECT `stat` FROM `distr_key` WHERE `category` = '{$params['category']}' LIMIT 1";
                    if(!$base->query($sql)) $params['valid_errors']['sql_error'] = 'Выдача ключей для данной категории закрыта';

                    if (empty($params['valid_errors'])){
                        $old_password = $params["password"];
                        $params["password"] = md5($params["password"]);
                        $date_registration = date('Y-m-d H:i:s');
                        $sql = "INSERT INTO `users` (`phone`, `fio`, `email`, `password`, `city`, `date_registration`) VALUES ('{$params["phone"]}', '{$params["fio"]}', '{$params['email']}', '{$params["password"]}', '{$params["user_city"]}', '{$date_registration}')";
                        if (!$base->query($sql)){
                            return array('errors' => array('sql_error' => 'Регистрация в данный момент не доступна'));
                        }

                        $user = new users();
                        $us_params = array(
                            'phone' => $params['phone'],
                            'password' => $old_password,
                        );
                        $user->loginUsers($us_params);

                        $sql = "INSERT INTO `otvet` (`user_id`, `otvet`) VALUES ('{$_SESSION['user_id']}', '{$params['otvet']}')";
                        $base->query($sql);

                            $code = $this->randomCode();
                            $date_generation = date('Y-m-d H:i:s');
                            $sql = "INSERT INTO `code` (`code`, `user_id`, `days`, `category`, `date_generation`)
                                    VALUES ('{$code}', '{$_SESSION['user_id']}', '{$params['days']}', '{$params['category']}', '{$date_generation}')";

                            if ($base->query($sql)) return array('success'=> 'Ключ получен', 'key' => $code);
                                else return array('errors' =>array('sql_error'=> 'В данный момент получить код не возможно. Попробуйте позже.'));

                        return array('errors' =>array('otvet'=> 'Не правильный ответ на вопрос'));
                    }else{
                        return array('errors' => $params['valid_errors']);
                    }

                }else{
                    $params = $base->validate($params, array(
                        'required' => 'days, category, type_receive, otvet',
                        'string' => 'otvet',
                        'number' => 'days, category',
                        ));

                    if($params['days']!=7 && $params['days']!=14 && $params['days']!=21 && $params['days']!=28){
                        $params['valid_errors']['days'] = "Ошибка ввода даты";
                    }

                    if(empty($params['valid_errors'])){


                        $sql = "INSERT INTO `otvet` (`user_id`, `otvet`) VALUES ('{$_SESSION['user_id']}', '{$params['otvet']}')";
                        $base->query($sql);

                            $code = $this->randomCode();
                            $date_generation = date('Y-m-d H:i:s');
                            $sql = "INSERT INTO `code` (`code`, `user_id`, `days`, `category`, `date_generation`)
                                    VALUES ('{$code}', '{$_SESSION['user_id']}', '{$params['days']}', '{$params['category']}', '{$date_generation}')";

                            if ($base->query($sql)) return array('success'=> 'Ключ получен', 'key' => $code);
                                else return array('errors' =>array('sql_error'=> 'В данный момент получить код невозможно. Попробуйте позже.'));

                        return array('errors' =>array('otvet'=> 'Не правильный ответ на вопрос'));
                    }
                    return array('errors' => $params['valid_errors']);


                }


            }else{
                return array('errors' =>array('sql_error'=> 'В данный момент получить код невозможно. Попробуйте позже.'));
            }
        }else{
            return array('errors' =>array('sql_error'=> 'Вы уже получали бесплатный код доступа. Получение бесплатного промокода для вас временно не доступно.'));
        }
        
    }
    
    
    
    /*
     * 24-11-2014
     * Редактирование пароля
     * roy
     */
    public function editPass($params){
        $base = new mysqlClass;
        $params = $base->validate($params, $rules = array(
            'required' => 'id_user, password',
            'string' => 'id_user, password'
        ));
        
        if(!empty($params['valid_errors'])){
            return array('errors' => $params['valid_errors']);
        }
        
        $password = md5($params['password']);
        
        $sql = "UPDATE `users` SET `password` = '{$password}' WHERE `id_user` = '{$params['id_user']}'";
        $result = $base->query($sql);
        
        if($result){
            return array('success' => 'Пароль отредактирован');
        }else{
            return array('errors' => 'ошибка БД');
        }
        
    }
    
}
