<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of blog
 *
 * @author Рой
 */
class blog extends modelsClass{
    
    public function deleteBlog($idBlog){
        $params['id_blog'] = $idBlog;
        $base = new mysqlClass;
        $params = $base->validate($params, $rules = array(
            'required' => 'id_blog',
            'string' => 'id_blog',
            ));
        
        if(empty($params['valid_errors'])){
            $sql = "DELETE FROM `blog` WHERE `id_blog` = '{$params['id_blog']}'";
            $result = $base->query($sql);
        }else{
            return false;
        }
    }
    
    public function addBlog($params){
     
        $base = new mysqlClass();
        $params = $base->validate($params, $rules = array(
            'required' => 'title, text, category, metatitle',
            'string' => 'title, category',
            'text' => 'text'
            ));
        
        
        if(!empty($params['for_main'])){
            $for_main = 1;
        }else $for_main = 0;
        
        if (!empty($_FILES['image']["name"])){
            $imageClass = new imageClass();
            $image = $imageClass->uploadFrontImage('image', 340, false);
            if ($image) {
                $params['image'] = $image;
                $for_main = $for_main;
            }else{
                $params['valid_errors']['image'] = "Неправильный формат картинки";
                $for_main = 0;
            }
        }else{
            $params['image']='';
            $for_main = 0;
        }
        
        
        if (!empty($_FILES['files']['tmp_name'])){
            
            $max_uppload_size = 10;
            if(!($_FILES['files']['size'] > $max_uppload_size*1024*1024)){
                $info_file = pathinfo($_FILES['files']['name']);
                if($info_file["extension"]=='docx' || $info_file["extension"]== 'doc' 
                        || $info_file["extension"] == 'rtf' || $info_file["extension"] == 'pdf'
                        || $info_file["extension"] == 'txt'){
                    $uploaddir = heretic::$_path['files_dir'];
                    $prefix = uniqid();
                    $uploadfile = $uploaddir . $_FILES['files']['name'];

                    if (move_uploaded_file($_FILES['files']['tmp_name'], $uploadfile)) {
                        $params['files']=$uploadfile;
                    } else {
                        $params['valid_errors']['files'] = "Загрузить фаил не удалось";
                    }
                }else{
                    $params['valid_errors']['files'] = "Не верный формат файла ";
                }
            }else{
                $params['valid_errors']['files'] = "Фаил превышает домустимый размер " . $max_uppload_size . "МБ";
            }
            
        }else{
            $params['files']='';
        }
        $date = date('Y-m-d H:i:s');
        if(empty($params['valid_errors'])){

            if ($for_main){
                $sql = "UPDATE `news` SET `for_main` = '0' WHERE 1";
                $base->query($sql);
                $sql = "UPDATE `blog` SET `for_main` = '0' WHERE 1";
                $base->query($sql);
            }
       
            $sql = "INSERT INTO `blog` (`title`, `text`, `metatitle`, `category`, `files`, `image`, `date`, `for_main`) 
                    VALUES ('{$params['title']}', '{$params['text']}', '{$params['metatitle']}', '{$params['category']}', '{$params['files']}', '{$params['image']}', '{$date}', '{$for_main}')";
            $result = $base->query($sql);
            
            if ($result) return true;
                else return array('errors' => array ('sql_error' => 'В данный момент функция "Написать в блог" недоступна'));
        }else{
            return array('errors' => $params['valid_errors']);
        }
        
    }
    
    
    public function getBlog($category = ''){
        if (!empty($category)) $where_category = " AND `category` = '{$category}'";
            else $where_category = '';
        $base = new mysqlClass();
        $sql = "SELECT * FROM `blog` WHERE 1" . $where_category . " ORDER BY `date` DESC";
        return $base->query($sql);    
    }
    
    public function getBlogId($id){
        $params['id'] = $id;
        $base = new mysqlClass();
        $params = $base->validate($params, $rules = array('required'=> 'id', 'string' => 'id'));
        $sql = "SELECT * FROM `blog` WHERE `id_blog` = '{$params['id']}'";
        $result = $base->query($sql);
        if($result) return $result[0];
            else return false;
    }
    
    
    
    public function editBlog($params, $id){
        $params['id'] = $id;
        $base = new mysqlClass();
        
        
        
        $params = $base->validate($params, $rules = array(
            'required' => 'title, text, category, metatitle, id',
            'string' => 'title, category, id',
            'text' => 'text'
            ));
        
        if(!empty($params['for_main'])){
            $for_main = 1;
        }else $for_main = 0;
        
        $imageClass = new imageClass();
        if (!empty($_FILES['image']["name"])){
            $image = $imageClass->uploadFrontImage('image', 340, false);
            if ($image){
                $params['image'] = $image;
            }else {
                $params['valid_errors']['image'] = "Неправильный формат картинки";
            }
        }else{
            $params['image']='';
        }
       
        if (!empty($_FILES['files']['tmp_name'])){
            $info_file = pathinfo($_FILES['files']['name']);
            $max_uppload_size = 10;
            if(!($_FILES['files']['size'] > $max_uppload_size*1024*1024)){
                if($info_file["extension"]=='docx' || $info_file["extension"]== 'doc' 
                        || $info_file["extension"] == 'rtf' || $info_file["extension"] == 'pdf'
                        || $info_file["extension"] == 'txt'){
                    $uploaddir = heretic::$_path['files_dir'];
                    $uploadfile = $uploaddir . $_FILES['files']['name'];
                    
                    if (move_uploaded_file($_FILES['files']['tmp_name'], $uploadfile)) {
                        $params['files']=$uploadfile;
                    } else {
                        $params['valid_errors']['files'] = "Загрузить фаил не удалось";
                    }
                }else{
                    $params['valid_errors']['files'] = "Не верный формат файла ";
                    
                }
                
                
            }else{
                $params['valid_errors']['files'] = "Фаил превышает домустимый размер " . $max_uppload_size . "МБ";
            }
            
        }else{
            $params['files']='';
        }
        
        if(empty($params['valid_errors'])){
            
            if (!empty($params['image'])) $image = ", `image` = '{$params['image']}'";
                else $image = '';
                
            if (!empty($params['files'])) $files = ", `files` = '{$params['files']}'";
                else $files = '';
                
            if ($for_main){
                $sql = "UPDATE `news` SET `for_main` = '0' WHERE 1";
                $base->query($sql);
                $sql = "UPDATE `blog` SET `for_main` = '0' WHERE 1";
                $base->query($sql);
            }
            
            $sql = "UPDATE `blog`
                   SET `title` = '{$params['title']}', `text` = '{$params['text']}', `metatitle` = '{$params['metatitle']}',
                   `category` = '{$params['category']}', `for_main` = '{$for_main}' " . $files . $image ."
                   WHERE `id_blog` = '{$params['id']}'";
            
            $result = $base->query($sql);
            
            if ($result) return true;
                else return array('errors' => array ('sql_error' => 'В данный момент функция редактирования блога недоступна'));
        }else{
            return array('errors' => $params['valid_errors']);
        }
        
        
        
    }
    
    
    

    
}
