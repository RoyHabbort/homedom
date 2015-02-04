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
                <span>Создание города</span>
            </div>
        </div>    
        <?php heretic::Widget('usersMenu', 'admin');?>
        <div class="white-block">
            <div class="btn-back" onclick="history.back()">
                Назад
            </div>
            <div class="padding-title title-big">
                <span>Создание города</span>
            </div>
            
            <div class="success-flash block-padding">
                <?= heretic::getFlash('success');?>
            </div>  
            
            <div class="error-text error-div">
                <?= heretic::getFlash('error');?>
            </div>    
            
            <form  action="/admin/createCity/"  method="post" name="add-city" class="edit-form class-form podat-form" enctype="multipart/form-data">
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
                        <input type="text" name="cy" class="form-input" value="<?= (!empty($arguments['post']['cy']))? $arguments['post']['cy'] : '';?>">
                        <div class="clearfix"></div>
                    </div>    
                    <div class="row-form">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['cx'])) ? $arguments['errors']['cx'] : '';?>
                        </div>
                        <label>Долгота:</label>
                        <input type="text" name="cx" class="form-input" value="<?= (!empty($arguments['post']['cx']))? $arguments['post']['cx'] : '';?>">
                        <div class="clearfix"></div>
                    </div> 
                    <div class="row-form">
                        <button type="submit" class="btn btn-green float-right">Создать</button>
                        <div class="clearfix"></div>
                    </div>    
                </div>    
            </form>    
               
            
        </div>    
    </div>    
</div>

