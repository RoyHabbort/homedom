<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/moderation"><?=heretic::$_config['titlePage']?></a>
                &rarr;
                <a href="/moderation/banlist">Бан Лист</a>
                &rarr;
                <span>Биллинг</span>
            </div>
        </div>    
        <?php heretic::Widget('usersMenu', 'moder');?>
        <div class="white-block">
            <div class="padding-title title-big">Биллинг</div>
            
            <div class="download-billing">
                <a href="/moderation/loadBillingTable">Загрузить таблицу файлом</a>
            </div>
            <?php if(!empty($arguments['result'])) : ?>
            <div class="billing-table-wrap">
                <table class="billing-table">
                    <thead>
                        <tr>
                            <th class="c1">Город</th>
                            <th class="c2">Контактное лицо</th>
                            <th class="c3">Телефон</th>
                            <th class="c4">Email</th>
                            <th class="c5">Дата регистрации</th>
                            <th class="c6">Дата последнего визита</th>
                            <th class="c7">Количество объявлений</th>
                            <th class="c8">Статус</th>
                            <th class="c9">Коментарий администратора</th>
                        </tr>
                    </thead>    
                    <tbody>
                    <?php foreach ($arguments['result'] as $key => $value) : ?>
                        <tr data-user="<?=$value['id_user']?>">
                            <td><?=$value['city']?></td>
                            <td><?=$value['fio']?></td>
                            <td><?=$value['phone']?></td>
                            <td><?=$value['email']?></td>
                            <td><?=$value['date_registration']?></td>
                            <td><?=$value['date_visited']?></td>
                            <td <?=($value['count'] == 0) ? 'class="zero"' : '' ;?>><?=$value['count']?></td>
                            <td <?=($value['status'] == 'Забанен') ? 'class="red-cell"' : '' ;?>><?=$value['status']?></td>
                            <td class="comment-cell">
                                <span class="comment-val"><?=$value['comment']?></span>    
                                <div class="comment-cell-window">
                                    <textarea name="comment-text" class="comment-text"></textarea>
                                    <button type="button" class="btn btn-blue btn-add-comment">Добавить</button>
                                </div>    
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>    
            </div>    
            <?php else : ?>
            <div class="billing-table-error">
                Пользователей не найдено.
            </div>    
            <?php endif;?>
        </div>    
    </div>    
</div>

