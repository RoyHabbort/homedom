<body class="<?= ($_SESSION['rules'] >= 3)? 'moder-body' : '';?>">
    <header>
        <div class="head-line content-width">
            <div class="logo">
                <a href="<?= heretic::$_config['main_page'] ?>">
                    <div class="logo-img-wrap">
                        <img src="/<?=  heretic::$_path['template']?>img/logo_home.png">
                    </div>
                </a>
            </div>
            <div class="soc-seti">
                
                <div class='soc-list'>
                    <a target='_blank' class='ok' href='http://ok.ru/group/51860289749144'></a>
                    <a target='_blank' class='vk' href='https://vk.com/homedom61'></a>
                    <a target='_blank' class='fb' href='https://www.facebook.com/homedom.ru'></a>
                    <a target='_blank' class='ig' href='http://instagram.com/homedom.ru'></a>
                </div>    
                
                <!--
                <script type="text/javascript">(function() {
                    if (window.pluso)if (typeof window.pluso.start == "function") return;
                    if (window.ifpluso==undefined) { window.ifpluso = 1;
                      var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                      s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                      s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
                      var h=d[g]('body')[0];
                      h.appendChild(s);
                    }})();
                </script> 
                <div class="pluso" data-background="transparent" data-options="medium,square,line,horizontal,nocounter,theme=04" data-services="vkontakte,odnoklassniki,facebook,twitter" data-url="http://homedom.ru/page" data-title="Homedom.ru" data-description="Сайт homedom.ru. Некоторая инфа по сайту. "></div>
                -->
            </div>
            
            <div class="lk">
                <?php if (!empty($_SESSION['phone'])) : ?>
                <a href="/users" class="btn btn-green lk-btn">Личный кабинет</a>
                <?php endif;?>
            </div>
            <div class="login">
                <?php if (!empty($_SESSION['phone'])) : ?>
                <span class="login-user"><?php heretic::Widget('login')?></span>
                <?php else: ?>
                <a href="/users/registration" class="btn">Зарегистрироваться</a>
                <span>или</span>
                <a href="/users/login" class="btn btn-blue">Войти</a>
                <?php endif;?>
            </div>
        </div>    
    </header>