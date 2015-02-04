<?php


$key = @$argv[1];

if($key == 'jp74Tsh5B11'){
    
    $_GET['route'] = 'objects/bloking';
    $server_path = $_SERVER['SCRIPT_FILENAME'];
    
    $server_path = str_replace('bloking.php', '', $server_path);
    
    //инициализация основной настройки
    include_once $server_path . 'kernel/heretic.php';
    include_once $server_path . 'configuration/mainConfig.php';
    include_once $server_path . 'class/databaseClass.php';
    include_once $server_path . 'class/mysqlClass.php';
    
    $database = new databaseClass();
    $database ->selectDatabase(heretic::$_config['db']);
    
    
    include_once $server_path . '/additions/PHPMailer/class.phpmailer.php';
    include_once $server_path . '/protected/models/mail.php';
    bloking();
}


function bloking(){
    $adminArrayBloking = array();
    $base = new mysqlClass();

    $sql = "SELECT * FROM `object` WHERE `moderation` >= 0";
    $list = $base->query($sql);
    $currentDate = date('Y-m-d h:i:s');
    echo "<br />";
    $mail = new mail();

    foreach ($list as $key => $value) {
        $dateLast = (strtotime($value['date_edit']) > 0) ? $value['date_edit'] : $value['date_create'];
        $dateDiff = (strtotime($currentDate) - strtotime($dateLast)) / 86400;
        if ($dateDiff > 30){

            $sql = "UPDATE `object` SET `moderation` = '-1' WHERE `id` = '{$value['id']}'";
            $base->query($sql);

            $sql = "SELECT * FROM `users` WHERE `id_user` = '{$value['user_id']}'";
            $user = $base->query($sql);

            if(!empty($user)){
                $user = $user[0];

                $mail->sendMail('bloking', $user['email'], $user['fio'], array('last_id' => $value['id']));
            }

            $adminArrayBloking[] = $value;

            echo $value['user_id'] . ' ... ';

            echo $currentDate;
            echo " - ";
            echo $dateLast;
            echo " = ";
            echo $dateDiff;
            echo "<br />"; 

        }

    }
    
    if(!empty($adminArrayBloking)){
        $mail->sendMail('adminBloking', 'homedom.ru@mail.ru', 'homedom', array('data' => $adminArrayBloking));
    }
}

?>