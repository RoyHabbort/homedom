<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/users">Личный кабинет</a>
                &rarr;
                <span>Личные данные</span>
            </div>
        </div> 
        <?php heretic::Widget('usersMenu', 'users');?>
        <div class="white-block ">
            <div class="title-big padding-title">Личные данные</div>
            <?php if(!empty($arguments['success'])) : ?><div class="success-result"><?= $arguments['success']?></div><?php endif;?>
            <div class="personal-form-div">
                <form action="/users/personal" name="personal-edit" class="personal-form class-form podat-form" method="post">
                    <div class="errors-text">
                        <?= (!empty($arguments['errors']['sql_error'])) ? $arguments['errors']['sql_error'] : '';?>
                    </div>
                    <div class="row-form">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['fio'])) ? $arguments['errors']['fio'] : '';?>
                        </div>
                        <label>Контактное лицо</label>
                        <input type="text" name="fio" class="form-input" value="<?= (!empty($arguments['result']['fio'])) ? $arguments['result']['fio'] :'';?>">
                        <div class="clearfix"></div>
                    </div>
                    <div class="row-form">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['old_password'])) ? $arguments['errors']['old_password'] : '';?>
                        </div>
                        <label>Старый пароль</label>
                        <input type="password" name="old_password" class="form-input">
                        <div class="clearfix"></div>
                    </div>
                    <div class="row-form">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['new_password'])) ? $arguments['errors']['password'] : '';?>
                        </div>
                        <label>Новый пароль</label>
                        <input type="password" name="new_password" class="form-input">
                        <div class="clearfix"></div>
                    </div>
                    <div class="row-form">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['password_a'])) ? $arguments['errors']['password_a'] : '';?>
                        </div>
                        <label>Повторите новый пароль</label>
                        <input type="password" name="password_a" class="form-input">
                        <div class="clearfix"></div>
                    </div>
                    <div class="row-form">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['email'])) ? $arguments['errors']['email'] : '';?>
                        </div>
                        <label>Email</label>
                        <input type="text" name="email" class="form-input" value="<?= (!empty($arguments['result']['email'])) ? $arguments['result']['email'] :'';?>">
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
                            <option <?= ($value['city'] == $arguments['result']['city']) ? 'selected="selected"' : '' ; ?> value="<?=$value['city']?>"><?=$value['city']?></option>    
                            <?php endforeach;?>
                        </select>  
                        <div class="clearfix"></div>
                    </div>  
                    
                    <div class="row-form">
                        <button type="submit" class="btn btn-green float-right">Сохранить</button>    
                    </div>    
                </form> 
            </div>
            <div class="personal-information">
                <div class="more-information">
                    <div class="information-row">
                        <span class="information-label">Зарегистрирован</span>
                        <span class="information-value"><?= (!empty($arguments['result']['date_registration'])) ? $this->converteDate($arguments['result']['date_registration']) : '';?></span>
                    </div>
                    <div class="information-row">
                        <span class="information-label">Объявлений</span>
                        <span class="information-value"><?= (!empty($arguments['result']['count(o.id)'])) ? $arguments['result']['count(o.id)'] : '<span class="red-text">нет</span>';?></span>
                    </div>
                </div> 
                <div class="key-information">
                    <div class="key-dostup">Дней доступа к категории</div>
                    <div class="information-row">
                        <span class="information-label">Аренда</span>
                        <span class="information-value"><?= (!empty($arguments['result']['code']['renting'])) ? 'осталось ' . $arguments['result']['code']['renting'] . ' ' . $this->smarty_modifier_string_declination($arguments['result']['code']['renting'], $many="дней", $one="день", $two="дня") : '<a href="/users/code/" class="type-lnk">Получить код доступа</a>';?></span>
                    </div>
                    <div class="information-row">
                        <span class="information-label">Продажа</span>
                        <span class="information-value"><?= (!empty($arguments['result']['code']['sell'])) ? 'осталось ' . $arguments['result']['code']['sell'] . ' ' . $this->smarty_modifier_string_declination($arguments['result']['code']['sell'], $many="дней", $one="день", $two="дня") : '<a href="/users/code/" class="type-lnk">Получить код доступа</a>';?></span>
                    </div>
                    
                </div>    
            </div>  
            <div class="clearfix"></div>
        </div>    
        <div class="clearfix"></div>    
    </div>    
</div>

