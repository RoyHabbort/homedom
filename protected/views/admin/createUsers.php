<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/admin"><?=heretic::$_config['titlePage']?></a>
                &rarr;
                <a href="/admin/rulesUsers">Права доступа</a>
                &rarr;
                <span>Создать пользователя</span>
            </div>
        </div>    
        <?php heretic::Widget('usersMenu', 'admin');?>
        <div class="white-block">
            <div class="btn-back" onclick="history.back()">
                Назад
            </div>
            <div class="padding-title title-big">Создать пользователя</div>
            <div class="block-padding create-users">
                <form name="create-users" class="class-form podat-form" method="post" action="/admin/createUsers">

                    <div class="errors-text">
                        <?= (!empty($arguments['errors']['sql_error'])) ? $arguments['errors']['sql_error'] : '';?>
                    </div>

                    <div class="row-form">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['fio'])) ? $arguments['errors']['fio'] : '';?>
                        </div>
                        <label>Контактное лицо</label>
                        <input type="text" name="fio" class="form-input" value="<?= (!empty($arguments['post']['fio'])) ? $arguments['post']['fio'] : '';?>">
                        <div class="clearfix"></div>
                    </div>
                    <div class="row-form">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['login'])) ? $arguments['errors']['login'] : '';?>
                        </div>
                        <label>Логин</label>
                        <input type="text" name="login" class="form-input" value="<?= (!empty($arguments['post']['login'])) ? $arguments['post']['login'] : '';?>">
                        <div class="clearfix"></div>
                    </div>

                    <div class="row-form">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['email'])) ? $arguments['errors']['email'] : '';?>
                        </div>
                        <label>Email</label>
                        <input type="text" name="email" class="form-input" value="<?= (!empty($arguments['post']['email'])) ? $arguments['post']['email'] : '';?>">
                        <div class="clearfix"></div>
                    </div>

                    <div class="row-form">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['password'])) ? $arguments['errors']['password'] : '';?>
                        </div>
                        <label>Пароль</label>
                        <input type="password" name="password" class="form-input">
                        <div class="clearfix"></div>
                    </div>
                    <div class="row-form">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['password_a'])) ? $arguments['errors']['password_a'] : '';?>
                        </div>
                        <label>Повторите пароль</label>
                        <input type="password" name="password_a" class="form-input">
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="row-form">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['rules'])) ? $arguments['errors']['rules'] : '';?>
                        </div>
                        <label>Права доступа</label>
                        <select class="form-select" name="rules">
                            <option value="">Выберете права</option>
                            <option value="2">Лишённый прав</option>
                            <option value="3">Модератор</option>
                            <option value="4">Администратор</option>
                        </select>
                        <div class="clearfix"></div>
                    </div>    

                    <div class="row-form">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['description'])) ? $arguments['errors']['description'] : '';?>
                        </div>
                        <textarea name="description" class="form-input dop-text"><?= (!empty($arguments['post']['description'])) ? $arguments['post']['description'] : '';?></textarea>
                        <div class="clearfix"></div>
                    </div> 


                    <button type="submit" class="btn btn-green">Создать</button>

                </form>    
            </div>
        </div>    
    </div>    
</div>