<?php if($arguments['result']) :?>
    <?php foreach ($arguments['result'] as $key => $value) : ?>
        <div class="block-padding bottom-line">
            <a href="<?=$arguments['element_href']?><?=$value['id']?>" class="news-title"><?=$value['title']?></a>
            <span class="date-pole"><?=$this->converteDate($value['date'])?></span>
            <p class="text-preview"><?= heretic::previewText($value['text']);?></p>
        </div>
    <?php endforeach;?>
<?php else : ?>
    <div class="block-padding">На данный момент нет записей.</div>
<?php endif; ?>

