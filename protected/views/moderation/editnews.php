<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/moderation"><?=heretic::$_config['titlePage']?></a>
                &rarr;
                <span>Новости</span>
            </div>
        </div>    
        <?php heretic::Widget('usersMenu', 'moder');?>
        <div class="white-block">
            <div class="padding-title title-big">
                <span>Новости</span>
                <div class="float-right">
                    <a href="/moderation/addNews" class="btn btn-green">Создать Новость</a>
                </div>  
            </div>
            
            <div class="success-flash block-padding">
                <?= heretic::getFlash('success');?>
            </div>  
            
            <div class="block-news-edit">
                <?php heretic::Widget('list', $params = array(
                    'data' => $arguments['result'],
                    'href' => '/moderation/editnews/',
                    'element_href'=> '/moderation/newseditpage/',
                    'views' => '_news',
                    'count_elment' => '10',
                    'page' => $arguments['page'],
                    'pagination_type' => 1,
                ));?>
            </div>    
            
        </div>    
    </div>    
</div>

