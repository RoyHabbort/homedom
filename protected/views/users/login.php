<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <span><?= heretic::$_config['titlePage'];?></span>
            </div>
        </div>    
        <div class="left-place green-cube">
            <p><?= heretic::$_config['titlePage'];?></p>
        </div>
        <div class="right-place">
            <div class="white-block block-padding">
                <div class="admin-loginform">
                    <form class="class-form podat-form" name="login-form" action="/users/login" method="post">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors'])) ? $arguments['errors'] : '';?>
                        </div>
                        <div class="row-form">
                            <label>Телефон</label>
                            <input type="text" name="phone" class="form-input" value="<?= (!empty($arguments['phone']) ? $arguments['phone'] : '')?>">
                            <div class="clearfix"></div>
                        </div>
                        <div class="row-form">
                            <label>Пароль</label>
                            <input type="password" name="password" class="form-input">
                            <div class="clearfix"></div>
                        </div>
                        <div class="row-form search-submit">
                            <button type="submit" class="btn btn-blue">Войти</button>
                            <div class="clearfix"></div>
                        </div> 
                    </form>
                </div>    
            </div>    
        </div>    
        <div class="clearfix"></div>    
    </div>    
</div>