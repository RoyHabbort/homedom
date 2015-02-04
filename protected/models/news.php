<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of news
 *
 * @author Рой
 */
class news {
    
    public function getNew($id) {
        $params['id'] = $id;
        $base = new mysqlClass();
        $params = $base->validate($params, array(
                    'string' => 'id',
                    ));
        if (empty($params['valid_errors'])){
         
            $sql = "SELECT * FROM `news` WHERE `id` = '{$id}'";
            $result = $base->query($sql);

            if($result){
                return $result[0];
            }else{
                return false;
            }
        }else{
            return false;
        }
        
    }
    
    public function getTitle($id){
        $base = new mysqlClass();
        $sql = "SELECT `title` FROM `page` WHERE `link` = '{$id}'";
        $result = $base->query($sql);
        
        if($result){
            return $result[0]['title'];
        }else{
            return false;
        }
    }
    
    public function getAllNews(){
        $base = new mysqlClass();
        $sql = "SELECT * FROM `news` WHERE 1 ORDER BY `date` DESC, `id` DESC";
        $result = $base->query($sql);
        
        if($result){
            return $result;
        }else{
            return false;
        }
    }
    
    
    public function getMainImage(){
        $base = new mysqlClass();
        $sql = "SELECT `image`, `title`, `id` FROM `news` WHERE `for_main` = 1";
        $result = $base->query($sql);
        
        if(empty($result)){
            $sql = "SELECT `image`, `title`, `id_blog` FROM `blog` WHERE `for_main` = 1";
            $result = $base->query($sql);
            if(!empty($result)){
                $result = $result[0];
                $result['id'] = $result['id_blog'];
            }
            
        }else{
            $result = $result[0];
        }
        
        if (!empty($result)) return $result;
            else return false;
    }
    
    
}
