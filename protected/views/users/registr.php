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
            <div class="white-block ">
                <form action="/users/registration" name="registration" class="class-form podat-form" method="post">
                    <div class="table-block">
                        <div class="left-form">
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
                                    <?= (!empty($arguments['errors']['phone'])) ? $arguments['errors']['phone'] : '';?>
                                </div>
                                <label>Телефон</label>
                                <input type="text" name="phone" class="form-input" value="<?= (!empty($arguments['post']['phone'])) ? $arguments['post']['phone'] : '';?>">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="right-form">
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
                        </div> 
                    </div>
                    <div class="table-block">
                        <div class="left-block">
                            <div class="row-form">
                                <div class="errors-text">
                                    <?= (!empty($arguments['errors']['email'])) ? $arguments['errors']['email'] : '';?>
                                </div>
                                <label>Введите email</label>
                                <input type="text" name="email" class="form-input" value="<?= (!empty($arguments['post']['email'])) ? $arguments['post']['email'] : '';?>">
                                <div class="clearfix"></div>
                            </div>
                            <div class="row-form">
                                <div class="errors-text">
                                    <?= (!empty($arguments['errors']['user_city'])) ? $arguments['errors']['user_city'] : '';?>
                                </div>
                                <label class="description-label">Город</label>
                                <select class="form-select" name="user_city">
                                    <option value="">Выберете город</option>
                                    <?php foreach ($arguments['all_city'] as $key => $value) :?>
                                    <option <?= ($value['city'] == $arguments['post']['user_city']) ? 'selected="selected"' : '' ; ?> value="<?=$value['city']?>"><?=$value['city']?></option>    
                                    <?php endforeach;?>
                                </select>  
                                <div class="clearfix"></div>
                            </div> 
                        </div>
                        <div class="right-block block-bottom block-only-sub">
                            <button type="submit" class="btn btn-green">Зарегистрироваться</button>
                            <div class="clearfix"></div>
                        </div>    
                    </div>
                </form>    
            </div>    
        </div>    
        <div class="clearfix"></div>    
    </div>    
</div>

