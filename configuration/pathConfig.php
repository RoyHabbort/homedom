<?php

        if(!empty(heretic::$_config['template_name'])) $template = 'template/' . heretic::$_config['template_name'];
        else $template = 'template/default/';
        
        heretic::$_path = array(
            'class' => 'class/',
            'template' => $template,
            'content' => 'protected/',
            'controllers' => 'protected/controllers/',
            'views' => 'protected/views/',
            'models' => 'protected/models/',
            'widget' => 'protected/widget/',
            'extension' => 'protected/extension/',
            'assets' => 'assets/',
            'images' => 'assets/images/',
            'big_image' => 'assets/images/big_images/',
            'front_images' => 'assets/images/main_images/',
            'images_thumb' => 'assets/images/thumb/',
            'files_dir' => 'assets/files/',
        );