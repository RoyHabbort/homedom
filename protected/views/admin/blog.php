<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/admin/"><?=heretic::$_config['titlePage']?></a>
                &rarr;
                <span>Подготовка к сделке</span>
            </div>
        </div>    
        <?php heretic::Widget('usersMenu', 'admin');?>
        <div class="white-block">
            <div class="padding-title title-big">
                <span>Подготовка к сделке</span>
                <div class="float-right">
                    <a href="/admin/addBlog" class="btn btn-green">Добавить запись</a>
                </div>
            </div>
            
            <div class="success-flash block-padding">
                <?= heretic::getFlash('success');?>
            </div> 
            
            
            <div class="block-padding">
                
                <?php heretic::Widget('list', $params = array(
                    'data' => $arguments['result'],
                    'href' => '/admin/blog/' ,
                    'element_href'=> '/admin/editBlog/',
                    'views' => '_blog',
                    'count_elment' => '10',
                    'page' => $arguments['page'],
                    'pagination_type' => 1,
                ));?>
                
            </div>    
        </div>    
    </div>    
</div>

