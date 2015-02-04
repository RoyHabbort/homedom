<div class="conteiner">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <span>Поиск квартир</span>
            </div>
        </div>
        <div class="search-wrap">
            <div class="float-left inner-cube cube-search green-cube">
                <p>Поиск квартир</p>
            </div>
            
            <div class="right-place bottom-line white-block search-block">
                <form action="/objects/postSearch" method="post" name="search" class="class-form podat-form">
                    <div class="table-block">
                        <div class="left-form">
                            <div class="row-form">
                                <label>Город</label>
                                <select name='city' class="form-select">
                                    <option value="">Любой город</option>
                                    <?php foreach ($arguments['params_add']['city'] as $key => $value) :?>
                                    <option data_x="<?=$value['coord_x']?>" data_y="<?=$value['coord_y']?>" <?php if (!empty($_SESSION['postSearch']['city'])){ echo ($value['id_city'] == $_SESSION['postSearch']['city']) ? 'selected="selected"' : '' ;} ?> value="<?=$value['id_city']?>"><?=$value['city']?></option>    
                                    <?php endforeach;?>
                                </select>    
                                <div class="clearfix"></div>
                            </div>
                            <div class="row-form">
                                <label>Категория</label>
                                <select class="form-select" name="category">
                                    <!-- option value="">Любая категория</option -->
                                    <?php foreach (heretic::$_config['extend_config']['category'] as $key => $value) : ?>
                                    <option <?= ($key==$_SESSION['postSearch']['category']) ? 'selected="selected"':'';?> value="<?=$key?>"><?=$value?></option>
                                    <?php endforeach;?>
                                </select>
                                <div class="clearfix"></div>
                            </div>
                            
                            <div class="row-form">
                                <label>Тип объекта</label>
                                <select class="form-select" name="type">
                                    <option value="">Выберете тип</option>
                                    <?php foreach ($arguments['params_add']['type'] as $key => $value) :?>
                                    <option <?= ($_SESSION['postSearch']['type'] == $value['id_type']) ? 'selected="selected"':'';?> value="<?=$value['id_type']?>"><?=$value['type']?></option>    
                                    <?php endforeach;?>
                                </select>  
                                <div class="clearfix"></div>
                            </div>
                            
                            <div class="row-form two-line-form">
                                <span>Площадь </span>
                                <label>от</label>
                                <input name='square_min' type="text" name="" class="form-input " value='<?= (!empty($_SESSION['postSearch']['square_min'])) ? $_SESSION['postSearch']['square_min'] : '';?>'>
                                <label>до</label>
                                <input name='square_max' type="text" name="" class="form-input" value='<?= (!empty($_SESSION['postSearch']['square_max'])) ? $_SESSION['postSearch']['square_max'] : '';?>'>
                                <div class="clearfix"></div>
                            </div>
                            
                        </div>
                        <div class="right-form">
                            <div class="row-form">
                                <label>Район</label>
                                <select name='district' class="form-select">
                                    <option value="">Любой район</option>
                                    <?php if(!empty($arguments['params_add']['district'])) : ?>
                                        <?php foreach ($arguments['params_add']['district']as $key => $value) : ?>
                                        <option <?= ($value['id_district'] == $_SESSION['postSearch']['district']) ? 'selected="selected"' : '' ; ?> value="<?=$value['id_district']?>"><?=$value['district']?></option>    
                                        <?php endforeach;?>
                                    <?php endif;?>
                                </select>
                                <div class="clearfix"></div>
                            </div>
                            <div class="row-form">
                                <label>Стоимость от</label>
                                <input name='price_min' type="text" name="" class="form-input" value='<?= (!empty($_SESSION['postSearch']['price_min'])) ? $_SESSION['postSearch']['price_min'] : '';?>'>
                                <div class="clearfix"></div>
                            </div>
                            <div class="row-form">
                                <label>до</label>
                                <input name='price_max' type="text" name="" class="form-input" value='<?= (!empty($_SESSION['postSearch']['price_max'])) ? $_SESSION['postSearch']['price_max'] : '';?>'>
                                <div class="clearfix"></div>
                            </div>
                       
                            <div class="search-map-button">
                                <div class="btn btn-blue">Поиск по карте</div>
                            </div>    

                            <div class="row-form search-submit">
                                <button type="submit" class="btn btn-green">Найти</button>
                                <div class="clearfix"></div>
                            </div>    
                        </div> 
                    </div>  
                    
                    
                    <input class="hidden" id="geometry" type="text" name="coordinate" value="">
                    
                </form>    
            </div>    
            <div class="clearfix"></div> 
        </div>
        
        <?php if($arguments['code_accept']) : ?>
        <div class="search-map-block block-padding bottom-line white-block search-hidden">
            <div class="block-btn-map">
                <div class="btn btn-blue map-btn-add">
                    Отметить область на карте
                </div>    
                <div class="btn hidden map-btn-stop">
                    Завершить редактирование
                </div>    
                <div class="btn btn-red map-btn-clear">
                    Очистить
                </div>   
                <div class="btn btn-green map-btn-search">
                    Найти в указанной области
                </div>    
            </div>
            <div class="error-search red-text padding-bottom-20">
            </div>    
            <div id="map-search" class="map-search" style="widht:900px;height:560px">
                
            </div>    
        </div>  
        <?php endif;?>
        <div class="search-result-wrap white-block">
            <div class="search-result">
                <?php if(empty($arguments['result'])) : ?>
                    <div class="result-count">
                        <span>Объявлений не найдено</span>
                    </div>  
                <?php else :?>
                    <div class="result-count">
                        <span>Найдено <?=count($arguments['result'])?> <?= $this->smarty_modifier_string_declination(count($arguments['result']))?></span>
                    </div>   

                    <?php 
                        $href = '/objects/search/';
                        if (!empty($_SESSION['postSearch']['category'])) $href .=$_SESSION['postSearch']['category'] . '/';
                    ?>

                    <?php if($arguments['code_accept']) : ?>
                        <div class="for-yandex-map hidden">
                            <?php foreach ($arguments['result'] as $key => $value) : ?>

                            <div class="ya-object" data-id="<?=$value['id']?>" data-category="<?=$value['category']?>"
                                 data-city="<?=$value['city']?>" data-type="<?=$value['type']?>"
                                 data-street="<?=$value['street']?>" data-home="<?=$value['home']?>" data-apartament="<?=$value['apartament']?>"
                                 data-square="<?= (!empty($value['public_square'])) ? $value['public_square'] : '' ;?>" data-price="<?=$value['price']?>" > 
                            </div>    
                            <?php endforeach;?>
                        </div>    
                    <?php endif;?>

                    <?php heretic::Widget('list', $params = array(
                        'data' => $arguments['result'],
                        'href' => $href ,
                        'element_href'=> '/objects/object/',
                        'views' => '_object',
                        'count_elment' => 10,
                        'pagination_cout' => 10,
                        'page' => $arguments['page'],
                        'pagination_type' => 3,
                    ));?>


                    <div class="clearfix"></div>
                <?php endif;?>
            </div>    
            <div class="clearfix"></div>
        </div>    
    </div>    
</div>

<?php heretic::Widget('upWindow');?>


<!--div class="absolut-block hidden">
    
    <div class="block-padding">
        <p>
            Для активации функции "Поиск по карте" Вам необходимо 
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