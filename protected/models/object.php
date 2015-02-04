<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of object
 *
 * @author Рой
 */
class object extends modelsClass{
   
    
    
    /*
     * 19-08-2014
     * Roy
     * Выдача одного объявления
     */
    public function getObject($id){
        if (($id != 0) &&!empty($id) ){
            $params['id'] = $id;
            $base = new mysqlClass();
            $params = $base->validate($params, array(
                    'string' => 'id',
                    ));
            $current_date = date('Y-m-d H:i:s');
            $sql = "SELECT o.id, o.category, t.type, c.city, d.district, o.street, o.home, o.apartament, o.public_square,
                    o.life_square, o.price, o.comment, o.date_create, o.user_id, o.time_start, o.time_end, u.email,
                    u.phone, u.fio, u.rules, u.city, u.date_registration, u.date_visited, o.main_image, o.floor, o.floor_all, o.kitchen
                    FROM `object` o
                    LEFT JOIN `city` c ON c.id_city = o.city
                    LEFT JOIN `district` d ON d.id_district = o.district
                    LEFT JOIN `type_object` t ON t.id_type = o.type
                    LEFT JOIN `users` u ON u.id_user = o.user_id
                    WHERE o.id = '{$params['id']}' AND u.rules >= 1 AND Datediff('{$current_date}', o.date_edit) <= 30";
            $result = $base->query($sql);
            
            if($result){
                /*Вывод фотогалереи*/
                $sql = "SELECT `id_photo`, `photo` FROM `photogallery` WHERE `object_id` = '{$result[0]['id']}'";
                $result[0]['photo'] = $base->query($sql);


                /*просмотр страницы*/
                if(!empty($result[0]['category'])){
                    $date_browsing = date('Y-m-d H:i:s');
                    $user_browsing = (!empty($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0 ;
                    $sql = "INSERT INTO `browsing` (`id_object`, `date_browsing`, `id_user`) VALUES ('{$result[0]['id']}', '{$date_browsing}', '{$user_browsing}')";
                    $base->query($sql);
                }

                /*запись на объявление*/
                if (!empty($_SESSION['phone'])){
                    $sql = "SELECT * FROM `schedule` WHERE `object_id` = '{$params['id']}' AND `user_phone` = '{$_SESSION['phone']}' AND `time` > '{$current_date}'";
                    $schedule = $base->query($sql);
                    if ($schedule) $result[0]['schedule'] = $schedule[0]; 
                        else $result[0]['schedule'] = 0;
                }

                /*all time schedule(
                 * 18-08-2014
                 * Roy
                 */

                $sql = "SELECT `time` FROM `schedule` WHERE `object_id` = '{$params['id']}'";
                $result[0]['time'] = $base->query($sql);

                if ($result) return $result[0];
                    else return false;
            }else return false;
            
        } else{return false;}   
    }
    
    
    /*
     * 19-08-2014
     * Roy
     * Создание объявления
     */
    
    public function addObjects($params){
        
        $base = new mysqlClass();
        $count = count($params);
        
        if(!empty($_SESSION['phone'])){
            
//            if(($params['category'] == 'buy')||($params['category']) == 'rentals'){
//                
//                $_FILES = '';
//                $params['street'] = '';
//                $params['home'] = '';
//                $params['apartament'] = '';
//                
//                $params = $base->validate($params, array(
//                    'required' => 'category, type, city, district, price',
//                    'string' => 'category, type, city, district, comment',
//                    'number' => 'public_square, life_square, price',
//                ));
//                
//            }else{
                
            $params = $base->validate($params, array(
                'required' => 'category, type, city, street, home, price',
                'string' => 'category, type, city, district, street, home, apartament, comment',
                'number' => 'public_square, life_square, kitchen, price, floor_all',
                'numb-code' => 'floor'
            ));
                
            if (empty($params['valid_errors'])){
                
                $date_create = date('Y-m-d H:i:s');
                $sql = "INSERT INTO `object` 
                        (`category`, `type`, `city`, `district`, `street`, `home`, `apartament`, `public_square`, `life_square`, `kitchen`, `price`, `comment`, `user_id`, `date_create`, `date_edit`, `floor`, `floor_all`) 
                        VALUES ('{$params["category"]}', '{$params["type"]}', '{$params["city"]}', '{$params["district"]}', '{$params["street"]}', '{$params["home"]}', '{$params['apartament']}',
                        '{$params['public_square']}', '{$params['life_square']}', '{$params['kitchen']}', '{$params['price']}', '{$params['comment']}', '{$_SESSION['user_id']}', '{$date_create}', '{$date_create}',
                        '{$params['floor']}', '{$params['floor_all']}')";
                $result = $base->query($sql); 
                $last_id = $base->last_insert_id();
                $schedule = array(
                    'from' => $params['from'],
                    'to' => $params['to'],
                    'object_id' => $last_id
                );
                $this->addSchedule($schedule);
                
                if (!$result) return array('errors' => array('sql_error' => 'В данный момент подать объявление невозможно.'));
                    else{
                        
                        $date = date('Y-m-d H:i:s');
                        
                        for($i = 0; $i< $count; $i++){
                            if(!empty($params['collection-'.$i])){
                                $this->photoCollection($params['collection-'.$i], $last_id);
                            }
                        }
                        
                        if(!empty($params['collection-0'])){
                            $this->photoMain($params['collection-0'], $last_id);
                        }
                        
                        return array('last_id' => $last_id);   
                    }

            }else{
                return array('errors' => $params['valid_errors']);
            }
            
        }else{
            
            
//            if(($params['category'] == 'buy')||($params['category']) == 'rentals'){
//                
//                $_FILES = '';
//                $params['street'] = '';
//                $params['home'] = '';
//                $params['apartament'] = '';
//                
//                $params = $base->validate($params, array(
//                    'required' => 'category, type, city, district, price, fio, phone, password, password_a, email',
//                    'string' => 'category, type, city, district, comment, fio, phone, password, password_a, description, email',
//                    'number' => 'public_square, life_square, price',
//                    'equal' => 'password, password_a',
//                    'email' => 'email',
//                    'phone' => 'phone',
//                ));
//                
//            }else{
                
            $params = $base->validate($params, array(
                'required' => 'category, type, city, street, home, price, fio, phone, password, password_a, email, user_city',
                'string' => 'category, type, city, district, street, home, apartament, comment, fio, phone, password, password_a, city, email, user_city',
                'equal' => 'password, password_a',
                'number' => 'public_square, life_square, kitchen, price, floor_all',
                'email' => 'email',
                'phone' => 'phone',
                'numb-code' => 'floor'
            ));
            
            
            $sql = "SELECT * FROM `users` WHERE `phone` = '{$params['phone']}'";
            if($base->query($sql)) $params['valid_errors']['phone'] = 'С данного телефона регистрация уже проводилась';
            
            
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
                
                $date_create = date('Y-m-d H:i:s');
                $sql = "INSERT INTO `object` 
                        (`category`, `type`, `city`, `district`, `street`, `home`, `apartament`, `public_square`, `life_square`, `kitchen`, `price`, `comment`, `user_id`, `date_create`, `date_edit`, `floor`, `floor_all`) 
                        VALUES ('{$params["category"]}', '{$params["type"]}', '{$params["city"]}', '{$params["district"]}', '{$params["street"]}', '{$params["home"]}', '{$params['apartament']}',
                        '{$params['public_square']}', '{$params['life_square']}', '{$params['kitchen']}', '{$params['price']}', '{$params['comment']}', '{$_SESSION['user_id']}', '{$date_create}', '{$date_create}',  '{$params['floor']}', '{$params['floor_all']}')";
                echo $sql;        
                if (!$base->query($sql)) return array('errors' => array('sql_error' => 'В данный момент подать объявление невозможно.'));
                
                
                $last_id = $base->last_insert_id();
                $date = date('Y-m-d H:i:s');
                
                
                for($i = 0; $i< $count; $i++){
                    if(!empty($params['collection-'.$i])){
                        $this->photoCollection($params['collection-'.$i], $last_id);
                    }
                }
                
                if(!empty($params['collection-0'])){
                    $this->photoMain($params['collection-0'], $last_id);
                }
                
                $schedule = array(
                    'from' => $params['from'],
                    'to' => $params['to'],
                    'object_id' => $last_id
                );
                $this->addSchedule($schedule);
                
                
                
                return array('last_id' => $last_id);
            }else{
                return array('errors' => $params['valid_errors']);
            }
            
        }
        
    }
    
    
    private function photoMain($params, $id_object){
        $base = new mysqlClass();
        
        $sql = "SELECT `main_image` FROM `object` WHERE `id` = '{$id_object}' LIMIT 1";
        $image = $base->query($sql);
        if(empty($image)){
            $sql = "SELECT `photo` FROM `photogallery` WHERE `id_photo` = '{$params}' LIMIT 1";
            $result = $base->query($sql);

            $sql = "UPDATE `object` SET `main_image` = '{$result}' WHERE `id` = '{$id_object}'";
            $base->query($sql);
        }
        
        
    }
    
    private function photoCollection($params, $id_object){
        $base = new mysqlClass();
        if(!is_array($params)){
            $sql = "UPDATE `photogallery` SET `object_id` = '{$id_object}' WHERE `id_photo` = '{$params}'";
            $base->query($sql);
        }else{
            foreach($params as $key => $value){
                $sql = "UPDATE `photogallery` SET `object_id` = '{$id_object}' WHERE `id_photo` = '{$value}'";
                $base->query($sql);
            }
        }
          
    }
    
    
    /*
     * 19-08-2014
     * roy
     * Редактирование объявления
     */
    public function editObject($params, $id){
        $params['id'] = $id;
        $count = count($params);
        $base = new mysqlClass();
        $params = $base->validate($params, array(
                'required' => 'id, category, type, city,  street, home, price',
                'string' => 'id, category, type, city, district, street, home, apartament, comment',
                'number' => 'public_square, life_square, kitchen, price, floor_all',
                'numb-code' => 'floor'
                ));
        
        if (empty($params['valid_errors'])){
            $date_edit = date('Y-m-d H:i:s');
            
            $sql = "UPDATE `object` 
                    SET `category` = '{$params["category"]}', `type` = '{$params["type"]}', `city` = '{$params["city"]}', 
                    `district` = '{$params["district"]}', `street` = '{$params["street"]}', `home` = '{$params["home"]}',
                    `apartament` = '{$params['apartament']}', `public_square` = '{$params['public_square']}', `kitchen` = '{$params['kitchen']}', `moderation` = 0,
                    `life_square` = '{$params['life_square']}', `price` = '{$params['price']}', `comment` = '{$params['comment']}', 
                    `floor` = '{$params['floor']}', `floor_all` = '{$params['floor_all']}', `date_edit` = '{$date_edit}' WHERE `id` = '{$params['id']}'";
            if (!$base->query($sql)) return array('errors' => array('sql_error' => 'В данный момент редактирование объявления невозможно.'));
                else{
                    
                    $last_id = $params['id'];
                    
                    $schedule = array(
                        'from' => $params['from'],
                        'to' => $params['to'],
                        'object_id' => $params['id']
                    );
                    
                    for($i = 0; $i< $count; $i++){
                        if(!empty($params['collection-'.$i])){
                            $this->photoCollection($params['collection-'.$i], $last_id);
                        }
                    }
                    
                    if(!empty($params['collection-0'])){
                        $this->photoMain($params['collection-0'], $last_id);
                    }
                    
                    $this->addSchedule($schedule);
                    return array('success' => 'Объявление успешно обновлено');   
                }

        }else{
            return array('errors' => $params['valid_errors']);
        }
    }
    
    
    /*
     * 19-08-2014
     * roy
     * выдача всех объявлений
     */
    public function getAllObjects(){
        $base = new mysqlClass();
        $sql = 'SELECT * 
                FROM `object` o 
                LEFT JOIN `type_object` t ON o.type = t.id_type 
                WHERE 1 
                ORDER BY `date_create` DESC';
        return $base->query($sql);
    }
    
    /*
     * 19-08-2014
     * roy
     * выдача всех объявлений текущего пользователя
     */
    public function getUserObject(){
        $base = new mysqlClass();
        $current_date = date('Y-m-d H:i:s');
        //$pre_sql = "UPDATE `object` SET `moderation` = '-1' WHERE Datediff('{$current_date}', `date_edit`) > 30 AND `moderation` > 0 ";
        //$base->query($pre_sql);
        $sql = "SELECT * 
                FROM `object` o
                WHERE o.user_id = '{$_SESSION['user_id']}'
                ORDER BY `date_create` DESC";
        $result = $base->query($sql);
        return $result;
    }
    
    
    public function getCountSchedule($id){
        $params['id'] = $id;
        $base = new mysqlClass();
        
        $params = $base->validate($params, $rules = array(
                'string' => 'id',
            ));
        
        $sql = "SELECT count(*)
                FROM `schedule` 
                WHERE `object_id` = '{$params['id']}' LIMIT 1";
        return $base->query($sql);
    }
    
    
    /*
     * 19-08-2014
     * roy
     * выдача одного объявления текущего пользователя
     */
    public function getUserObjectId($id){
        $params['id'] = $id;
        
        $base = new mysqlClass();
        $params = $base->validate($params, array(
                'string' => 'id',
                ));
        
        $sql = "SELECT * 
                FROM `object` o
                WHERE o.id = '{$params['id']}' AND o.user_id = '{$_SESSION['user_id']}'";
        $result = $base->query($sql);
        
        $sql = "SELECT `id_photo`, `photo` FROM `photogallery` WHERE `object_id` = '{$result[0]['id']}'";
        $result[0]['photo'] = $base->query($sql);
        
        if ($result) return $result[0];
            else return false;
    }
    
    /*
     * 19-08-2014
     * roy
     * выдача избранного текущего пользователя
     */
    
    public function getUserFavorites(){
        $base = new mysqlClass();
        $sql = "SELECT * FROM `object` o
                INNER JOIN `favorites` f ON f.object_id = o.id
                INNER JOIN `type_object` t ON t.id_type = o.type
                WHERE f.user_id = '{$_SESSION['user_id']}'
                ORDER BY `date_create` DESC";
        $result = $base->query($sql);
        if($result){return $result;
        }else return false;
    }
    
    /*
     * 19-08-2014
     * roy
     * добавить объявление в избранное
     */
    
    public function addFavorites($id){
        $params['id'] = $id;
        $base = new mysqlClass();
        $params = $base->validate($params, array(
                'string' => 'id',
                ));
        $sql = "INSERT INTO `favorites` (`user_id`, `object_id`) VALUES ('{$_SESSION['user_id']}', '{$params['id']}')";
        if ($base->query($sql)) return true;
            else return false;
    }
    
    /*
     * 19-08-2014
     * roy
     * удалить объявление из избранного
     */    
    public function removeFavorites($id){
        $params['id'] = $id;
        $base = new mysqlClass();
        $params = $base->validate($params, array(
                'string' => 'id',
                ));
        
        $sql = "DELETE FROM `favorites` WHERE `user_id` = '{$_SESSION['user_id']}' AND `object_id` = '{$params['id']}'";
        if ($base->query($sql)) return true;
            else return false;
    }
    
    /*
     * 19-08-2014
     * roy
     * если уже в избранном
     */
    public function ifFavorites($id){
        $params['id'] = $id;
        $base = new mysqlClass();
        $params = $base->validate($params, array(
                'string' => 'id',
                ));
        $sql = "SELECT * FROM `favorites` WHERE `user_id` = '{$_SESSION['user_id']}' AND `object_id` = '{$params['id']}'";
        if ($base->query($sql)) return 1;
            else return 0;
    }
    
    /*
     * 19-08-2014
     * roy
     * Выдать количество раз добавленний объявления в избранное
     */
    public function getCountFavorites($id){
        $base = new mysqlClass();
        $sql = "SELECT `user_id` FROM `favorites` WHERE `object_id` = '{$id}'";
        return $base->numrows($sql);
    }
    
    /*
     * 19-08-2014
     * roy
     * получить телефон пользователя
     */
    public static function getUserPhone($id){
        $params['id'] = $id;
        $base = new mysqlClass();
        $params = $base->validate($params, array(
                'string' => 'id',
                ));
        $sql = "SELECT `phone` FROM `users` WHERE `id` = '{$params['id']}' LIMIT 1";
        $result = $base->query($sql);
        if ($result) return $result;
            else return false;
    }
    
    /*
     * 19-08-2014
     * roy
     * выдача дополнительных параметров объявления
     */
    public function getParamsAdd(){
        $result = array();
        $result['city'] = $this->getCity(); 
        $result['type'] = $this->getType();
        return $result;
    }
    
    /*
     * 19-08-2014
     * roy
     * получить список городов
     */
    public function getCity(){
        $base = new mysqlClass();
        $sql = "SELECT * FROM `city` WHERE 1";
        $result = $base->query($sql);
        if($result) return $result;
            else return false;
    }
    
    /*
     * 19-08-2014
     * roy
     * получить список районов города
     */
    public function getDistrict($city){
        $params['city'] = $city;
        $base = new mysqlClass();
        $params = $base->validate($params, array(
                'string' => 'city',
                ));
        $sql = "SELECT * FROM `district` WHERE `city_id` = '{$params['city']}'";
        $result = $base->query($sql);
        if($result) return $result;
            else return false;
    }
    
    /*
     * 19-08-2014
     * roy
     * получить список типов объявления
     */
    public function getType(){
        $base = new mysqlClass();
        $sql = "SELECT * FROM `type_object` WHERE 1";
        $result = $base->query($sql);
        if($result) return $result;
            else return false;
    }
    
    /*
     * 19-08-2014
     * roy
     * получить число просмотров объявления
     */
    public function getCountBrowsing($id){
        $base = new mysqlClass();
        $sql = "SELECT * FROM `browsing` b
                INNER JOIN `object` o ON b.id_object = o.id
                WHERE b.id_object = '{$id}' AND b.id_user != o.user_id ";
           
        $result = $base->numrows($sql);
        if($result) return $result;
            else return 0;
    }
    
    /*
     * 19-08-2014
     * roy
     * получить число просмотров объявления за день
     */
    public function getCountBrowsingDay($id){
        $base = new mysqlClass();
        $today = date('Y-m-d');
        $sql = "SELECT * FROM `browsing` b
                INNER JOIN `object` o ON b.id_object = o.id
                WHERE b.id_object = '{$id}' AND b.id_user != o.user_id AND b.date_browsing > '{$today}' ";
        $result = $base->numrows($sql);
        if($result) return $result;
            else return 0;
    }
    
    /*
     * 19-08-2014
     * roy
     * Добавить удобное время просмотра
     */
    public function addSchedule($params){
        $base = new mysqlClass();
           
        $params = $base->validate($params, array(
                'required' => 'from, to, object_id',
                'string' => 'from, to, object_id',
                ));
        
        if((empty($params['valid_errors'])) && (strtotime($params['from'])<strtotime($params['to']))){
            $sql = "UPDATE `object` SET `time_start` = '{$params['from']}', `time_end` = '{$params['to']}' WHERE `id` = '{$params['object_id']}'";
            $base->query($sql);
            return true;
        }else return false;
    }
    
    /*
     * 19-08-2014
     * roy
     * Добавить клиента на просмотр квартиры в определённое время
     */
    public function addClientSchedule($params){
        $base = new mysqlClass();
        $params = $base->validate($params, array(
                'required' => 'time, id',
                'string' => 'time, id',
                ));
        
        if (empty($params['valid_errors'])){
            $sql = "INSERT INTO `schedule` (`object_id`, `user_phone`, `time`) VALUES ('{$params['id']}', '{$_SESSION['phone']}', '{$params['time']}')";
            if($base->query($sql)) return true;
                else return false;
        }else return false;
        
    }
    
    /*
     * 19-08-2014
     * roy
     * Получить текущее время просмотра квартиры
     */
    public function getScheduleAll(){
        $base = new mysqlClass();
        
        $sql = "SELECT * FROM `schedule` s
                INNER JOIN `object` o ON s.object_id = o.id
                INNER JOIN `users` u ON u.phone = s.user_phone 
                WHERE o.user_id = '{$_SESSION['user_id']}' ORDER BY s.time ASC ";
        $result = $base->query($sql);
        if($result) return $result;
            else false;
    }
    
    
    /*
     * 1-09-2014
     * Получение всех записей куда вы записаны на просмотр
     * roy
     */
    
    public function getMySchedule(){
        $base = new mysqlClass();
        $current_date = date('Y-m-d H:i:s');
        $sql = "SELECT * FROM `schedule` s
                INNER JOIN `object` o ON s.object_id = o.id
                LEFT JOIN `type_object` t ON o.type = t.id_type
                WHERE s.user_phone = '{$_SESSION['phone']}' AND `time` > '{$current_date}' ORDER BY `time` ASC";
        $result = $base->query($sql);
        if($result) return $result;
            else false;
    }
    
    
    /*
     * 19-08-2014
     * roy
     * Выдать все квартиры используя фильтр
     */
    public function getAllObjectByFilter($category=''){
        /*параметры поиска*/
        if(!empty($category)) $_SESSION['postSearch']['category'] = $category;
        $where = '';
        if(!empty($_SESSION['postSearch']['category'])) $where .= " AND `category` = '{$_SESSION['postSearch']['category']}' ";
        if(!empty($_SESSION['postSearch']['city'])) $where .= " AND o.`city` = '{$_SESSION['postSearch']['city']}' ";
        if(!empty($_SESSION['postSearch']['district'])) $where .= " AND `district` = '{$_SESSION['postSearch']['district']}' ";
        if(!empty($_SESSION['postSearch']['type'])) $where .= " AND o.`type` = '{$_SESSION['postSearch']['type']}' ";
        
        if(!empty($_SESSION['postSearch']['square_min'])) $where .= " AND `public_square` >= '{$_SESSION['postSearch']['square_min']}' ";
        if(!empty($_SESSION['postSearch']['square_max'])) $where .= " AND `public_square` <= '{$_SESSION['postSearch']['square_max']}' ";
        if(!empty($_SESSION['postSearch']['price_min'])) $where .= " AND `price` >= '{$_SESSION['postSearch']['price_min']}' ";
        if(!empty($_SESSION['postSearch']['price_max'])) $where .= " AND `price` <= '{$_SESSION['postSearch']['price_max']}' ";
        
        $current_date = date('Y-m-d H:i:s');
        $base = new mysqlClass();
        $sql = "SELECT * 
                FROM `object` o 
                LEFT JOIN `type_object` t ON o.type = t.id_type 
                LEFT JOIN `city` c ON c.id_city = o.city 
                LEFT JOIN `users` u ON o.user_id = u.id_user
                WHERE 1" . $where . " AND u.rules >= 1 AND Datediff('{$current_date}', `date_edit`) <= 30 AND `moderation` >= 1 ORDER BY `date_create` DESC";      
        $result = $base->query($sql);        
              
        foreach ($result as $key => $value) {
            
            $result[$key]['cordin'] = $this->getCoordinatById($value['id']);
            
        }   
        
        return $result;
    }
    
    /*
     * 19-08-2014
     * roy
     * Работа с фильтром поиска квартир
     */
    public function postSearch($params){
        
        $_SESSION['postSearch'] = '';
        
        $base = new mysqlClass();
        $params = $base->validate($params, array(
                'string' => 'category',
                'number' => 'square_min, square_max, price_min, price_max',
                ));
        
        if(empty($params['valid_errors'])){
            $_SESSION['postSearch'] = $params;
            return true;
        }else{
            return false;
        }
        
    }
    
    
    public function accessObject($id){
        if ((($id != 0) &&!empty($id))||(empty($_SESSION['phone']))){
            $params['id'] = $id;
            $base = new mysqlClass();
            $params = $base->validate($params, array(
                    'string' => 'id',
                    ));
            
            $current_date = date('Y-m-d H:i:s');
            $sql = "SELECT c.date_activate, c.days
                    FROM `code` c
                    INNER JOIN `object` o ON o.category = c.category
                    WHERE o.id = '{$id}' AND c.user_id = '{$_SESSION['user_id']}' AND Datediff('{$current_date}', c.date_activate) <= c.days";
            if ($base->numrows($sql)) return true;
                else return false;
            return true;
        }else return false;    
    }
    
    
    /*
     * 27-08-2014
     * roy
     * Получение координат по адресу
     */
    public function getCoord($params){
        $base = new mysqlClass();
        $params = $base->validate($params, $rules = array(
                'required' => 'address',
                'string' => 'address',
                ));
        if(empty($params['valid_errors'])){
            $sql = "SELECT * FROM `object_coord` WHERE `address` = '{$params['address']}' ORDER BY `date` DESC";
            $result = $base->query($sql);
            if ($result) return $result[0];
                else return false;
        }else{
            return false;
        }
        
        
    }
    
    
    public function getCoordByCity($params){
        $base = new mysqlClass();
        $params = $base->validate($params, $rules = array(
                'required' => 'city',
                'string' => 'city',
                ));
        if(empty($params['valid_errors'])){
            $sql = "SELECT * FROM `city` WHERE `id_city` = '{$params['city']}'";
            $result = $base->query($sql);
            if ($result) return $result[0];
                else return false;
        }else{
            return false;
        }
        
    }
    
    
    /*
     * 27-08-2014
     * roy
     * Запись координат по адресу
     */
    public function setCoord($params){
        $base = new mysqlClass();
        $params = $base->validate($params, $rules = array(
                'required' => 'address, cx, cy, id',
                'string' => 'address, cx, cy, id',
                ));
        if(empty($params['valid_errors'])){
            $date = date('Y-m-d H:i:s');
            $sql = "INSERT INTO `object_coord` (`address`, `coord_x`, `coord_y`, `object_id`, `date`) VALUES ('{$params['address']}', '{$params['cx']}', '{$params['cy']}', '{$params['id']}', '{$date}')";
            $result = $base->query($sql);
            if ($result) return $result;
                else return false;
        }else{
            return false;
        }
        
        
    }
    
    
    public function accessCategory($category =''){
        $base = new mysqlClass();
        if (!empty($_SESSION['phone'])){
            if (!empty($category)){
                $params['category'] = $category;

                $params = $base->validate($params, array(
                        'string' => 'category',
                        ));

                $current_date = date('Y-m-d H:i:s');
                $sql = "SELECT c.date_activate, c.days
                        FROM `code` c
                        INNER JOIN `users` u ON u.id_user = c.user_id
                        WHERE c.category = '{$params['category']}' AND u.phone = '{$_SESSION['phone']}' AND Datediff('{$current_date}', c.date_activate) <= c.days";

                if ($base->numrows($sql)) return true;
                    else return false;
                return true;
            }else{
                $current_date = date('Y-m-d H:i:s');
                $sql = "SELECT c.date_activate, c.days
                    FROM `code` c
                    INNER JOIN `users` u ON u.id_user = c.user_id
                    WHERE u.phone = '{$_SESSION['phone']}' AND Datediff('{$current_date}', c.date_activate) <= c.days";
                if ($base->numrows($sql)) return true;
                    else return false;    
            }  
        }return false;
          
    }
    
    
    public function getInfoSMS($params){
        $base = new mysqlClass();
        $params = $base->validate($params, array(
                'required' => 'time, id',
                'string' => 'time, id',
                ));
        
        if (empty($params['valid_errors'])){
            $sql = "SELECT u.phone, t.type, o.street, o.home 
                    FROM `object` o 
                    INNER JOIN `type_object` t ON t.id_type = o.type 
                    INNER JOIN `users` u ON u.id_user = o.user_id  
                    WHERE o.id = '{$params['id']}'";
            $result = $base->query($sql);
            $result = $result[0];
            $sql2 = "SELECT * FROM `users` WHERE `id_user` = '{$_SESSION['user_id']}'";
            $result['user'] = $base->query($sql2);
            $result['user'] = $result['user'][0];
            if($result) return $result;
                else return false;
        }else return false;
        
    }
    
    
    public function ifSchedule($params){
        
        $base = new mysqlClass();
        $params = $base->validate($params, $rules = array(
            'required' => 'date, id',
            'string' => 'date, id',
            ));
        
        $date_max = $params['date'] + strtotime("+1 day");
        $date_max = date('Y-m-d', $date_max);
        
        if (empty($params['valid_errors'])){
            $sql = "SELECT * FROM `schedule` WHERE `object_id` = '{$params['id']}' AND `time` > '{$params['date']}' AND `time` < '{$date_max}'";
            $result = $base->query($sql);
            if ($result) return $result;
                else return NULL;
        }else{
            return NULL;
        }
        
    }
    
    public function accessCat($category){
        if ((!empty($category))&&(!empty($_SESSION['phone']))){
            if (!empty($_SESSION['rules'])) {
                if ($_SESSION['rules'] >=3){return true;}
            }    
            $params['category'] = $category;
            $base = new mysqlClass();
            $params = $base->validate($params, array(
                    'string' => 'category',
                    ));
            
            $current_date = date('Y-m-d H:i:s');
            $sql = "SELECT c.date_activate, c.days
                    FROM `code` c
                    INNER JOIN `users` u ON u.id_user = c.user_id
                    WHERE c.category = '{$params['category']}' AND u.phone = '{$_SESSION['phone']}' AND Datediff('{$current_date}', c.date_activate) <= c.days";
            if ($base->numrows($sql)) return true;
                else return false;
        }else return false;    
    }
    
    
    public function getCoordinatById($id){
        $params['id'] = $id;
        $base = new mysqlClass();
        $params = $base->validate($params, $rules = array(
            'required' => 'id',
            'string' => 'id',
            ));
        if (empty($params['valid_errors'])){
            $sql = "SELECT * FROM `object_coord` WHERE `object_id` = '{$params['id']}' ORDER BY `date` DESC";
            $result = $base->query($sql);
            if($result) return $result[0];
                else return NULL;
        }else{
            return NULL;
        }
        
    }
    
    public function uploadFile(){
        
        $output_dir = "/assets/";
        if(isset($_FILES["photogallery"]))
        {
                $ret = array();

        //	This is for custom errors;	
        /*	$custom_error= array();
                $custom_error['jquery-upload-file-error']="File already exists";
                echo json_encode($custom_error);
                die();
        */
                $error =$_FILES["photogallery"]["error"];
                //You need to handle  both cases
                //If Any browser does not support serializing of multiple files using FormData() 
                if(!is_array($_FILES["photogallery"]["name"])) //single file
                {   
                    
                    $width = 1024;
                    $image = $this->uploadFrontImage("photogallery", $width);
                    if ($image) {
                        $ret[] = $image;
                    } else $ret['error'] = "Неправильный формат картинки";
                    
                        
                }
                else  //Multiple files, file[]
                {
                    $fileCount = count($_FILES["photogallery"]["name"]);
                    for($i=0; $i < $fileCount; $i++)
                    {
                        $width = 1024;
                        $image = $this->uploadFileMany();
                        if ($image) {
                            $ret[] = $image;
                        } else $ret['error'] = "Неправильный формат картинки";
                    }

                }
                $date = date('Y-m-d h:i:s');
                
                $id = array();
                
                foreach ($ret as $key => $value) {
                    $base = new mysqlClass();
                    $sql = "INSERT INTO `photogallery` (`photo`, `date`) VALUE ('{$value}', '{$date}')";
                    $base->query($sql);
                    $id[]=$base->last_insert_id();
                }    
                
            return $id;
        }
        
    }
    
    
    public function itIsMyObject($id){
        $params['id'] = $id;
        $base = new mysqlClass();
        $params = $base->validate($params, $rules = array(
            'required' => 'id',
            'string' => 'id',
            ));
        
        if (empty($params['valid_errors'])){
            
            $sql = "SELECT * FROM `object` WHERE `id` = '{$params['id']}' AND `user_id` = '{$_SESSION['user_id']}'";
            $result = $base->query($sql);
            
            if(!empty($result)) return true;
                else return false;
            
        }else return false;
        
    }
    
    
    public function deleteObject($params){
        
        $base = new mysqlClass();
        $params = $base->validate($params, $rules = array(
            'string' => 'id',
        ));
        
        if (empty($params['valid_errors'])){
            
            $sql = "DELETE FROM `object` WHERE `id` = '{$params['id']}' AND `user_id` = '{$_SESSION['user_id']}'";
            
            $result = $base->query($sql);
            if($result) return $result;
                else return false;
            
        }else return false;
        
    }
    
    
    public function removeObject($params){
        $base = new mysqlClass();
        $params = $base->validate($params, $rules = array(
            'string' => 'id',
        ));
        
        
        
        if (empty($params['valid_errors'])){
            $date = date('Y-m-d h:i:s');
            $sql = "UPDATE `object` SET `moderation` = '-2', `date_edit` = '{$date}' WHERE `id` = '{$params['id']}' AND `user_id` = '{$_SESSION['user_id']}'";
            $result = $base->query($sql);
            if($result) return $result;
                else return false;
            
        }else return false;
    }
    
    
    public function moveObject($params){
        $base = new mysqlClass();
        $params = $base->validate($params, $rules = array(
            'string' => 'id',
        ));
        
        if (empty($params['valid_errors'])){
            $date = date('Y-m-d h:i:s');
            $sql = "UPDATE `object` SET `moderation` = '0', `date_edit` = '{$date}' WHERE `id` = '{$params['id']}' AND `user_id` = '{$_SESSION['user_id']}'";
            $result = $base->query($sql);
            if($result) return $result;
                else return false;
            
        }else return false;
    }
    
    
    function getObjectUser($id){
        $params['id'] = $id;
        $base = new mysqlClass();
        $params = $base->validate($params, $rules = array(
           'string' => 'id', 
        ));
        
        $sql = "SELECT `user_id` FROM `object` WHERE `id` = '{$params['id'] }' LIMIT 1";
        $id_limit = $base->query($sql);
        
        $sql = "SELECT * FROM `object` o 
                INNER JOIN `type_object` t ON t.id_type = o.type 
                WHERE o.user_id = '{$id_limit}'";
        
        $result = $base->query($sql);        
        
        if($result){
            return $result;
        }else{
            return false;
        }
        
    }
    
    /*
     * 11-11-2014
     * Получение списка городов
     * roy
     */
    
    
    public function getAllCity(){
        
        $base = new mysqlClass();
        $sql = "SELECT * FROM `city` WHERE 1";
        return $base->query($sql);
        
    }
    
}
