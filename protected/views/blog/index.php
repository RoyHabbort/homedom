<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <span><?= heretic::$_config['titlePage'];?></span>
            </div>
        </div>  
        <?php heretic::Widget('usersMenu', 'blog');?>
        <div class="white-block right-place">
            <div class="padding-title title-big">
                <?= $arguments['page_name']?>
            </div>    
            <div>
                <?php if(!empty($arguments['type'])) $blog = '/blog/' . $arguments['type'] . '/'; else $blog = '/blog/' ;?>
                <?php heretic::Widget('list', $params = array(
                    'data' => $arguments['result'],
                    'href' => $blog,
                    'element_href'=> '/blog/view/',
                    'views' => '_blog',
                    'count_elment' => '10',
                    'page' => $arguments['page'],
                    'pagination_type' => 1,
                ));?>
                
            </div>    
        </div>
        <div class="clearfix"></div>
    </div>    
</div>

