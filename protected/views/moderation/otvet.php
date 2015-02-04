<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/moderation"><?=heretic::$_config['titlePage']?></a>
                &rarr;
                <span>Рейтинг ответов</span>
            </div>
        </div>    
        <?php heretic::Widget('usersMenu', 'moder');?>
        <div class="white-block">
            <div class="padding-title title-big">Ретинг ответов</div>
            
            <div class='block-padding'>
                
                <?php foreach($arguments['result'] as $key => $value) : ?>
                    <div class='otvet-row'>
                        <span class='label-to-otvet'>
                            <?=$key?>
                        </span>
                        <span class='pole-to-otvet'>
                            <?=$value?>
                        </span>    
                    </div>
                <?php endforeach;?>
                
               
                
            </div>    
            
          
        </div>    
    </div>    
</div>

