<div class="conteiner text-page">
    <div class="content-width">
        
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/objects/search">Поиск квартир</a>
                &rarr;
                <span><?=$arguments['result']['type']?> <?= (!empty($arguments['result']['public_square'])) ? $arguments['result']['public_square'] . ' м&#178;' : '';?></span>
            </div>
        </div>    
        <div class="float-left">
            <div class="green-cube inner-cube top-block-170">
                <p><?=$arguments['result']['type']?> <?= (!empty($arguments['result']['public_square'])) ? $arguments['result']['public_square'] . ' м&#178;' : '';?></p>
            </div>
            <div class="float-left main-photo-block">
                <div class="main-image-wrap">
                    <?php if((file_exists(heretic::$_path['front_images'] . $arguments['result']['main_image']))&&(!empty($arguments['result']['main_image']))) : ?>
                        <img src="<?= '/' . heretic::$_path['front_images'] . $arguments['result']['main_image']?>"> 
                    <?php endif;?>
                </div>    
            </div> 
            <div class="clearfix"></div>
            <div class="float-left reiting-object">
                <div class="riting-wrap white-block block-padding right-bottom">
                    
                    <div class="object-row">
                        <span class="object-label">Добавлено в избранное</span>
                        <span class="object-value"><?= (!empty($arguments['result']['count'])) ? $arguments['result']['count'] : '0';?></span>
                    </div>

                    <div class="object-row">
                        <span class="object-label">Просмотров всего</span>
                        <span class="object-value"><?= (!empty($arguments['result']['browsing'])) ? $arguments['result']['browsing'] : '0';?></span>
                    </div>

                    <div class="object-row">
                        <span class="object-label">Просмотров за сегодня</span>
                        <span class="object-value"><?= (!empty($arguments['result']['browsing_day'])) ? $arguments['result']['browsing_day'] : '0';?></span>
                    </div>
                    
                </div>    
            </div>    
        </div>
        
        <div class="right-place">
            <div class="white-block block-relative">
                
                <div class="btn-back" onclick="history.back()">
                    Назад
                </div>    
                
                <?php /* if(empty($_SESSION['phone'])) : ?>
                    <div class="uncode">
                        <div class="red-text">Внимание!</div>
                        Вы зашли в данное объявление как незарегестрированный пользователь. Часть информации скрыта. 
                        Чтобы просмотреть всю информацию <a href="/users/registration/">зарегистрируйтесь на сайте</a> и получите код доступа.
                    </div> 
                <?php else :?>
                    <?php if(empty($arguments['ifCode'])) :?>
                        <div class="uncode">
                            Вы зашли в данное объявление без кода доступа. Часть информации скрыта. 
                            Чтобы просмотреть всю информацию получите 
                            <a href="/users/code/">код доступа</a> к данной категории
                        </div> 
                    <?php endif ;?>
                <?php  endif; */?>
                
                <?php if(!empty($arguments['result'])) : ?>
                    <?php if((!empty($_SESSION['phone']))) : ?>
                        <?php if(!($_SESSION['phone'] === $arguments['result']['phone'])) : ?>
                            <?php if(!$arguments['result']['favorites']) :?>
                                <form action="/objects/object/<?=$arguments['result']['id']?>" method="post" name="favorites-form" class="class-form podat-form absolute-btn">
                                    <input type="hidden" name="action" value="add">
                                    <button type="submit" class="btn btn-green">
                                        Добавить в избранное
                                    </button>    
                                </form>
                                
                            <?php else :?>
                                <form action="/objects/object/<?=$arguments['result']['id']?>" method="post" name="favorites-form" class="class-form podat-form absolute-btn">
                                    <input type="hidden" name="action" value="remove">
                                    <button type="submit" class="btn btn-red">
                                        Удалить из избранного
                                    </button>    
                                </form>
                            <?php endif;?>
                        <?php else :?>
                        <a class="absolute-btn btn btn-blue" href="/users/object/<?=$arguments['result']['id']?>">Редактировать</a>
                        <?php endif;?>
                        <?php if(!empty($_SESSION['rules'])) : ?>
                            <?php if($_SESSION['rules']>=3) : ?>
                                <a class="moder-btn btn btn-blue" href="/moderation/object/<?=$arguments['result']['id']?>">Модерировать</a>
                            <?php endif;?>
                        <?php endif;?>    
                    <?php endif;?>

                    <div class="block-padding bottom-line top-block-170">
                        <div class="object-row">
                            <span class="object-label">Категория</span>
                            <span class="object-value"><?=heretic::$_config['extend_config']['category'][$arguments['result']['category']]?></span>
                        </div>
                        <div class="object-row">
                            <span class="object-label">Объект</span>
                            <span class="object-value"><?=$arguments['result']['type']?> <?= (!empty($arguments['result']['public_square'])) ? $arguments['result']['public_square'] . ' м&#178;' : '';?></span>
                        </div>
                        <div class="object-row">
                            <span class="object-label">Дата размещения</span>
                            <span class="object-value"><?=$this->converteDate($arguments['result']['date_create'], 'dateTime');?></span>
                        </div>
                    </div>
                    
                    <div class="block-padding bottom-line">
                        
                        <div class="object-row">
                            <span class="object-label">Город</span>
                            <span class="object-value"><?= (!empty($arguments['result']['city'])) ? $arguments['result']['city'] : '';?></span>
                        </div>
                        
                        <div class="object-row">
                            <span class="object-label">Адрес</span>
                            <span class='hidden adress-for-map'><?= (!empty($arguments['result']['city'])) ? $arguments['result']['city'] : '';?> <?= (!empty($arguments['result']['street'])) ? $arguments['result']['street'] : '';?> <?= (!empty($arguments['result']['home'])) ?  $arguments['result']['home'] : '';?></span>
                            <span class="object-value">
                                <?= (!empty($arguments['result']['district'])) ? 'р-н ' . $arguments['result']['district'] . ',' : '';?>
                                <?= (!empty($arguments['result']['street'])) ? $arguments['result']['street'] . ',' : '';?>
                                <?= (!empty($arguments['result']['home'])) ? 'д. ' . $arguments['result']['home'] . ',' : '';?>
                                <?php if((!empty($_SESSION['phone']))&&(!empty($arguments['ifCode']))) :?>
                                    <?php if($arguments['ifCode']) :?>
                                    <?= (!empty($arguments['result']['apartament'])) ? 'кв. ' . $arguments['result']['apartament'] : '';?>
                                    <?php else : ?>
                                    кв. <a href="/users/code/" class="type-lnk not-underline">???</a>
                                    <?php endif;?>
                                <?php else :?>
                                    кв. <a href="/users/code/" class="type-lnk not-underline">???</a>
                                <?php endif;?>
                                <div class="show-map">Показать на карте</div>    
                            </span>
                            &nbsp;
                            
                            
                        </div>
                
                        <div class='map-row search-map-block block-padding bottom-line white-block search-hidden'>
                            <div id="map-search-2" class="map-search" style="widht:600px;height:360px">

                            </div> 
                        </div>    
                      
                        
                        <div class="object-row">
                            <span class="object-label">Этаж</span>
                            <span class="object-value"><?= (!empty($arguments['result']['floor'])) ? $arguments['result']['floor'] : '';?><?= (!empty($arguments['result']['floor_all'])) ? '/' . $arguments['result']['floor_all'] : '';?></span>
                        </div>
                        
                        
                        
                        <div class="object-row">
                            <span class="object-label">Общая площадь</span>
                            <span class="object-value"><?= (!empty($arguments['result']['public_square'])) ? $arguments['result']['public_square'] . ' м&#178;' : '';?></span>
                        </div>
                        <div class="object-row">
                            <span class="object-label">Жилая площадь</span>
                            <span class="object-value"><?= (!empty($arguments['result']['life_square'])) ? $arguments['result']['life_square'] . ' м&#178;' : '';?></span>
                        </div>
                        <div class="object-row">
                            <span class="object-label">Кухня</span>
                            <span class="object-value"><?= (!empty($arguments['result']['kitchen'])) ? $arguments['result']['kitchen'] . ' м&#178;' : '';?></span>
                        </div>
                        
                        
                        
                        
                        <div class="object-row">
                            <span class="object-label">Контактное лицо</span>
                            <span class="object-value"><?= (!empty($arguments['result']['fio'])) ? $arguments['result']['fio'] : '';?></span>
                        </div>
                        <div class="object-row">
                            <span class="object-label">Телефон</span>
                            <span class="object-value">
                                <?php if((!empty($_SESSION['phone'])&&(!empty($arguments['ifCode'])))||(!empty($_SESSION['phone'])&&(!empty($_SESSION['rules'])))) :?>
                                    <?php if($arguments['ifCode']||($_SESSION['rules']>=3)) :?>
                                        <?= (!empty($arguments['result']['phone'])) ? $arguments['result']['phone'] : '';?>
                                    <?php else :?>
                                        <a href="/users/code/" class="type-lnk">получить код доступа к личным данным</a>
                                    <?php endif;?>
                                <?php else :?>
                                    <a href="/users/code/" class="type-lnk">получить код доступа к личным данным</a>        
                                <?php endif;?>
                            </span>
                        </div>
                            
                        
                        <div class="object-row">
                            <span class="object-label">Стоимость</span>
                            <span class="object-value"><?= (!empty($arguments['result']['price'])) ? $this->smarty_modifier_sum_convert($arguments['result']['price'], 'summa') : '';?></span>
                        </div>
                        
                        
                        <div class="schedule-wrap-object green-place">
                            <form class="class-form podat-form">
                                <?php if((!empty($_SESSION['phone']))) : ?>
                                    <?php if(!($_SESSION['phone'] === $arguments['result']['phone'])) : ?>
                                        <?php if(empty($arguments['result']['schedule'])) : ?>
                                
                                        <div class="object-schedule obj-schedule green-fon-place">
                                            <div class="green-title">Запись на просмотр</div>
                                            <div class="errors-text">

                                            </div>
                                            <div class="table-row">
                                                <div class="title-table width-50">
                                                    Дата
                                                </div>
                                                <div class="select-table padding-right-40">
                                                    <input class="form-input schedule-date " name="date"></input>
                                                </div>
                                                <div class="title-table">
                                                    Время
                                                </div>
                                                <div class="select-table">
                                                    <?php
                                                        $start_time = date('H:i', strtotime($arguments['result']['time_start'])); 
                                                        $end_time = date('H:i', strtotime($arguments['result']['time_end'])); 
                                                        $time = $start_time;
                                                    ?>
                                                    <select data-id="<?=$arguments['result']['id']?>" date-start="<?=$arguments['result']['time_start']?>" date-end="<?=$arguments['result']['time_end']?>" class="form-select time_schedule" name="time_schedule" dataid="<?=$arguments['result']['id']?>">
                                                        <option value="">Выберете сначала дату</option>
                                                        <?php /*
                                                        <?php while(strtotime($time)<strtotime($end_time)) : ?>
                                                        <option value="<?=$time?>"><?=$time?></option>>
                                                        <?php $time = date('H:i', strtotime($time) + 15*60)?>
                                                        <?php endwhile;?>  */?>
                                                    </select>  
                                                </div>
                                            </div>
                                            <div class="btn btn-white float-right btn-add-schedule">
                                                Записаться
                                            </div>    
                                            <div class="clearfix"></div>
                                        </div>    
                                
                                        
                                        <?php else:?>
                                        <div class="object-schedule obj-schedule green-fon-place">
                                            <div class="object-schedule success-text not-margin-bottom">
                                               Вы уже откликнулись на это объявление
                                               Вы записаны на <?=$this->converteDate($arguments['result']['schedule']['time'], 'dateTime')?>                                   
                                            </div>    
                                        </div>
                                        <?php endif;?>
                                    <?php endif;?>
                                <?php endif;?>
                            </form>
                        </div>    
                        
                        
                        <?php if(!empty($arguments['result']['photo'])) : ?>
                        <div class="object-photogallery">
                            <ul class="bxslider">
                                
                            <?php foreach ($arguments['result']['photo'] as $key => $value) : ?>
                                    <?php if((!empty($value['photo']))&&(file_exists(heretic::$_path['front_images'].$value['photo']))) :?>
                                        <li><img src="/<?= heretic::$_path['front_images'].$value['photo'];?>"></li>
                                    <?php else :?>
                                        <li><img src="/<?= heretic::$_path['template'];?>img/no_images.jpg"></li>
                                    <?php endif;?>
                            <?php endforeach;?>
                            </ul> 
                            <div id="bx-pager" class="bxslider-pagination">
                                
                                <?php $i = 0;?>
                                <?php foreach ($arguments['result']['photo'] as $key => $value) : ?>
                                    <?php if((!empty($value['photo']))&&(file_exists(heretic::$_path['images_thumb'].$value['photo']))) :?>
                                        <div class="slide"><a data-slide-index="<?=$i?>" href=""><img src="/<?= heretic::$_path['images_thumb'].$value['photo'];?>"></a></div>
                                    <?php else :?>
                                        <div class="slide"><a data-slide-index="<?=$i?>" href=""><img src="/<?= heretic::$_path['template'];?>img/no_images.jpg"></a></div>
                                    <?php endif;?>
                                    <?php $i++;?>
                                <?php endforeach;?>
                            </div>
                        </div>   
                        <?php endif;?>
                        
                        <div class="object-comment">
                             <?= (!empty($arguments['result']['comment'])) ? $arguments['result']['comment'] : '';?>
                        </div>
                            
                    </div>
                    <!--div class="object-menu">
                        <a class="object-menu-a white-cube block-padding" href="#"><p>Получить код доступа</p></a>
                        <a class="object-menu-a blue-cube block-padding" href="#"><p>Получить код доступа</p></a>
                        <a class="object-menu-a yellow-cube block-padding" href="#"><p>Получить код доступа</p></a>
                        <a class="object-menu-a green-cube block-padding" href="#"><p>Получить код доступа</p></a>
                        <div class="clearfix"></div>
                    </div-->
                <?php else :?>
                    <div class="block-padding">
                        Запрашиваемое объявление не найдено
                    </div>    
                <?php endif;?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>    
</div>


<?php heretic::Widget('upWindow');?>


<!--div class="absolut-block hidden">
    
    <div class="block-padding">
        <p>
            Для активации функции "Поиск по карте" и "Запись на просмотр" Вам необходимо 
            <a href="/users/registration/" class="type-lnk">зарегистрироваться</a> и получить <a href="/users/code/" class="type-lnk">код доступа</a>
            в личном кабинете
        </p>
    </div>
    
    
    <div class=" block-padding">
        <div class="btn float-right btn-close-absolute">
            Закрыть
        </div>    
        <div class="clearfix"></div>
    </div>    
    
</div-->    