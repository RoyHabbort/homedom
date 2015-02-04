<div class="conteiner index-page">
    <div class="content-width">
        <div class="main-menu">
            <div class="float-left cube4x">
                <div class="cube4x-hover  yellow-cube">
                    <p>Продажа<br/> недвижимости<br/> без посредников -<br/> <b>это просто</b></p>
                    <?php if($arguments['ifGetCode']) :?>
                    <a class='getcode' href='/code/getcode'>Получить код доступа на сайт</a>
                    <?php endif;?>
                </div>
            </div>    
            <div class="float-left cube2x">
                <a href="/objects/search/sell" class="cube2x  blue-cube">
                    <p>Продажа</p>
                </a>
            </div> 
            <!--div class="float-left cube">
                <a href="/objects/search/buy" class="cube  white-cube">
                    <p>Купить</p>
                </a>
            </div-->
            <div class="float-left cube2x">
                <a href="/objects/search/" class="cube2x  yellow-cube">
                    <p>ПОИСК квартир</p>
                </a>
            </div>
            
            <div class="float-left cube2x">
                <a href="/objects/search/renting" class="cube2x  white-cube">
                    <p>Аренда</p>
                </a>
            </div> 
            <!--div class="float-left cube">
                <a href="/objects/search/rentals" class="cube  blue-cube">
                    <p>Снять</p>
                </a>
            </div-->
            <div class="float-left cube2x">
                <a href="/objects/addObject" class="cube2x  green-cube">
                    <p>Подать объявление</p>
                </a>
            </div>
            
            <div class="float-left fat-cube">
                <a href="/page/about" class="fat-cube  blue-cube">
                    <p>О сайте</p>
                </a>
            </div>
            <div class="float-left fat-cube">
                <a href="/news/lists" class="fat-cube  green-cube">
                    <p>Новости</p>
                </a>
            </div>
            <div class="float-left img-cube">
                <a <?= (!empty($arguments['image']['id_blog'])) ? 'href="/blog/view/' . $arguments['image']['id_blog'] . '"' : 'href="/news/news/' . $arguments['image']['id'] . '"' ?>  class="img-cube">
                    <span class="main-image-title"><?=heretic::previewText($arguments['image']['title'], 200)?></span>
                    <?php if((!empty($arguments['image']['image']))&&(file_exists(heretic::$_path['front_images'].$arguments['image']['image']))) :?>
                        <img src="/<?= heretic::$_path['front_images'].$arguments['image']['image'];?>">
                    <?php else :?>
                        <img src="/<?= heretic::$_path['template'];?>img/main-cube.png">
                    <?php endif;?>
                </a>
            </div>
            <div class="float-left cube">
                <a href="/blog" class="cube  white-cube">
                    <p>Подготовка к сделке</p>
                </a>
            </div>
            <div class="float-left cube">
                <a href="/page/help" class="cube  blue-cube">
                    <p>Помощь в оформлении</p>
                </a>
            </div>
            
            <div class="clearfix"></div>
        </div>    
    </div>
</div>    