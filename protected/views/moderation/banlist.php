<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/moderation"><?=heretic::$_config['titlePage']?></a>
                &rarr;
                <span>Бан Лист</span>
            </div>
        </div>    
        <?php heretic::Widget('usersMenu', 'moder');?>
        <div class="white-block">
            <div class="padding-title title-big">Бан Лист</div>
            
            <div class="errors-text padding-title">
                <?= (!empty($arguments['errors']['sql_error'])) ? $arguments['errors']['sql_error'] : '';?>
            </div>
            <div class="block-padding block-moder-filter">
                <form action="/moderation/banlist/" method="post" name="moder-form" class="moder-form class-form podat-form">
                    <div class="row-filter">
                        <input name="phone" class="form-input">
                        <button type="submit" class="btn btn-green">Найти</button>
                    </div>    
                </form>    
            </div>    
            <div class="block-padding">
            <?php if(!empty($arguments['result'])) : ?>   
             
            <?php heretic::Widget('list', $params = array(
                    'data' => $arguments['result'],
                    'href' => '/moderation/banlist/',
                    'views' => '_banlist',
                    'count_elment' => '10',
                    'page' => $arguments['page'],
                    'pagination_type' => 1,
                ));?>
            <?php endif;?>    
            </div>    
        </div>    
    </div>    
</div>

