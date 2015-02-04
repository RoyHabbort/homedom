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
                <form action="/code/getCode" name="get-code" class="class-form podat-form" method="post">
                    
                    <div class='block-padding bottom-line vopros-form' >
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
                            <button type="submit" class="btn btn-green">Получить код доступа</button>
                            <div class="clearfix"></div>
                        </div> 
                    </div>
                    
                </form>    
            </div>    
        </div>    
        <div class="clearfix"></div>    
    </div>    
</div>

