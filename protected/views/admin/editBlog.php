<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/admin/"><?=heretic::$_config['titlePage']?></a>
                &rarr;
                <a href="/admin/blog">Подготовка к сделке</a>
                &rarr;
                <span>Редактировать запись</span>
            </div>
        </div>    
        <?php heretic::Widget('usersMenu', 'admin');?>
        <div class="white-block">
            <div class="btn-back" onclick="history.back()">
                Назад
            </div>
            <div class="padding-title title-big">
                <span>Редактировать запись</span>
                <div class="float-right">
                    <a href="/admin/deleteBlog/<?=$arguments['result']['id_blog']?>" class="btn btn-red">Удалить запись</a>
                </div>
            </div>
            
            <div class="success-flash block-padding">
                <?= heretic::getFlash('success');?>
            </div>  
            
            <div class="block-padding">
                <form  action="/admin/editBlog/<?=$arguments['result']['id_blog']?>"  method="post" name="add-blog" class="edit-form class-form podat-form" enctype="multipart/form-data">
                    
                    <div class="errors-text">
                        <?= (!empty($arguments['errors']['sql_error'])) ? $arguments['errors']['sql_error'] : '';?>
                    </div>
                    
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
                            <?= (!empty($arguments['errors']['metatitle'])) ? $arguments['errors']['metatitle'] : '';?>
                        </div>
                        <label>Metatitle:</label>
                        <input type="text" name="metatitle" class="form-input" value="<?= (!empty($arguments['result']['metatitle']))? $arguments['result']['metatitle'] : '';?>">
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="row-news row-blog-category">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['category'])) ? $arguments['errors']['category'] : '';?>
                        </div>
                        <label>Категория:</label>
                        <select class="form-select" name="category">
                            <option value="buyer">Покупателю</option>
                            <option value="seller">Продавцу</option>
                            <option value="tenant">Арендатору</option>
                            <option value="landlord">Арендодателю</option>
                        </select>    
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
                    
                    <div class="row-blog-edit">
                        <?php if(!empty($arguments['result']['files'])) : ?>
                        <div class="padding-bottom-20 file-wrap">
                            <a href="/<?=$arguments['result']['files']?>"><img alt="Скачать прикреплённый фаил" class="file-icon" src="/<?=  heretic::$_path['template']?>img/file.png"></a>
                        </div>
                        <?php endif;?>
                    </div>    
                    
                    <div class="row-blog-edit">
                        <div class="errors-text">
                            <?= (!empty($arguments['errors']['files'])) ? $arguments['errors']['files'] : '';?>
                        </div>
                        <label>Прикрепить фаил:</label>
                        <input type="file" accept="application/msword" name="files"  value="<?= (!empty($arguments['result']['files']))? $arguments['result']['image'] : '';?>">
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
                </form>    
            </div>
            
        </div>    
    </div>    
</div>

