<div class="conteiner podat-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <span>Подать объявление</span>
            </div>
        </div>    
        <form action="/objects/addObject" method="post" name="object-form" class="class-form podat-form" enctype="multipart/form-data">
        <div class="float-left ">
            <div class="left-place green-cube">
                <p>Подать<br/> объявление</p>
            </div>
            <div class="clearfix"></div>
            <div class="white-block">
                <div >
                </div>    
            </div>
        </div>
            
        <div class="right-place addForm">
            
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
                                    <option <?= ($key==$arguments['post']['category']) ? 'selected="selected"':'';?> value="<?=$key?>"><?=$value?></option>
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
                                    <option <?= ($value['id_city'] == $arguments['post']['city']) ? 'selected="selected"' : '' ; ?> value="<?=$value['id_city']?>"><?=$value['city']?></option>    
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
                                    <option value="">Выберите район</option>
                                    <?php if(!empty($arguments['params_add']['district'])) : ?>
                                        <?php foreach ($arguments['params_add']['district']as $key => $value) : ?>
                                        <option <?= ($value['id_district'] == $arguments['post']['district']) ? 'selected="selected"' : '' ; ?> value="<?=$value['id_district']?>"><?=$value['district']?></option>    
                                        <?php endforeach;?>
                                    <?php endif;?>
                                </select>    
                                <div class="clearfix"></div>
                            </div>
                            <div class="row-form">
                                <div class="errors-text">
                                    <?= (!empty($arguments['errors']['street'])) ? $arguments['errors']['street'] : '';?>
                                </div>
                                <label>Улица</label>
                                <input type="text" name="street" class="form-input" value="<?= (!empty($arguments['post']['street']))? $arguments['post']['street'] : '';?>">
                                <div class="clearfix"></div>
                            </div>
                            <div class="row-form">
                                <div class="errors-text">
                                    <?= (!empty($arguments['errors']['home'])) ? $arguments['errors']['home'] : '';?>
                                </div>
                                <label>Номер дома</label>
                                <input type="text" name="home" class="form-input" value="<?= (!empty($arguments['post']['home']))? $arguments['post']['home'] : '';?>">
                                <div class="clearfix"></div>
                            </div>
                            <div class="row-form">
                                <div class="errors-text">
                                    <?= (!empty($arguments['errors']['apartament'])) ? $arguments['errors']['apartament'] : '';?>
                                </div>
                                <label>Номер квартиры</label>
                                <input type="text" name="apartament" class="form-input" value="<?= (!empty($arguments['post']['apartament']))? $arguments['post']['apartament'] : '';?>">
                                <div class="clearfix"></div>
                            </div>
                            <div class="row-form">
                                <div class="errors-text">
                                    <?= (!empty($arguments['errors']['floor'])) ? $arguments['errors']['floor'] : '';?>
                                </div>
                                <label>Этаж</label>
                                <input type="text" name="floor" class="form-input" value="<?= (!empty($arguments['post']['floor']))? $arguments['post']['floor'] : '';?>">
                                <div class="clearfix"></div>
                            </div>
                            <div class="row-form">
                                <div class="errors-text">
                                    <?= (!empty($arguments['errors']['floor_all'])) ? $arguments['errors']['floor_all'] : '';?>
                                </div>
                                <label>Этажей в здании</label>
                                <input type="text" name="floor_all" class="form-input" value="<?= (!empty($arguments['post']['floor_all']))? $arguments['post']['floor_all'] : '';?>">
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
                                    <option <?= ($arguments['post']['type'] == $value['id_type']) ? 'selected="selected"':'';?> value="<?=$value['id_type']?>"><?=$value['type']?></option>    
                                    <?php endforeach;?>
                                </select>    
                                <div class="clearfix"></div>
                            </div>
                            <div class="row-form">
                                <div class="errors-text">
                                    <?= (!empty($arguments['errors']['public_square'])) ? $arguments['errors']['public_square'] : '';?>
                                </div>
                                <label>Площадь общая</label>
                                <input type="text" name="public_square" class="form-input" value="<?= (!empty($arguments['post']['public_square']))? $arguments['post']['public_square'] : '';?>">
                                <div class="clearfix"></div>
                            </div>
                            <div class="row-form">
                                <div class="errors-text">
                                    <?= (!empty($arguments['errors']['life_square'])) ? $arguments['errors']['life_square'] : '';?>
                                </div>
                                <label>Площадь жилая</label>
                                <input type="text" name="life_square" class="form-input" value="<?= (!empty($arguments['post']['life_square']))? $arguments['post']['life_square'] : '';?>">
                                <div class="clearfix"></div>
                            </div>
                            
                            <div class="row-form">
                                <div class="errors-text">
                                    <?= (!empty($arguments['errors']['kitchen'])) ? $arguments['errors']['kitchen'] : '';?>
                                </div>
                                <label>Кухня</label>
                                <input type="text" name="kitchen" class="form-input" value="<?= (!empty($arguments['post']['kitchen']))? $arguments['post']['kitchen'] : '';?>">
                                <div class="clearfix"></div>
                            </div>
                            
                            <div class="row-form">
                                <div class="errors-text">
                                    <?= (!empty($arguments['errors']['price'])) ? $arguments['errors']['price'] : '';?>
                                </div>
                                <label>Стоимость</label>
                                <input type="text" name="price" class="form-input" value="<?= (!empty($arguments['post']['price']))? $arguments['post']['price'] : '';?>">
                                <div class="clearfix"></div>
                            </div>
                            
                            
                            <div class="row-form row-textarea">
                                <div class="errors-text">
                                    <?= (!empty($arguments['errors']['comment'])) ? $arguments['errors']['comment'] : '';?>
                                </div>
                                <label>Текст объявления</label>
                                <textarea class="form-input" name="comment"><?= (!empty($arguments['post']['comment']))? $arguments['post']['comment'] : '';?></textarea>
                                <div class="clearfix"></div>
                            </div> 
                        </div> 
                    </div>
                </div>
                
                <div class="white-block schedule-form">
                    
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
                                <option <?= (strtotime($time) == strtotime('8:00')) ? 'selected="selected"' : '';?> value="<?=$time?>"><?=$time?></option>>
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
                                <option  <?= (strtotime($time) == strtotime('21:00')) ? 'selected="selected"' : '';?> value="<?=$time?>"><?=$time?></option>>
                                <?php $time = date('H:i', strtotime($time) + 15*60)?>
                                <?php endwhile;?>
                            </select>


                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>    
                
                <div class="white-block block-add-photo block-padding">
                    <div class="title-photogallery-add">
                        Фотографии
                    </div>
                    <div id="upload-photo-block" class="upload-photo-block">
                        
                    </div>
                    <div class="clearfix"></div>
                </div>    
            
                <?php if(!isset($_SESSION['phone'])) : ?>
                <div class="white-block">
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
                    <div class="table-block">
                        <div class="left-block">
                            <div class="row-form">
                                <div class="errors-text">
                                    <?= (!empty($arguments['errors']['email'])) ? $arguments['errors']['email'] : '';?>
                                </div>
                                <label>Введите Email</label>
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
                                    <?php foreach ($arguments['params_add']['city'] as $key => $value) :?>
                                    <option <?= ($value['city'] == $arguments['post']['user_city']) ? 'selected="selected"' : '' ; ?> value="<?=$value['city']?>"><?=$value['city']?></option>    
                                    <?php endforeach;?>
                                </select>  
                                <div class="clearfix"></div>
                            </div> 
                        </div>
                        <div class="right-block block-bottom">
                            <div class="errors-text">
                                    <?= (!empty($arguments['errors']['load-photo'])) ? $arguments['errors']['load-photo'] : '';?>
                            </div>
                            <input type="submit" class="hidden">
                            <label id="load-photo" class="load-photo">
                                <span class="inner-label-load">
                                    <span class="dashed-cube">
                                        <span>Загрузить фото</span>
                                    </span>
                                    <!--input id="load-photo" name="load-photo" type="file" class="hidden" accept="image/*"-->
                                </span>
                            </label>
                            <div class="form-submit">
                                <span>Опубликовать</span>
                            </div>    
                            <div class="clearfix"></div>
                        </div>    
                    </div> 
                </div>
                <?php else :?>
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
                            <span>Опубликовать</span>
                        </div>    
                    </div> 
                    <div class="clearfix"></div>
                </div>    
                <?php endif;?>
        </div>    
        <div class="clearfix"></div>   
        </form>
    </div>    
</div>