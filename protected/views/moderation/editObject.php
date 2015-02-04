<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/moderation"><?=heretic::$_config['titlePage']?></a>
                &rarr;
                <span>Редактирование объявления</span>
            </div>
        </div>  
        <?php heretic::Widget('usersMenu', 'moder');?>
        <div class="white-block">
            <div class="btn-back" onclick="history.back()">
                Назад
            </div> 
            <div class="padding-title title-big">Редактирование объявления</div> 
            
            <div class="block-edit-object">
                
                
                <div class="errors-text">
                    
                    <?=  heretic::getFlash('error')?>
                    <?= (!empty($arguments['errors']['sql_error'])) ? $arguments['errors']['sql_error'] : '';?>
                </div>    
                
                <div class="block-padding bottom-line">
                    <div class="object-row">
                        <span class="object-label">Контактное лицо</span> 
                        <span class="object-value"><?= (!empty($arguments['result']['fio'])) ? $arguments['result']['fio'] : '';?></span>
                    </div>
                    <div class="object-row">
                        <span class="object-label">Телефон</span>
                        <span class="object-value"><?= (!empty($arguments['result']['phone'])) ? $arguments['result']['phone'] : '';?></span>
                    </div>
                    <div class="object-row">
                        <span class="object-label">Почта</span>
                        <span class="object-value"><?= (!empty($arguments['result']['email'])) ? $arguments['result']['email'] : '';?></span>
                    </div>
                    <div class="ban-row edit-row">
                        <div class="hidden"><span class="id-user"><?=$arguments['result']['id_user']?></span></div>
                        <div class="hidden"><span class="ban-result" data-ban="<?=$arguments['result']['rules']?>"><?=$arguments['result']['id_user']?></span></div>
                        <div class="ban-error errors-text">
                        </div>
                        <div class="ban-button">
                            <div class="btn btn-red ban-click">
                                Забанить
                            </div>
                        </div>    
                    </div>    
                </div>
                
                
                <div class="table-block bottom-line">
                    <div>
                        <div id="upload-photo-block" class="upload-photo-block padding-left-10">
                            <div>Фотографии</div>
                            <?php foreach ($arguments['result']['photo'] as $key => $value) :?>
                                <div class="ajax-file-upload-statusbar">
                                    <div class="edit-img">
                                        <?php if((!empty($value['photo']))&&(file_exists(heretic::$_path['images_thumb'].$value['photo']))) :?>
                                            <img src="/<?= heretic::$_path['images_thumb'].$value['photo'];?>">
                                        <?php else :?>
                                            <img src="/<?= heretic::$_path['template'];?>img/no_images.jpg">
                                        <?php endif;?>
                                    </div>
                                    <div class="form-delete">
                                        <form class="form-for-delete" action="/moderation/deletePhoto/<?=$arguments['result']['id']?>" method="post" name="photogallery-form" class="moder-form class-form podat-form">
                                            <input type="hidden" name="photo_id" value="<?=$value['id_photo']?>">
                                            <button type="submit" name="for-felete" class="btn btn-close upload-delete"><img class="img-close" src="/<?= heretic::$_path['template']?>img/icons/icon-close.png"></button>
                                        </form>
                                    </div>    
                                </div>  
                            <?php endforeach;?>
                        </div>  
                        <div class="clearfix"></div>
                    </div>    
                    <div class=" block-bottom">
                        <div class="errors-text">
                                <?= (!empty($arguments['errors']['load-photo'])) ? $arguments['errors']['load-photo'] : '';?>
                        </div>
    
                        <label id="load-photo" class="load-photo">
                            <span class="inner-label-load">
                                <span class="dashed-cube">
                                    <span>Загрузить фото</span>
                                </span>
                                <!--input id="load-photo" name="load-photo" type="file" class="hidden" accept="image/*"-->
                            </span>
                        </label>
                            
                        <div class="clearfix"></div>
                    </div>  
                </div>
                
                <form  action="/moderation/object/<?=$arguments['result']['id']?>" method="post" name="moder-form" class="moder-form class-form podat-form" enctype="multipart/form-data">
                
                <div class="bottom-line block-relative">
                    
                    <div class="edit-div-form">
                        <div class="white-block">
                            <div class="table-block">
                                <div class="left-form upload-hide">
                                    <div class="errors-text">
                                        <?= (!empty($arguments['errors']['sql_error'])) ? $arguments['errors']['sql_error'] : '';?>
                                    </div>
                                    <div class="row-form">
                                        <div class="errors-text">
                                            <?= (!empty($arguments['errors']['category'])) ? $arguments['errors']['category'] : '';?>
                                        </div>
                                        <label>Категория</label>
                                        <select class="form-select" name="category">
                                            <option value="">Выберите категорию</option>
                                            <?php foreach (heretic::$_config['extend_config']['category'] as $key => $value) : ?>
                                            <option <?= ($key==$arguments['result']['category']) ? 'selected="selected"':'';?> value="<?=$key?>"><?=$value?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="row-form">
                                        <div class="errors-text">
                                            <?= (!empty($arguments['errors']['city'])) ? $arguments['errors']['city'] : '';?>
                                        </div>
                                        <label>Город</label>
                                        <select class="form-select" name="city">
                                            <option value="">Выберите город</option>
                                            <?php foreach ($arguments['params_add']['city'] as $key => $value) :?>
                                            <option <?= ($value['id_city'] == $arguments['result']['city']) ? 'selected="selected"' : '' ; ?> value="<?=$value['id_city']?>"><?=$value['city']?></option>    
                                            <?php endforeach;?>
                                        </select>    
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="row-form">
                                        <div class="errors-text">
                                            <?= (!empty($arguments['errors']['district'])) ? $arguments['errors']['district'] : '';?>
                                        </div>
                                        <label>Район</label>
                                        <select class="form-select" name="district">
                                            <?php if(!empty($arguments['params_add']['district'])) : ?>
                                                <?php foreach ($arguments['params_add']['district']as $key => $value) : ?>
                                                <option <?= ($value['id_district'] == $arguments['result']['district']) ? 'selected="selected"' : '' ; ?> value="<?=$value['id_district']?>"><?=$value['district']?></option>    
                                                <?php endforeach;?>
                                            <?php else : ?>
                                                <option value="">Выберите район</option>
                                            <?php endif;?>
                                        </select>    
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="row-form">
                                        <div class="errors-text">
                                            <?= (!empty($arguments['errors']['street'])) ? $arguments['errors']['street'] : '';?>
                                        </div>
                                        <label>Улица</label>
                                        <input type="text" name="street" class="form-input" value="<?= (!empty($arguments['result']['street']))? $arguments['result']['street'] : '';?>">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="row-form">
                                        <div class="errors-text">
                                            <?= (!empty($arguments['errors']['home'])) ? $arguments['errors']['home'] : '';?>
                                        </div>
                                        <label>Номер дома</label>
                                        <input type="text" name="home" class="form-input" value="<?= (!empty($arguments['result']['home']))? $arguments['result']['home'] : '';?>">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="row-form">
                                        <div class="errors-text">
                                            <?= (!empty($arguments['errors']['apartament'])) ? $arguments['errors']['apartament'] : '';?>
                                        </div>
                                        <label>Номер квартиры</label>
                                        <input type="text" name="apartament" class="form-input" value="<?= (!empty($arguments['result']['apartament']))? $arguments['result']['apartament'] : '';?>">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="row-form">
                                        <div class="errors-text">
                                            <?= (!empty($arguments['errors']['floor'])) ? $arguments['errors']['floor'] : '';?>
                                        </div>
                                        <label>Этаж</label>
                                        <input type="text" name="floor" class="form-input" value="<?= (!empty($arguments['result']['floor']))? $arguments['result']['floor'] : '';?>">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="row-form">
                                        <div class="errors-text">
                                            <?= (!empty($arguments['errors']['floor_all'])) ? $arguments['errors']['floor_all'] : '';?>
                                        </div>
                                        <label>Этажей в здании</label>
                                        <input type="text" name="floor_all" class="form-input" value="<?= (!empty($arguments['result']['floor_all']))? $arguments['result']['floor_all'] : '';?>">
                                        <div class="clearfix"></div>
                                    </div>
                                    
                                </div>
                                <div class="right-form">
                                    <div class="row-form">
                                        <div class="errors-text">
                                            <?= (!empty($arguments['errors']['type'])) ? $arguments['errors']['type'] : '';?>
                                        </div>
                                        <label>Тип объекта</label>
                                        <select class="form-select" name="type">
                                            <option value="">Выберете тип</option>
                                            <?php foreach ($arguments['params_add']['type'] as $key => $value) :?>
                                            <option <?= ($arguments['result']['type'] == $value['id_type']) ? 'selected="selected"':'';?> value="<?=$value['id_type']?>"><?=$value['type']?></option>    
                                            <?php endforeach;?>
                                        </select>    
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="row-form">
                                        <div class="errors-text">
                                            <?= (!empty($arguments['errors']['public_square'])) ? $arguments['errors']['public_square'] : '';?>
                                        </div>
                                        <label>Площадь общая</label>
                                        <input type="text" name="public_square" class="form-input" value="<?= (!empty($arguments['result']['public_square']))? $arguments['result']['public_square'] : '';?>">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="row-form">
                                        <div class="errors-text">
                                            <?= (!empty($arguments['errors']['life_square'])) ? $arguments['errors']['life_square'] : '';?>
                                        </div>
                                        <label>Площадь жилая</label>
                                        <input type="text" name="life_square" class="form-input" value="<?= (!empty($arguments['result']['life_square']))? $arguments['result']['life_square'] : '';?>">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="row-form">
                                        <div class="errors-text">
                                            <?= (!empty($arguments['errors']['kitchen'])) ? $arguments['errors']['kitchen'] : '';?>
                                        </div>
                                        <label>Кухня</label>
                                        <input type="text" name="kitchen" class="form-input" value="<?= (!empty($arguments['result']['kitchen']))? $arguments['result']['kitchen'] : '';?>">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="row-form">
                                        <div class="errors-text">
                                            <?= (!empty($arguments['errors']['price'])) ? $arguments['errors']['price'] : '';?>
                                        </div>
                                        <label>Стоимость</label>
                                        <input type="text" name="price" class="form-input" value="<?= (!empty($arguments['result']['price']))? $arguments['result']['price'] : '';?>">
                                        <div class="clearfix"></div>
                                    </div>
                                    
                                    
                                    <div class="row-form row-textarea">
                                        <div class="errors-text">
                                            <?= (!empty($arguments['errors']['comment'])) ? $arguments['errors']['comment'] : '';?>
                                        </div>
                                        <label>Текст объявления</label>
                                        <textarea class="form-input" name="comment"><?= (!empty($arguments['result']['comment']))? $arguments['result']['comment'] : '';?></textarea>
                                        <div class="clearfix"></div>
                                    </div>
                                    
                                </div> 
                            </div>
                            <div class="table-block schedule-form">
                                <div class="left-form">
                                    <div class="row-form form-time">
                                        <div class="errors-text">
                                            <?= (!empty($arguments['errors']['from'])) ? $arguments['errors']['from'] : '';?>
                                        </div>
                                        <label>Показываю &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;с</label>

                                        <?php 
                                            $start_time = date('H:i', mktime(6, 0, 0, 7, 1, 2000)); 
                                            $end_time = date('H:i', mktime(23, 0, 0, 7, 1, 2000));
                                            $time = $start_time;
                                        ?>
                                        <select class="form-select" name="from">
                                            <?php while(strtotime($time)<strtotime($end_time)) : ?>
                                            <option <?= (strtotime($time) == strtotime($arguments['result']['time_start'])) ? 'selected="selected"' : '';?> value="<?=$time?>"><?=$time?></option>>
                                            <?php $time = date('H:i', strtotime($time) + 15*60)?>
                                            <?php endwhile;?>
                                        </select>  

                                        <div class="clearfix"></div>
                                    </div>
                                </div>    
                                <div class="right-form">
                                    <div class="row-form">
                                        <div class="errors-text">
                                            <?= (!empty($arguments['errors']['to'])) ? $arguments['errors']['to'] : '';?>
                                        </div>
                                        <label class="text-do">до</label>

                                        <?php 
                                            $start_time = date('H:i', mktime(6, 0, 0, 7, 1, 2000)); 
                                            $end_time = date('H:i', mktime(23, 0, 0, 7, 1, 2000));
                                            $time = $start_time;
                                        ?>
                                        <select class="form-select" name="to">
                                            <?php while(strtotime($time)<strtotime($end_time)) : ?>
                                            <option  <?= (strtotime($time) == strtotime($arguments['result']['time_end'])) ? 'selected="selected"' : '';?> value="<?=$time?>"><?=$time?></option>>
                                            <?php $time = date('H:i', strtotime($time) + 15*60)?>
                                            <?php endwhile;?>
                                        </select>


                                        <div class="clearfix"></div>
                                    </div>
                                </div>    
                            </div> 
                                
                        </div>
                    </div>
                </div>
                    
                  
                    
                
                <div class='block-padding moder-btn-bot bottom-line'>    
                        <button name="save" type="submit" class="btn btn-green">Одобрить</button>
                </form>    
                    
                <form  action="/moderation/banObject/<?=$arguments['result']['id']?>" method="post" name="moder-form" class="moder-form class-form podat-form" enctype="multipart/form-data">
                        <button name="ban" type="submit" class="btn btn-red">Отклонить</button>
                </form>  
                </div>
                    
                <div class='block-padding bottom-line'>
                    
                    <div class="block-news-moder">
                        
                        <div class='title-moder-object'>Все объявления пользователя</div>
                        
                        <?php foreach ($arguments['all_object'] as $key => $value) : ?>
                        <div class='moder-object-row'>
                            <div class="result-img-wrap">
                                <div class="result-img">
                                    <a href="<?=$arguments['element_href']?><?=$value['id']?>">
                                        <?php if((!empty($value['main_image']))&&(file_exists(heretic::$_path['images_thumb'].$value['main_image']))) :?>
                                            <img src="/<?= heretic::$_path['images_thumb'].$value['main_image'];?>">
                                        <?php else :?>
                                            <img src="/<?= heretic::$_path['template'];?>img/no_images.jpg">
                                        <?php endif;?>
                                    </a>    
                                </div>    
                            </div>    
                            <div class="result-text">
                                <div class="object-name"><a href="/objects/object/<?=$value['id']?>"><?=$value['type']?> <?= (!empty($value['public_square'])) ? $value['public_square'] . ' м&#178;' : '';?></a></div>
                                <div class='object-date'><?=$this->converteDate($value['date_create'], 'dateTime')?></div>
                                <div class="object-price"> <?=$this->smarty_modifier_sum_convert($value['price'], 'summa')?></div>
                                <div class="object-place"><?=$value['street']?></div>
                            </div>
                        </div>
                        <?php endforeach;?>
                        
                    </div>  
                   
                </div>      
                    
                    
            </div>
        </div>    
        <div class="clearfix"></div>    
    </div>    
</div>

