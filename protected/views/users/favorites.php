<div class="conteiner favorites-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/users">Личный кабинет</a>
                &rarr;
                <span>Избранное</span>
            </div>
        </div>   
        <?php heretic::Widget('usersMenu', 'users');?>
        <div class="white-block">
            <div class="padding-title title-big">Избранное</div>
            
            
            
            <?php  if(!empty($arguments)) : ?>
                <?php foreach ($arguments as $key => $value) : ?>
                    <div class="block-padding bottom-line">
                        <div class="result-img-wrap">
                            <div class="result-img">
                                <?php if((!empty($value['main_image']))&&(file_exists(heretic::$_path['images_thumb'].$value['main_image']))) :?>
                                    <img src="/<?= heretic::$_path['images_thumb'].$value['main_image'];?>">
                                <?php else :?>
                                    <img src="/<?= heretic::$_path['template'];?>img/no_images.jpg">
                                <?php endif;?>
                            </div>    
                        </div>    
                        <div class="result-text">
                            <div class="object-name"><a href="/objects/object/<?=$value['id']?>"><?=$value['type']?> <?= (!empty($value['public_square'])) ? $value['public_square'] . 'м&#178;' : '';?></a></div>
                            <div class="object-price"><?=$this->smarty_modifier_sum_convert($value['price'],'summa')?></div>
                            <div class="object-place"><?=$value['street']?></div>
                            <a href="/users/favorites/<?=$value['id']?>" class="btn btn-green">Убрать из избранного</a>
                        </div>
                    </div>    
                <?php endforeach;?>
            <?php else : ?>
                <div class="block-padding">
                    <p>У вас пока нет избранных объявлений</p>
                </div>    
            <?php endif;?>
        </div>
    </div>    
</div>

