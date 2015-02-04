<?php if($arguments['result']) :?>
    <?php foreach ($arguments['result'] as $key => $value) : ?>
        <div class="block-padding bottom-line">
            <div class="float-left">
                <div class="blog-image-wrap">
                    <?php if((!empty($value['image']))&&(file_exists(heretic::$_path['images_thumb'].$value['image']))) :?>
                        <img src="/<?= heretic::$_path['images_thumb'].$value['image'];?>">
                    <?php else :?>
                        <img src="/<?= heretic::$_path['template'];?>img/no_images.jpg">
                    <?php endif;?>
                </div>    
            </div>   
            <a href="<?=$arguments['element_href']?><?=$value['id_blog']?>" class="news-title"><?=$value['title']?></a>
            <span class="date-pole"><?=$this->converteDate($value['date'])?></span>
            <p class="text-preview"><?= heretic::previewText($value['text']);?></p>
            <div class="clearfix"></div>
        </div>
    <?php endforeach;?>
<?php else : ?>
    <div class="block-padding">На данный момент нет записей.</div>
<?php endif; ?>

