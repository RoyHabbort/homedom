<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mail
 *
 * @author Рой
 */
class mail extends PHPMailer{
    
    private function configMail($type){
        $base = new mysqlClass();
        $sql = "SELECT * FROM `mail` WHERE `mail_type` = '{$type}'";
        $result = $base->query($sql);
        $this->From = $result[0]['from_email'];
        $this->FromName = $result[0]['from_name'];
        $this->Subject = $result[0]['subject'];
        return $result[0]['templete'];
    }
    
    private function configSMS($type){
        $base = new mysqlClass();
        $sql = "SELECT * FROM `mail` WHERE `mail_type` = '{$type}'";
        $result = $base->query($sql);
        
        return $result[0]['templete'];
    }
    
    public function sendMailAll($type, $arguments){
        $template = $this->configMail($type);
        $this->Body = $this->$template($arguments);
        $this->isHTML(true);
        
        $base = new mysqlClass();
        $sql = "SELECT * FROM `users` WHERE `rules` > 0";
        $result = $base->query($sql);
        
        foreach ($result as $key => $value) {
            $to_email = $value['email'];
            $to_name = $value['fio'];
            $this->AddAddress($to_email, $to_name);
        }
        
        $this->Send();
        
    }
    
    
    public function sendMail($type, $to_email, $to_name, $arguments){
        $arguments['fio'] = $to_name;
        $template = $this->configMail($type);
        $this->Body = $this->$template($arguments);
        $this->isHTML(true);
        $this->AddAddress($to_email, $to_name);
        
        if(!$this->Send()) {
            $this->ClearAllRecipients();
            return false;
        }else{
            $this->ClearAllRecipients(); 
            return true;
        }
           
    }
    
    
    public function sendSMS($type, $to_phone, $arguments){

        $template = $this->configMail($type);
        $template = "sms" . $template;
        $sms_text = $this->$template($arguments);
        
        $to_phone = eregi_replace("([^0-9])", "", $to_phone);
        
        $target='+'.$to_phone;
        $sender_name = "9037672140";
        
        $sms = new BEESMS('4117.2','jhg347tsdgsa');
        $errors = $sms->post_message($sms_text, $target, $sender_name);
        
    }
    
    
    
    private function distribution($arguments){
        $body = '';
        $body .= "Здравствуйте {$arguments['fio']}. \n \r";
        $body .= 'Ваш код доступа на сайт: ' . $arguments['key']; 
        return $body;
    }
    
    private function smsDistribution($arguments){
        $body = '';
        $body .= 'Ваш код доступа на сайте "Homedom.ru": ' . $arguments['key']; 
        return $body;
    }
    
    
    private function smsSchedule($arguments){
        $body = '';
        $body .= 'Homedom.ru - ' . $arguments['data']['user']['fio'] . ' ' . $arguments['data']['user']['phone'] . ' записался на просмотр ' . $arguments['data']['type'] . ' ' . $arguments['data']['street'] . ' ' . $arguments['data']['home'] . ' ' . heretic::dateDotted($arguments['data']['time']); 
        return $body;
    }
    
    
    private function object($arguments){
        $body = '';
        $body .= "Здравствуйте {$arguments['fio']}. \n \r";
        $body .= "Вашe объявление успешно размещено на сайте. Ссылка на объявление <a href='http://homedom.ru/objects/object/{$arguments['last_id']}'> homedom.ru/objects/object/{$arguments['last_id']} </a>"; 
        return $body;
    }
    
    private function news($arguments){
        $body = '';
        $body .= "<a href='http://homedom.ru/news/news/{$arguments['last_id']}'>{$arguments['post']['title']}.</a>";
         
        return $body;
    }
    
    private function notice($arguments){
        $body = '';
        $body .= "На сайт добавлено новое объявление. Ссылка для модерирования <a href='http://homedom.ru/moderation/object/{$arguments['last_id']}'> homedom.ru/moderation/object/{$arguments['last_id']} </a>"; 
        return $body;
    }
    
    private function bloking($arguments){
        $body = '';
        $body .= "Ваше объявление <a href='http://homedom.ru/objects/object/{$arguments['last_id']}'> homedom.ru/objects/object/{$arguments['last_id']} </a> было заблокированно по истечению 30 дней. Если вам необходимо продлить его размещение, перейдите к редактированию объявления в <a href='http://homedom.ru/users'>личном кабинете</a>"; 
        return $body;
    }
    
    private function adminBloking($arguments){
        $body = '';
        $body .= 'Сегодня были заблокированы следующие объявления:<br />';
        foreach ($arguments['data'] as $key => $value) {
            $body .= "<a href='http://homedom.ru/objects/object/{$value['id']}'>homedom.ru/objects/object/{$value['id']}</a><br />";
        }
        return $body;
    }
    
}
