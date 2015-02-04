<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/moderation"><?=heretic::$_config['titlePage']?></a>
                &rarr;
                <a href="/moderation/editnews">Новости</a>
                &rarr;
                <span>Редактирование новости</span>
            </div>
        </div>  
        <?php heretic::Widget('usersMenu', 'moder');?>
        <div class="white-block">
            <div class="btn-back" onclick="history.back()">
                Назад
            </div> 
            <div class="padding-title title-big">
                <span>Редактирование новости</span>
                <div class="float-right">
                    <a href="/moderation/deleteNews/<?=$arguments['result']['id']?>" class="btn btn-red">Удалить новость</a>
                </div>
            </div>
            
            <div class='errors-text'>
                <?= (!empty($arguments['errors']['sql_error'])) ? $arguments['errors']['sql_error'] : '' ;?>
            </div>    
            
            <div class="success-flash block-padding">
                <?= heretic::getFlash('success');?>
            </div>   
            
            <div class="block-padding">
                <form  <?= (!$arguments['add']) ? 'action="/moderation/newseditpage/' . $arguments['result']['id'] . '"' : 'action="/moderation/addNews"';?>  method="post" name="edit-form" class="edit-form class-form podat-form" enctype="multipart/form-data">
                
                    <div class="row-news">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['title'])) ? $arguments['errors']['title'] : '';?>
                        </div>
                        <label>Заголовок новости:</label>
                        <input type="text" name="title" class="form-input" value="<?= (!empty($arguments['result']['title']))? $arguments['result']['title'] : '';?>">
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="row-news">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['text'])) ? $arguments['errors']['text'] : '';?>
                        </div>
                        <label>Текст новости:</label>
                        <textarea id="CKeditor" class="form-input" name="text"><?= (!empty($arguments['result']['text']))? $arguments['result']['text'] : '';?></textarea>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="row-blog-edit">
                        <div class="moder-img">
                            <?php if((!empty($arguments['result']['image']))&&(file_exists(heretic::$_path['images_thumb'].$arguments['result']['image']))) :?>
                                <img src="/<?= heretic::$_path['images_thumb'].$arguments['result']['image'];?>">
                            <?php else :?>
                                <img src="/<?= heretic::$_path['template'];?>img/no_images.jpg">
                            <?php endif;?>
                        </div>    
                    </div>
                    
                    <div class="row-blog-edit bottom-line padding-bottom-20">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['image'])) ? $arguments['errors']['image'] : '';?>
                        </div>
                        <label>Загрузить картинку:</label>
                        <input type="file" accept="image/*" name="image"  value="<?= (!empty($arguments['result']['image']))? $arguments['result']['image'] : '';?>">
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class='row-news'>
                        <input id='for_main' name='for_main' type='checkbox'><label for='for_main'>На главную</label>
                    </div>
                    
                    
                    <button type="submit" class="btn btn-green">Сохранить</button>
            </div>
        </div>    
        <div class="clearfix"></div>    
    </div>    
</div>

