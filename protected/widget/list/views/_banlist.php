<div class="ban-block">
    <?php if(!empty($arguments['result'])) : ?>
    <?php foreach ($arguments['result'] as $key => $value) : ?>
    <div class="ban-row bottom-line">
        <div class="users-row ">
            <div class="label-users">
                ID
            </div>
            <div class="value-users">
                #<span class="id-user"><?=$value['id_user']?></span>
            </div>
        </div>
        <div class="users-row">
            <div class="label-users">
                Контактные данные
            </div>
            <div class="value-users">
                <?=$value['fio']?>
            </div>
        </div>
        <div class="users-row">
            <div class="label-users">
                Телефон
            </div>
            <div class="value-users">
                <?=$value['phone']?>
            </div>
        </div>
        <div class="users-row ">
            <div class="label-users">
                Текущий статус
            </div>
            <div class="value-users ban-result" data-ban="<?=$value['rules']?>">
                <?= ($value['rules'] == 0) ? '<span class="ban-text">Забанен</span>' : '<span class="active-ban-text">Активный пользователь</span>' ;?>
            </div>
        </div>
        <div class="ban-button">
            <div class="ban-error"></div>
            <?php if($value['rules'] == 0) :?>
            <div class="btn btn-blue ban-click">
                Разбанить
            </div>
            <?php else :?>
            <div class="btn btn-red ban-click">
                Забанить
            </div>    
            <?php endif;?>    
            <div class="btn btn-red btn-del-user">
                Удалить
            </div>    
        </div>    
    </div>    
    <?php endforeach;?>
    <?php else : ?>
    <div class="">
        Пользователей не найдено
    </div>    
    <?php endif;?>
</div>    