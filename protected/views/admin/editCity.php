<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/admin/"><?=heretic::$_config['titlePage']?></a>
                &rarr;
                <a href="/admin/city">Города</a>
                &rarr;
                <span>Редактирование города</span>
            </div>
        </div>    
        <?php heretic::Widget('usersMenu', 'admin');?>
        <div class="white-block">
            <div class="btn-back" onclick="history.back()">
                Назад
            </div>
            <div class="padding-title title-big">
                <span>Редактирование города</span>
            </div>
            
            <div class="red-text block-padding">
                Внимание!!! Изменение данной информации скажется на всех объявлениях. Редактируйте внимательно.
            </div>  
            
            <div class="error-text error-div">
                <?= heretic::getFlash('error');?>
            </div>    
            
            
            <form  action="/admin/editCity/<?=$arguments['post']['id_city']?>"  method="post" name="edit-city" class="edit-form class-form podat-form" enctype="multipart/form-data">
                <div class="city-add block-padding">
                    <div class="errors-text">
                        <?= (!empty($arguments['errors']['sql_error'])) ? $arguments['errors']['sql_error'] : '';?>
                    </div>
                    <div class="row-form">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['city'])) ? $arguments['errors']['city'] : '';?>
                        </div>
                        <label>Город:</label>
                        <input type="text" name="city" class="form-input" value="<?= (!empty($arguments['post']['city']))? $arguments['post']['city'] : '';?>">
                        <div class="clearfix"></div>
                    </div>    
                    <div class="row-form">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['cy'])) ? $arguments['errors']['cy'] : '';?>
                        </div>
                        <label>Широта:</label>
                        <input type="text" name="cy" class="form-input" value="<?= (!empty($arguments['post']['coord_y']))? $arguments['post']['coord_y'] : '';?>">
                        <div class="clearfix"></div>
                    </div>    
                    <div class="row-form">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['cx'])) ? $arguments['errors']['cx'] : '';?>
                        </div>
                        <label>Долгота:</label>
                        <input type="text" name="cx" class="form-input" value="<?= (!empty($arguments['post']['coord_x']))? $arguments['post']['coord_x'] : '';?>">
                        <div class="clearfix"></div>
                    </div> 
                    <div class="row-form">
                        <button type="submit" class="btn btn-green float-right">Сохранить</button>
                        <div class="clearfix"></div>
                    </div>    
                </div>    
            </form>
            
            <div class="block-padding">
                <div class="title-big">
                    Районы
                </div>    
            </div>    
            
            <div class="error-text error-district">
                
            </div>
            
            <div class="all-district">
                <?php if(empty($arguments['district']['errors'])) : ?>
                    <?php foreach ($arguments['district'] as $key => $value) : ?>
                        <div class="block-padding bottom-line district-row">
                            <div class="city-title"><?=$value['district']?></div>
                            <div  class="btn btn-red district-unconfirm-delete">Удалить</div>
                            <div class="confirm-district hidden">
                                <div class="select-to-new-district podat-form">
                                    <label>Куда перенести объявления</label>
                                    <select class="form-select" name="stnd-select">
                                        <?php foreach ($arguments['district'] as $key2 => $value2) : ?>
                                            <?php if($value['id_district'] != $value2['id_district']) : ?>
                                        <option value="<?=$value2['id_district']?>"><?=$value2['district']?></option>
                                            <?php endif;?>
                                        <?php endforeach;?>
                                    </select>
                                </div>  
                                <div class="confirm-delete-district">
                                    <div data-id-district = "<?=$value['id_district']?>" class="btn btn-blue district-delete">Подтвердить</div>
                                </div>   
                            </div>    
                        </div>
                    <?php endforeach; ?>
                <?php endif;?>
            </div>   
            
            <div class="block-padding">
                <input type="text" name="district" class="form-input district-input" >
                <div data-id-city="<?=$arguments['post']['id_city']?>" class="btn btn-green add-district">Добавить район</a>
            </div>    
            
        </div>    
    </div>    
</div>

