<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/users">Личный кабинет</a>
                &rarr;
                <span>Расписания просмотров</span>
            </div>
        </div> 
        <?php heretic::Widget('usersMenu', 'users');?>
        <div class="white-block">
            
            <div class="title-big padding-title">Расписание просмотров</div>
            
            <div class="tougle-btn">
                <div class="btn btn-tougle act-one active">
                    На ваши объявления откликнулись
                </div>
                <div class="btn btn-tougle act-two">
                    Вы откликнулись на объявления
                </div>    
            </div>    
            
            <div class="section section-one active-schedule">
                <?php  if(!empty($arguments['result'])) : ?>
                    <?php if(!empty($arguments['schedule'])) :?>
                    <div class="padding-title title-big padding-bottom-20">На ваши объявления откликнулись</div>
                    <?php foreach ($arguments['schedule'] as $key => $value) : ?>
                        <div class="padding-bottom-20 bottom-line padding-top-20">
                            <div class="user-object-half">
                                   
                                <div class="result-text">
                                    <div class="object-name"><a href="/objects/object/<?=$value['id']?>">Квартира <?=$value['public_square']?> м&#178;</a></div>
                                    <div class="object-price"><?=$this->smarty_modifier_sum_convert($value['price'], 'summa')?></div>
                                    <div class="object-schedule-pole object-place"><?=$value['street']?> <?=$value['home']?></div>
                                    <div class="object-schedule-pole object-count">Контактные данные : <span class="success-text"><?= ($value['fio']) ? $value['fio'] : '';?></span></div>
                                    <div class="object-schedule-pole object-phone">Телефон : <?= ($value['phone']) ? $value['phone'] : '';?></div>
                                    <div class="object-schedule-pole object-email">Почта : <?= ($value['email']) ? $value['email'] : '';?></div>
                                    <div class="object-schedule-pole object-time">Время просмотра : <?= ($value['time']) ? $this->converteDate($value['time'], 'dateTime') : '';?></div>
                                </div>
                            </div>
                              
                            <div class="clearfix"></div>
                        </div>    
                    <?php endforeach;?>
                    <?php else :?>
                        <div class="block-padding">
                            <p>Никто не записался на просмотр.</p>
                        </div>    
                    <?php endif;?>
                <?php else : ?>
                    <div class="block-padding">
                        <p>У вас пока нет объявлений</p>
                    </div>    
                <?php endif;?>
            </div>
            
            <div class="section">
                <?php if(!empty($arguments['mySchedule'])) : ?>
                <div class="padding-title title-big">Вы откликнулись на объявления</div>
                <?php foreach ($arguments['mySchedule'] as $key => $value) :?>
                <div class="block-padding bottom-line">
                    <div class="result-img-wrap">
                        <div class="result-img">
                            <?php if((!empty($value['main_image']))&&(file_exists(heretic::$_path['images_thumb'].$value['main_image']))) :?>
                                <img src="/<?= heretic::$_path['images_thumb'].$value['main_image'];?>">
                            <?php else :?>
                                <img src="/<?= heretic::$_path['template'];?>img/no_images.jpg">
                            <?php endif;?>
                        </div>    
                    </div>    
                    <div class="result-text">
                        <div class="object-name"><a href="/objects/object/<?=$value['id']?>"><?=$value['type']?> <?= (!empty($value['public_square'])) ? $value['public_square'] . 'м&#178;' : '';?></a></div>
                        <div class="object-price"><?=$this->smarty_modifier_sum_convert($value['price'],'summa')?></div>
                        <div class="object-place"><?=$value['street']?></div>
                        <div> Вы записаны на <?=$this->converteDate($value['time'], 'dateTime')?> </div>
                    </div>
                </div>    
                <?php endforeach;?>
                                                        
                
                <?php else :?>
                    <div class="block-padding">
                        Нет предстоящих просмотров.
                    </div>    
                <?php endif;?>
            </div>
            
        </div>    
    </div>    
</div>

