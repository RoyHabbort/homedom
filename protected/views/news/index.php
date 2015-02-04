<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <span><?= heretic::$_config['titlePage'];?></span>
            </div>
        </div>    
        <div class="left-place green-cube">
            <p><?= heretic::$_config['titlePage'];?></p>
        </div>
        <div class="right-place">
            <div class="white-block">
                <div class="text-place">
                    <?=$arguments['result']['text'];?>
                </div>
                <?php heretic::Widget('list', $params = array(
                    'data' => $arguments['all_news'],
                    'href' => '/news/lists/',
                    'element_href'=> '/news/news/',
                    'views' => '_news',
                    'count_elment' => '10',
                    'page' => $arguments['page'],
                    'pagination_type' => 3,
                ));?>
            </div>    
        </div>    
        <div class="clearfix"></div>    
    </div>    
</div>