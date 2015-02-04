<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/admin/"><?=heretic::$_config['titlePage']?></a>
                &rarr;
                <span>Города</span>
            </div>
        </div>    
        <?php heretic::Widget('usersMenu', 'admin');?>
        <div class="white-block">
            <div class="padding-title title-big">
                <span>Редактировать города</span>
                <div class="float-right">
                    <a href="/admin/createCity" class="btn btn-green">Создать город</a>
                </div> 
            </div>
            
            <div class="success-flash block-padding">
                <?= heretic::getFlash('success');?>
            </div>  
            
            <div class="error-text error-div">
                <?= heretic::getFlash('error');?>
            </div>    
            
            <?php foreach ($arguments['city'] as $key => $value) : ?>
                <div class="block-padding bottom-line">
                    <div class="city-title"><?=$value['city']?></div>
                    <a href="/admin/editCity/<?=$value['id_city']?>" class="btn btn-blue">Редактировать</a>
                    <!--a href="/admin/deleteCity/<?=$value['id_city']?>" onclick="return confirmDelete('city');" class="btn btn-red">Удалить</a-->
                </div>
            <?php endforeach;?>
               
            
        </div>    
    </div>    
</div>

