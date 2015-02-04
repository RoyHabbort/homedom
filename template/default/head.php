<html lang="ru">
    <head>
        <title><?= (!empty(heretic::$_config['titlePage'])) ?  heretic::$_config['titlePage'] . ' | ' : '' ;?>Homedom</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="icon" type="image/jpg" href="/favicon.jpg" />
        
        <?php
            foreach (heretic::$_script as $key => $value) {
                echo '<script type="text/javascript" src="/'.heretic::$_path['template'].$value.'"></script>';
            }
            
            foreach (heretic::$_link as $key => $value) {
                echo '<link rel="stylesheet" type="text/css" href="/'.heretic::$_path['template'].$value.'">';
            }
            
            
            foreach (heretic::$_config['extension'] as $extension => $option) {
    
                foreach ($option['js'] as $key => $value) {
                    $dir = heretic::$_path['extension'] . $option['dir'] . $value;
                    echo '<script type="text/javascript" src="/'.$dir.'"></script>';
                }

                foreach ($option['css'] as $key => $value) {
                    $dir = heretic::$_path['extension'] . $option['dir'] . $value;
                    echo '<link rel="stylesheet" type="text/css" href="/'.$dir.'">';
                }

            }
            
            
        ?>
        
        <script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
        
       
        
        
    </head>