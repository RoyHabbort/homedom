<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/users">Личный кабинет</a>
                &rarr;
                <span>Получить код</span>
            </div>
        </div> 
        <?php heretic::Widget('usersMenu', 'users');?>
        <div class="white-block">
            
            <div class="block-padding activate-block bottom-line">
                <div class="title-big">Активация кода</div>
                <form method="post" action="/users/activate" class="activate-form class-form podat-form" name="activate-form">
                    <div class="row-form-code form-activate-row row-code-h">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['otvet'])) ? $arguments['errors']['otvet'] : '';?>
                        </div>
                        <label>Введите код:</label>
                        <input name="code" type="text" class="form-input">
                        <div class="clearfix"></div>
                    </div>
                    <div class="row-form-code form-activate-row row-btn-code">
                        <button type="submit" class="btn btn-blue">Активировать</button>
                        <div class="clearfix"></div>
                    </div>    
                </form>
            </div>  
            
            
            <div class="padding-title title-big code-title">Получить код</div>
            <div class="vopros-code bottom-line">
                
                <div class="block-padding">
                    
                    
                    <form action="/code/getCode" name="get-code" class="class-form podat-form code-form top-vertical" method="post">

                        <div class='block-padding bottom-line not-top-padding vopros-form' >
                            <div class="errors-text">
                                <?= (!empty($arguments['errors']['sql_error'])) ? $arguments['errors']['sql_error'] : '';?>
                            </div>
                            <div class="row-form">
                                <div class="errors-text">
                                    <?= (!empty($arguments['errors']['days'])) ? $arguments['errors']['days'] : '';?>
                                </div>
                                <label>Кол-во дней доступа</label>
                                <select class="form-select" name="days">
                                    <option value="7">7 дней</option>
                                    <option <?php if(!empty($arguments['post']['days'])){ echo ($arguments['post']['days'] == 14) ? 'selected="selected"' : '';}?> value="14">14 дней</option>
                                    <option <?php if(!empty($arguments['post']['days'])){ echo ($arguments['post']['days'] == 21) ? 'selected="selected"' : '';}?> value="21">21 дней</option>
                                    <option <?php if(!empty($arguments['post']['days'])){ echo ($arguments['post']['days'] == 28) ? 'selected="selected"' : '';}?> value="28">28 дней</option>
                                </select>
                                <div class="clearfix"></div>
                            </div>
                            <div class="row-form">
                                <div class="errors-text">
                                    <?= (!empty($arguments['errors']['category'])) ? $arguments['errors']['category'] : '';?>
                                </div>
                                <label>Доступ к категории</label>
                                <select class="form-select" name="category">
                                    <?php foreach (heretic::$_config['extend_config']['category'] as $key => $value) : ?>
                                    <option <?php if(!empty($arguments['post']['category'])){ echo ($arguments['post']['category'] == $key) ? 'selected="selected"' : '';}?> value="<?=$key?>"><?=$value?></option>
                                    <?php endforeach;?>
                                </select>
                                <div class="clearfix"></div>
                            </div>
                            <div class="row-form">
                                <div class="errors-text">
                                    <?= (!empty($arguments['errors']['type_receive'])) ? $arguments['errors']['type_receive'] : '';?>
                                </div>
                                <label>Выбор способа получения ключа</label>
                                <select class="form-select" name="type_receive">
                                    <option <?php if(!empty($arguments['post']['type_receive'])){ echo ($arguments['post']['type_receive'] == 'Email') ? 'selected="selected"' : '';}?> value="Email">Электронная почта</option>
                                    <?php /*<option <?php if(!empty($arguments['post']['type_receive'])){ echo ($arguments['post']['type_receive'] == 'Phone') ? 'selected="selected"' : '';}?> value="Phone">СМС на телефон</option>*/?>
                                </select>
                                <div class="clearfix"></div>
                            </div>    

                            <input type="text" class="hidden" name="name" val="">

                        </div>
                        <?php if (empty($_SESSION['phone'])) : ?>
                            <div class="table-block">
                                <div class="left-form">
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
                            <div class="table-block bottom-line">
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
                                            <?= (!empty($arguments['errors']['description'])) ? $arguments['errors']['description'] : '';?>
                                        </div>
                                        <label class="description-label">О себе</label>
                                        <textarea name="description" class="form-input dop-text"><?= (!empty($arguments['post']['description'])) ? $arguments['post']['description'] : '';?></textarea>
                                        <div class="clearfix"></div>
                                    </div> 
                                </div>
                                <div class="right-block block-only-sub">

                                </div>    
                            </div>

                        <?php endif;?>

                        <div class='block-padding'>

                            <div class="row-form">
                                <div class="vopros-text">
                                    Как вы узнали о нашем сайте ?
                                </div>  

                                <div class="otvet-block">
                                    <label for="rbt-1" class="label-otvet">
                                        <div class="krug active"></div>
                                        <input id="rbt-1" type="radio" name="otvet" value="Поиск в Яндекс/Google" checked="checked">
                                        <span class="otvet-text">Поиск в яндекс/Google</span>
                                    </label>
                                    <label for="rbt-2" class="label-otvet">
                                        <div class="krug"></div>
                                        <input id="rbt-2" type="radio" name="otvet" value="Реклама на улице">
                                        <span class="otvet-text">Реклама на улице</span>
                                    </label>

                                    <label for="rbt-3" class="label-otvet">
                                        <div class="krug"></div>
                                        <input id="rbt-3" type="radio" name="otvet" value="Социальные сети">
                                        <span class="otvet-text">Социальные сети</span>
                                    </label>

                                    <label for="rbt-4" class="label-otvet">
                                        <div class="krug"></div>
                                        <input id="rbt-4" type="radio" name="otvet" value="Посоветовал друг">
                                        <span class="otvet-text">Посоветовал друг</span>
                                    </label>
                                </div>
                                <div class="clearfix"></div>
                            </div>  



                            <div class="right-block ">
                                <div class="btn btn-green btn-code margin-right-20">
                                    Перейти к оплате 
                                </div>    
                                <button type="submit" class="btn btn-green">Получить код доступа бесплатно</button>
                                <div class="clearfix"></div>
                            </div> 
                        </div>

                    </form>
                <div class="clearfix"></div> 
                    
                </div>
                
                <div class="clearfix"></div>
            </div> 
              
        </div>
    </div>    
</div>

