<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/admin"><?=heretic::$_config['titlePage']?></a>
                &rarr;
                <span>Права доступа</span>
            </div>
        </div>    
        <?php heretic::Widget('usersMenu', 'admin');?>
        <div class="white-block">
            <div class="padding-title title-big">
                <span>Права доступа</span>
                <div class="float-right">
                    <a href="/admin/createUsers" class="btn btn-green">Создать нового пользователя</a>
                </div>   
            </div>
            
            <div class="go-to-users">
                <a href="/admin/billing">Список всех пользователей</a>
            </div>
            
            <div class="success-flash block-padding">
                <?= heretic::getFlash('success');?>
            </div>    
             
            
            <div class="block-padding">
                
                <?php foreach ($arguments['allUsers'] as $key => $value) :?>
                    <div class="users-block bottom-line podat-form">
                        <div class="hidden id-user"><?=$value['id_user']?></div>
                        <div class="users-row">
                            <div class="label-users">
                                Логин
                            </div>    
                            <div class="value-users">
                                <?=$value['phone']?>
                            </div>    
                        </div>
                        <div class="users-row">
                            <div class="label-users">
                                Права
                            </div>
                            <div class="value-users">
                                <select class="form-select select-rules" name="rules">
                                    <option <?= ($value['rules'] == 2) ? 'selected="selected"' : "";?> value="2">Лишённый прав</option>
                                    <option <?= ($value['rules'] == 3) ? 'selected="selected"' : "";?> value="3">Модератор</option>
                                    <option <?= ($value['rules'] == 4) ? 'selected="selected"' : "";?> value="4">Администратор</option>
                                </select>    
                            </div>   
                        </div>
                        <div class="users-row">
                            <div class="label-users">
                                Описание
                            </div>  
                            <div class="value-users">
                                <?=$value['description']?>
                            </div>   
                        </div>
                        <div class="button-save-user">
                            <div class="rules-result-text"></div>
                            <div class="btn btn-green user-rules-save">Сохранить</div>
                        </div>    
                    </div>    
                <?php endforeach;?>
            </div>    
            
        </div>    
    </div>    
</div>