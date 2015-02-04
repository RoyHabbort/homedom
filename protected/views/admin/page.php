<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <span><?=heretic::$_config['titlePage']?></span>
            </div>
        </div>    
        <?php heretic::Widget('usersMenu', 'admin');?>
        <div class="white-block">
            <div class="padding-title title-big">Типовые страницы</div>
            
            <div class="success-flash block-padding">
                <?= heretic::getFlash('success');?>
            </div>    
            
            <div class="block-padding">
                <div class="type-page-block ">
                    <div class="type-page-label">О сайте</div>
                    <a href="/admin/page/2" class="btn btn-green">Редактировать</a>
                </div>
                <div class="type-page-block ">
                    <div class="type-page-label">Помощь</div>
                    <a href="/admin/page/3" class="btn btn-green">Редактировать</a>
                </div>
            </div>
        </div>    
    </div>    
</div>

