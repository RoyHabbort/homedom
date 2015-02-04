<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/admin"><?=heretic::$_config['titlePage']?></a>
                &rarr;
                <span>Генерация ключей</span>
            </div>
        </div>    
        <?php heretic::Widget('usersMenu', 'admin');?>
        <div class="white-block">
            <div class="padding-title title-big">Генерация ключей</div>
            
            <div class="success-flash block-padding">
                <?= heretic::getFlash('success');?>
            </div>    
            
            <div class="bottom-line">
                <div class="form-key-div">
                    <form action="/admin/key" name="get-code" class="class-form podat-form" method="post">

                        <div class='block-padding'>
                            <div class="errors-text">
                                <?= (!empty($arguments['errors']['sql_error'])) ? $arguments['errors']['sql_error'] : '';?>
                            </div>
                            <div class="row-form">
                                <div class="errors-text">
                                    <?= (!empty($arguments['errors']['category'])) ? $arguments['errors']['category'] : '';?>
                                </div>
                                <label>Кол-во дней</label>
                                <select class="form-select" name="days">
                                    <option value="7">7 дней</option>
                                    <option value="14">14 дней</option>
                                    <option value="21">21 дней</option>
                                    <option value="28">28 дней</option>
                                </select>
                                <div class="clearfix"></div>
                            </div>
                            <div class="row-form">
                                <div class="errors-text">
                                    <?= (!empty($arguments['errors']['category'])) ? $arguments['errors']['category'] : '';?>
                                </div>
                                <label>Категория</label>
                                <select class="form-select" name="category">
                                    <?php foreach (heretic::$_config['extend_config']['category'] as $key => $value) : ?>
                                        <option value="<?=$key?>"><?=$value?></option>
                                    <?php endforeach;?>
                                </select>
                                <div class="clearfix"></div>
                            </div>

                            <button type="submit" class="btn btn-green">Сгенерировать</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="razdacha block-padding">
                <div class="block-padding">
                    <div class="error-text"><?=  heretic::getFlash('error')?></div>
                </div>
                <form action="/admin/keyGive" name="get-code" class="class-form podat-form" method="post">
                    <div class="title-big padding-bottom-20">Бесплатная раздача ключей по категориям</div>
                    <div class='row-news row-key'>
                        <input id='rent' name='rent' <?= ($arguments['distr_key'][0]["stat"]) ? 'checked="checked"' : '';?> type='checkbox'><label for='rent'>Аренда</label>
                    </div>    
                    <div class='row-news row-key'>
                        <input id='sell' name='sell' <?= ($arguments['distr_key'][1]["stat"]) ? 'checked="checked"' : '';?> type='checkbox'><label for='sell'>Продажа</label>
                    </div>    
                    
                    <button name="raz-btn" type="subbmit" class="btn btn-green">Сохранить</button>
                </form>
            </div>    
            
        </div>    
    </div>    
</div>