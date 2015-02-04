<?php foreach ($arguments['result'] as $key => $value) : ?>
                
<div class="result-block bottom-line">
    <div class="result-img-wrap">
        <div class="result-img">
            <a href="<?=$arguments['element_href']?><?=$value['id']?>">
                <?php if((!empty($value['main_image']))&&(file_exists(heretic::$_path['images_thumb'].$value['main_image']))) :?>
                    <img src="/<?= heretic::$_path['images_thumb'].$value['main_image'];?>">
                <?php else :?>
                    <img src="/<?= heretic::$_path['template'];?>img/no_images.jpg">
                <?php endif;?>
            </a>    
        </div>    
    </div>    
    <div class="result-text">
        <div class="object-name"><a href="<?=$arguments['element_href']?><?=$value['id']?>"><?=$value['type']?> <?= (!empty($value['public_square'])) ? $value['public_square'] . ' м&#178;' : '';?></a></div>
        <div class="object-price"> <?=$this->smarty_modifier_sum_convert($value['price'], 'summa')?></div>
        <div class="object-place"><?=$value['street']?></div>
    </div>
</div> 

<?php endforeach;?>
<div class='clearfix'></div>