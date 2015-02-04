<?php

heretic::$_config = array(
    'db' => array(
        'db_host' => "localhost",
        'db_login' => "homedom",
        'db_password' => "dj38fhgdhksjd",
        'db_name' => "homedom"
    ),
    'host_name' => (!empty($_SERVER["HTTP_HOST"])) ? $_SERVER["HTTP_HOST"] : '',
    'debug' => TRUE,
    'main_page' => '/page',
    'template_config' => 'default',
    'default_controller' => 'page',
    'extension' => array(
        'phoneMask' => array(
            'name' => 'phoneMask',
            'description' => 'Маска ввода телефона',
            'dir' => 'phoneMask/',
            'js' => array(
                'phoneMask' => 'phoneMask.js'
            ),
            'css' => array(
                
            )
        ),
        'ckeditor' => array(
            'name' => 'ckEditor',
            'description' => 'Редактор текстовой формы',
            'dir' => 'ckeditor/',
            'js' => array(
                'ckeditor' => 'ckeditor.js'
            ),
            'css' => array(
                
            )
        ),
        'bxslider' => array(
            'name' => 'bxslider',
            'description' => 'Фото-слайдер',
            'dir' => 'bxslider/',
            'js' => array(
                'bxslider' => 'jquery.bxslider.min.js',
            ),
            'css' => array(
                'bxslider' => 'jquery.bxslider.css',
            )
        ),
        'jquery_uploadfile' => array(
            'name' => 'jquery_uploadfile',
            'description' => 'загрузчик файлов',
            'dir' => 'jquery_uploadfile/',
            'js' => array(
                'bxslider' => 'js/jquery.uploadfile.js',
            ),
            'css' => array(
                'bxslider' => 'css/uploadfile.css',
            )
        ),
    ),
    'title' => 'Homedom',
    'titlePage' => '',
    'extend_config' => array(
        'category'=> array(
            'renting' => 'Аренда',
            'sell' => 'Продажа'
            ),
        ),
    'mail'=> array(
        'from_email' => 'Homedom@mail.ru',
        'from_name' => 'Homedom',
    ),
    
);