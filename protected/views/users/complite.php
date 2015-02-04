<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/users">Личный кабинет</a>
                &rarr;
                <span>Получить код</span>
            </div>
        </div> 
        <?php heretic::Widget('usersMenu', 'users');?>
        <div class="white-block">
            <div class="block-padding">
                <?= (!empty($arguments['text'])) ? $arguments['text'] : '';?>
            </div>    
        </div>
    </div>    
</div>

