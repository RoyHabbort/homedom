<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of page
 *
 * @author Рой
 */
class page {
    
    public function getPage($id) {
        $base = new mysqlClass();
        $sql = "SELECT * FROM `page` WHERE `id` = '{$id}'";
        $result = $base->query($sql);
        
        if ($result){
            return $result[0];
        }else{
            return false;
        }
    }
    
    public function editPage($params, $id){
        $params['id'] = $id;
        $base = new mysqlClass();
        
        $params = $base->validate($params, $rules = array(
            'required' => 'id, title, text',
            'string' => 'id, title',
            'text' => 'text',
            ));
        
        if(empty($params['valid_errors'])){
            $sql = "UPDATE `page` SET `title` = '{$params['title']}', `text` = '{$params['text']}' WHERE `id` = '{$params['id']}'";
            $result = $base->query($sql);
            if ($result) return true;
                else return array('errors' => array('sql_error' => 'Невозможно отредактировать новость в данный момент'));
        }else{
            return array('errors'=> $result['valid_errors']);
        }
        
    }
    
    
    
}
