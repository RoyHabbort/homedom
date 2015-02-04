<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/users">Личный кабинет</a>
                &rarr;
                <a href="/users/schedule">Расписания просмотров</a>
                &rarr;
                <span><?=$arguments['result']['type']?> <?= (!empty($arguments['result']['public_square'])) ? $arguments['result']['public_square'] . 'м&#178;' : '';?></span>
            </div>
        </div> 
        <?php heretic::Widget('usersMenu', 'users');?>
            <div class="white-block block-relative">
                <div class="btn-back" onclick="history.back()">
                    Назад
                </div>
                <?php if(!empty($arguments['result'])) : ?>
                
                    <div class="block-padding bottom-line">
                        <div class="object-row">
                            <span class="object-label">Категория</span>
                            <span class="object-value"><?=heretic::$_config['extend_config']['category'][$arguments['result']['category']]?></span>
                        </div>
                        <div class="object-row">
                            <span class="object-label">Объект</span>
                            <span class="object-value"><?=$arguments['result']['type']?> <?= (!empty($arguments['result']['public_square'])) ? $arguments['result']['public_square'] . 'м&#178;' : '';?></span>
                        </div>
                        <div class="object-row">
                            <span class="object-label">Дата размещения</span>
                            <span class="object-value"><?=$arguments['result']['date_create'];?></span>
                        </div>
                    </div>
                    
                    <div class="block-padding bottom-line margin-bottom-20">
                        
                        <div class="object-row">
                            <span class="object-label">Общая площадь</span>
                            <span class="object-value"><?= (!empty($arguments['result']['public_square'])) ? $arguments['result']['public_square'] : '';?></span>
                        </div>
                        <div class="object-row">
                            <span class="object-label">Жилая площадь</span>
                            <span class="object-value"><?= (!empty($arguments['result']['life_square'])) ? $arguments['result']['life_square'] : '';?></span>
                        </div>
                        <div class="object-row">
                            <span class="object-label">Город</span>
                            <span class="object-value"><?= (!empty($arguments['result']['city'])) ? $arguments['result']['city'] : '';?></span>
                        </div>
                       
                        <div class="object-row">
                            <span class="object-label">Адрес</span>
                            <span class="object-value">
                                <?= (!empty($arguments['result']['district'])) ? 'р-н ' . $arguments['result']['district'] : '';?>
                                <?= (!empty($arguments['result']['street'])) ? 'ул. ' . $arguments['result']['street'] : '';?>
                                <?= (!empty($arguments['result']['home'])) ? 'д. ' . $arguments['result']['home'] : '';?>
                                <?= (!empty($arguments['result']['apartament'])) ? 'кв. ' . $arguments['result']['apartament'] : '';?>
                            </span>
                        </div>
                        
                        <div class="object-row">
                            <span class="object-label">Этажность</span>
                            <span class="object-value"><?= (!empty($arguments['result']['floor'])) ? $arguments['result']['floor'] : '';?></span>
                        </div>
                        
                        <div class="object-row">
                            <span class="object-label">Стоимость</span>
                            <span class="object-value"><?= (!empty($arguments['result']['price'])) ? $this->smarty_modifier_sum_convert($arguments['result']['price'], 'summa') : '';?></span>
                        </div>
                        <div class="object-comment">
                             <?= (!empty($arguments['result']['comment'])) ? $arguments['result']['comment'] : '';?>
                        </div>
                        
                    </div>
                    
                    <?php if(!empty($arguments['schedule'])) : ?>
                        <div class="schedule-title">Ваше расписание</div>
                        <div class="schedule-block">
                            <?php foreach($arguments['schedule'] as $key => $value) : ?>
                                <div class="block-padding bottom-line">
                                    <div class="object-row">
                                        <span class="object-label">Время</span>
                                        <span class="object-value"><?= (!empty($value['time'])) ? $this->converteDate($value['time'],'dateTime') : '';?></span>
                                    </div>    
                                    <div class="object-row">
                                        <span class="object-label">Контактное лицо</span>
                                        <span class="object-value"><?= (!empty($value['fio'])) ? $value['fio'] : '';?></span>
                                    </div>   
                                    <div class="object-row">
                                        <span class="object-label">Телефон</span>
                                        <span class="object-value"><?= (!empty($value['phone'])) ? $value['phone'] : '';?></span>
                                    </div>   
                                    <div class="object-row">
                                        <span class="object-label">Почта</span>
                                        <span class="object-value"><?= (!empty($value['email'])) ? $value['email'] : '';?></span>
                                    </div>
                                </div>    
                            <?php endforeach;?>
                        </div>
                    <?php else :?>
                        <div class="null-schedule block-padding">
                            Нет записавшихся на просмотр.
                        </div>    
                    <?php endif;?>
                <?php else :?>
                    <div class="block-padding">
                        Запрашиваемое объявление не найдено
                    </div>    
                <?php endif;?>
            </div>
        <div class="clearfix"></div>
    </div>    
</div>

