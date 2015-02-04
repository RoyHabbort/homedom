<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of codeController
 *
 * @author Рой
 */
class codeController extends controllerClass{
    
    
    public function index(){
        
        
    }
    
    
    public function getcode($params) {
        
        $users = new users();
        $model = new admin();
        $ifGetCode = $users->ifGetCode();
        $countGet = $model->countDistrKey();
        $object = new Object();
        $allCity = $object->getAllCity();
//        if($ifGetCode){
            heretic::$_config['titlePage'] = 'Получить код';
            
            if(!empty($_POST)){
                
                if($countGet>0){
                   $result = $users->generateCodeByVopros($_POST); 
                }
                if (!empty($_SESSION['phone'])) $date_user = $users->getPersonalInfo();
                if (empty($result['errors'])){
                    if($_POST['type_receive'] == 'Email') {
                        $compil = 2;
                        $mail = new mail();
                        $mail->sendMail('distribution', $date_user['email'], $date_user['fio'], array('key' => $result['key']));
                    }else{
                        $mail = new mail();
                        $mail->sendSMS('distribution', $date_user['phone'], array('key' => $result['key']));
                        $compil = 3;
                    }
                    $location = '/users/complite/' . $compil;
                    header( "Location: {$location}", true, 303);
                }else{
                    $distr = $model->getDistrKey();
                    $this->render('getcode', array('errors' => $result['errors'], 'post' => $_POST, 'countGet' => $countGet, 'all_city' => $allCity)); 
                }
            
            }else{
                
                $distr = $model->getDistrKey();
                $this->render('getcode', array('countGet' => $countGet, 'all_city' => $allCity));
            }
//        }else{
//            $location = '/';
//            header( "Location: {$location}", true, 303); 
//        }
        
        
    }
    
    
    
    
}
