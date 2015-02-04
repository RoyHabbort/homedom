<div class="conteiner text-page">
    <div class="content-width">
        <div class="white-block block-padding admin-loginpage">
            <div class="admin-loginform">
                <form class="class-form podat-form" name="login-form" action="/moderation" method="post">
                    <div class="errors-text">
                        <?= (!empty($arguments['errors'])) ? $arguments['errors'] : '';?>
                    </div>
                    <div class="row-form">
                        <label>Логин</label>
                        <input type="text" name="login" class="form-input">
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
        <div class="clearfix"></div>    
    </div>    
</div>