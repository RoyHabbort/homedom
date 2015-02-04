<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/admin"><?=heretic::$_config['titlePage']?></a>
                &rarr;
                <span><?= (!empty($arguments['result']['title']))? $arguments['result']['title'] : '';?></span>
            </div>
        </div>  
        <?php heretic::Widget('usersMenu', 'admin');?>
        <div class="white-block">
            <div class="btn-back" onclick="history.back()">
                Назад
            </div>
            <div class="padding-title title-big"><?= (!empty($arguments['result']['title']))? $arguments['result']['title'] : '';?></div>
            
            <div class="success-flash block-padding">
                <?= heretic::getFlash('success');?>
            </div>   
            <div class="errors-text">
                <?= (!empty($arguments['errors']['sql_error'])) ? $arguments['errors']['sql_error'] : '';?>
            </div>
            <div class="block-padding">
                <form  action="/admin/page/<?=$arguments['result']['id']?>"  method="post" name="edit-form" class="edit-form class-form podat-form" enctype="multipart/form-data">
                
                    <div class="row-news">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['title'])) ? $arguments['errors']['title'] : '';?>
                        </div>
                        <label>Заголовок страницы:</label>
                        <input type="text" name="title" class="form-input" value="<?= (!empty($arguments['result']['title']))? $arguments['result']['title'] : '';?>">
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="row-news">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['text'])) ? $arguments['errors']['text'] : '';?>
                        </div>
                        <label>Текст страницы:</label>
                        <textarea id="CKeditor" class="form-input" name="text"><?= (!empty($arguments['result']['text']))? $arguments['result']['text'] : '';?></textarea>
                        <div class="clearfix"></div>
                    </div>
                    
                    <button type="submit" class="btn btn-green">Сохранить</button>
            </div>
        </div>    
        <div class="clearfix"></div>    
    </div>    
</div>

