<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/users">Личный кабинет</a>
                &rarr;
                <span>Редактирование объявления</span>
            </div>
        </div> 
        <?php heretic::Widget('usersMenu', 'users');?>
        <div class="white-block">
            <div class="btn-back" onclick="history.back()">
                Назад
            </div>
            <?php  if(!empty($arguments['result'])) : ?>
                <div class="padding-title title-big">Редактирование объявления</div>   
                
                <div class="float-left">
                    <div class="float-left edit-photo">
                        <img src="<?=  (($arguments['result']['main_image'])&&(file_exists( heretic::$_path['front_images'] . $arguments['result']['main_image']))) ? '/' . heretic::$_path['front_images'] . $arguments['result']['main_image'] : '/' . heretic::$_path['template'] . 'img/no_images.jpg';?> ">
                    </div> 
                    <div class="clearfix"></div>
                    <div class="white-block block-add-photo width-340">
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
                                        <form class="form-for-delete" action="/users/deletePhoto/<?=$arguments['result']['id']?>" method="post" name="photogallery-form" class="moder-form class-form podat-form">
                                            <input type="hidden" name="photo_id" value="<?=$value['id_photo']?>">
                                            <button type="submit" name="for-felete" class="btn btn-close upload-delete"><img class="img-close" src="/<?= heretic::$_path['template']?>img/icons/icon-close.png"></button>
                                        </form>
                                    </div>    
                                </div>  
                            <?php endforeach;?>
                            
                        </div>  
                        <div class="clearfix"></div>
                    </div>
                    
                </div>
                
                <div class='float-right edit-object'>
                <?php if(!empty($arguments['success'])) : ?><div class="success-result"><?= $arguments['success']?></div><?php endif;?>
                    <div class="edit-div-form">
                        <form action="/users/object/<?=$arguments['result']['id']?>" method="post" name="edit-form" class="edit-form class-form podat-form" enctype="multipart/form-data">
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
                            </div>
                            
                            
                            <div class="table-block schedule-form bottom-line">
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
                            
                            <div class="white-block padding-top-20">
                                <div class="float-right block-bottom width-300">
                                    <div class="errors-text">
                                            <?= (!empty($arguments['errors']['load-photo'])) ? $arguments['errors']['load-photo'] : '';?>
                                    </div>
                                    <input type="submit" class="hidden">
                                    <label id="load-photo" class="load-photo">
                                        <span class="inner-label-load">
                                            <span class="dashed-cube">
                                                <span>Загрузить фото</span>
                                            </span>
                                            
                                        </span>
                                    </label>
                                    <div class="form-submit">
                                        <span>Сохранить</span>
                                    </div>    
                                </div> 
                                <div class="clearfix"></div>
                            </div>    
                        </form>
                    </div>
                
                    
                </div>
                
                
                
                
                <div class="clearfix"></div>
                    
            <?php else : ?>
                <div class="block-padding">
                    <p>Запрашиваемое объявление не найдено</p>
                </div>    
            <?php endif;?>
                
            <div class="clearfix"></div>    
        </div>
    </div>    
</div>

